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
use App\Models\Master_Profile;
use App\Models\Master_User;

use App\Traits\TraitsCheckActiveMenu;

session_start();

class HomeController extends Controller
{
	use TraitsCheckActiveMenu;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function display_menus($query, $parent, $level = 0, $idgroup)
	{
		if ($parent == 0) {
			$sao = "(sao = 0 or sao is null or sao like '')";
		} else {
			$sao = "(sao = ".$parent.")";
		}
							
		$query = DB::select( DB::raw("
					SELECT *
					FROM bpadbmd.dbo.sec_menu
					WHERE bpadbmd.dbo.sec_menu.tampilnew = 1
					AND $sao
					AND $idgroup
					ORDER BY bpadbmd.dbo.sec_menu.urut
					"));
		$query = json_decode(json_encode($query), true);

		$result = '';

		$link = '';
		// $arrLevel = ['<ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" id="side-menu" data-widget="treeview" role="menu" data-accordion="false">', '<ul class="nav nav-treeview nav-second-level">', '<ul class="nav nav-treeview nav-third-level">', '<ul class="nav nav-treeview nav-fourth-level">', '<ul class="nav nav-treeview nav-fifth-level">'];
		$arrLevel = ['<ul class="nav nav-pills nav-sidebar flex-column" id="side-menu" data-widget="treeview" role="menu" data-accordion="false">', '<ul class="nav nav-treeview nav-second-level">', '<ul class="nav nav-treeview nav-third-level">', '<ul class="nav nav-treeview nav-fourth-level">', '<ul class="nav nav-treeview nav-fifth-level">'];

		if (count($query) > 0) {

			$result .= $arrLevel[$level];

			// if ($level == 0) {
			// 	$result .= '<li id="li_bmddki"> <a href="/bmddki" class="waves-effect"> <i class="fa fa-globe fa-fw"></i> <span class="hide-menu">Portal BPAD</span></a></li>';
			// }
		
			foreach ($query as $menu) {
				if (is_null($menu['urlnew'])) {
					$link = 'javascript:void(0)';
				} elseif (substr($menu['urlnew'], 0, 4) == 'http') {
					$link = $menu['urlnew'];
				} else {
					if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
						$link = "https"; 
					else
						$link = "http"; 
					  
					$link .= "://";       
					$link .= $_SERVER['HTTP_HOST'];
                    $link .= "/bmddki"; 
					$link .= $menu['urlnew'];
				}

				if ($menu['child'] == 0) {
					$result .= '<li class="nav-item menu-li-'.$menu['ids'].'"> <a href="'.$link.'" class="waves-effect nav-link menu-a-'.$menu['ids'].' "><i class="fa '. (($menu['iconnew'])? $menu['iconnew'] :'fa-caret-right').' nav-icon"></i> <p>'.$menu['desk'].'</p></a></li>';
					
				} elseif ($menu['child'] == 1) {
					$result .= '<li class="nav-item menu-li-'.$menu['ids'].'"> <a href="'.$link.'" class="waves-effect nav-link menu-a-'.$menu['ids'].' "><i class="fa '. (($menu['iconnew'])? $menu['iconnew'] :'fa-caret-right').' nav-icon"></i> <p>'.$menu['desk'].'<i class="fa fa-angle-left right"></i></p></a>';
					
					$result .= $this->display_menus($query, $menu['ids'], $level+1, $idgroup);
					
					$result .= '</li>';
				}
			}
			
			$result .= '</ul>';
		}
		return $result;
	}
	
    public function index(Request $request)
    {
		
		$activemenus = $this->checkactivemenu(config('app.name'), url()->current()); 
        
		if(!(isset($_SESSION['is_login']))) {
            return redirect()
					->action('LandingController@index')
					->with('error', 'Silahkan melakukan login ulang');
        }

        if (isset($_SESSION['id_emp']) && $_SESSION['id_emp'] != '') {
			$iduser = $_SESSION['id_emp'];
            $idgroup = "(is_bpad = 1)";

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
			$iduser = substr($_SESSION['id_skpd'], 0, 5);
            $idgroup = "(is_skpd = 1)";

			$user_data = Master_profile::
						where('id_kolok', $iduser)
						->first();
        } else {
            $iduser = $_SESSION['usname'];
            $idgroup = "(is_admin = 1)";

			$user_data = Sec_logins::
                where('usname', $iduser)
            ->first(['usname']);
		}

        $_SESSION['bmd_data'] = $user_data;

        $all_menu = [];

		$menus = $this->display_menus($all_menu, 0, 0, $idgroup);

        $_SESSION['bmd_menus'] = $menus;
		
        return view('home')
				->with('activemenus', $activemenus);
    }
}