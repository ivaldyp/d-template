<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;

use App\Models\Emp_data;
use App\Models\Emp_jab;
use App\Models\Glo_org_unitkerja;
use App\Models\Sec_logins;

session_start();

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(Request $request)
    {
        if(!(isset($_SESSION['is_login']))) {
            return redirect('/')->with('error', 'Silahkan melakukan login ulang');
        }

        if (isset($_SESSION['id_emp']) && $_SESSION['id_emp'] != '') {
			$iduser = $_SESSION['id_emp'];

			$user_data = DB::select( DB::raw("
                select id_emp, nm_emp, kd_unit
                from bpaddtfake.dbo.emp_data a
                join bpaddtfake.dbo.emp_jab tbjab on tbjab.ids = (SELECT TOP 1 ids FROM bpaddtfake.dbo.emp_jab WHERE emp_jab.noid = a.id_emp and emp_jab.sts='1' ORDER BY tmt_jab DESC)
                join bpaddtfake.dbo.glo_org_unitkerja tbunit on tbunit.kd_unit = (SELECT TOP 1 idunit FROM bpaddtfake.dbo.glo_org_unitkerja where tbunit.kd_unit = tbjab.idunit)
                where a.ked_emp = 'AKTIF'
                and a.sts = 1
                and a.id_emp = '$iduser'
                and a.id_emp = tbjab.noid
                and tbjab.sts = 1
            "))[0];
            $user_data = json_decode(json_encode($user_data), true);

        } elseif (isset($_SESSION['id_skpd']) && $_SESSION['id_skpd'] != '') {	
		} else {
			$iduser = $_SESSION['usname'];;

			$user_data = Sec_logins::
                where('usname', $iduser)
            ->first(['usname']);
		}

        $_SESSION['user_data'] = $user_data;

        return view('home');
    }
}
