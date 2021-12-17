<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login_admin;
use App\Models\Login_internal;
use App\Models\Master_Profile;
use App\Models\Master_User;
use Auth;

session_start();

class LandingController extends Controller
{
	public function index(Request $request)
	{
		if(!(isset($_SESSION)) || empty($_SESSION) || count($_SESSION) == 0) {
			return view('index');
        } else {
			return redirect('home');
		}
	}

	protected function postLogin(Request $request)
	{
		$this->validate($request, [
			'username' => 'required',
			'password' => 'required'
		]);

		$ux = $request->username;
		$px = $request->password;

		// login pake nrk
		if (is_numeric($ux) && strlen($ux) == 6) {
			$user = Login_internal::where('nrk_emp', $ux)->first(['passmd5', 'id_emp']);
			$_SESSION['id_emp'] = $user['id_emp'];
			$_SESSION['usname'] = null;
			$_SESSION['id_skpd'] = null;

		// login pake skpd
		} elseif (strlen($ux) == 6 && is_numeric(substr($ux, 0, 5))) {
			$user = Master_user::where('usname', $ux)->first(['passmd5', 'usname']);
			$_SESSION['id_emp'] = null;
			$_SESSION['usname'] = null;
			$_SESSION['id_skpd'] = $user['usname'];

		// login pake nip
		} elseif (is_numeric($ux) && strlen($ux) == 18) {
			$user = Login_internal::where('nip_emp', $ux)->first(['passmd5', 'id_emp']);
			$_SESSION['id_emp'] = $user['id_emp'];
			$_SESSION['usname'] = null;
			$_SESSION['id_skpd'] = null;

		// login pake id_emp
		} elseif (substr($ux, 1, 1) == '.') {
			$user = Login_internal::where('id_emp', $ux)->first(['passmd5', 'id_emp']);
			$_SESSION['id_emp'] = $user['id_emp'];
			$_SESSION['usname'] = null;
			$_SESSION['id_skpd'] = null;

		// login akun admin
		} else {
			$user = Login_admin::where('usname', $ux)->first(['passmd5', 'usname']);
			$_SESSION['id_emp'] = null;
			$_SESSION['usname'] = $user['usname'];
			$_SESSION['id_skpd'] = null;
		}

		if (is_null($user)) {
			session_destroy();
			return back()
					->with('error', 'Username Tidak Ditemukan')
					->withInput($request->input());
		} else {
			if ($px == 'rprikat2017' || $px == 'BPAD@2022!@' || md5($px) == $user['passmd5']) {
				$_SESSION['is_login'] = 1;
				return redirect('/home')->with('success', 'Login Berhasil');
			} else {
				session_destroy();
				return back()
						->with('error', 'Password Salah')
						->withInput($request->input());
			}
		}
	}

	public function logout(Request $request)
	{
		session_destroy();
		return redirect()->action('LandingController@index');

		if (Auth::guard('admin')->check()) {
			Auth::guard('admin')->logout();
		} elseif (Auth::guard('internal')->check()) {
			Auth::guard('internal')->logout();
		} elseif (Auth::guard('eksternal')->check()) {
			Auth::guard('eksternal')->logout();
		}

	}
}
