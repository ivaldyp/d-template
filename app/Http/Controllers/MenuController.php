<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;

use App\Models\Sec_menu;

session_start();

class MenuController extends Controller
{
    public function display_roles($query, $idgroup, $parent, $level = 0)
    {
        if ($parent == 0) {
			$sao = "(sao = 0 or sao is null)";
		} else {
			$sao = "(sao = ".$parent.")";
		}

		$query = DB::select( DB::raw("
					SELECT *
					FROM bpadbmd.dbo.sec_menu
					WHERE $sao
					ORDER BY urut, ids
				"));
		$query = json_decode(json_encode($query), true);

		$result = '';

		if (count($query) > 0) {
			foreach ($query as $menu) {
				// if (strlen($menu['url']) > 50) {
				// 	$url = substr($menu['url'], 0, 47);
				// } else {
				// 	$url = $menu['url'];
				// }
				$padding = ($level * 20) + 8;
				$result .= '<tr>
								<td>'.$level.'</td>
								<td>'.$menu['ids'].'</td>
								<td style="padding-left:'.$padding.'px; '.(($level == 0) ? 'font-weight: bold;"' : '').'">'.$menu['desk'].' '.(($menu['child'] == 1)? '<i class="fa fa-arrow-down"></i>' : '').'</td>
								<td>'.($menu['iconnew'] ? $menu['iconnew'] : '-').'</td>
								<td>'.($menu['urlnew'] ? (strlen($menu['urlnew']) > 30 ? substr($menu['urlnew'],0,27) . " ..." : $menu['urlnew'] ) : '-').'</td>
								<td style="vertical-align:middle;">'.intval($menu['urut']).'</td>
								<td style="vertical-align:middle;">'.(($menu['child'] == 1)? '<i style="color:green;" class="fa fa-check"></i>' : '<i style="color:red;" class="fa fa-times"></i>').'</td>
								<td style="vertical-align:middle;">'.(($menu['tampilnew'] == 1)? '<i style="color:green;" class="fa fa-check"></i>' : '<i style="color:red;" class="fa fa-times"></i>').'</td>
								
								'.(($_SESSION['usname'] != '') ? 
									'<td style="vertical-align:middle;"><button type="button" class="btn btn-sm btn-success btn-insert" data-toggle="modal" data-target="#modal-insert" data-ids="'.$menu['ids'].'" data-desk="'.$menu['desk'].'"><i class="fa fa-plus"></i></button></td>

									<td style="vertical-align:middle;">
                                        <button type="button" class="btn btn-sm btn-info btn-update" data-toggle="modal" data-target="#modal-update" data-ids="'.$menu['ids'].'" data-desk="'.$menu['desk'].'" data-child="'.$menu['child'].'" data-iconnew="'.$menu['iconnew'].'" data-urlnew="'.$menu['urlnew'].'" data-urut="'.$menu['urut'].'" data-tampilnew="'.$menu['tampilnew'].'" data-zket="'.$menu['zket'].'" data-is_bpad="'.$menu['is_bpad'].'" data-is_admin="'.$menu['is_admin'].'" data-is_skpd="'.$menu['is_skpd'].'"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#modal-delete" data-ids="'.$menu['ids'].'" data-sao="'.$menu['sao'].'" data-desk="'.$menu['desk'].'"><i class="fa fa-trash"></i></button>
									</td>'
								: '' ).'
								
							</tr>';

				if ($menu['child'] == 1) {
					$result .= $this->display_roles($query, $idgroup, $menu['ids'], $level+1);
				}
			}
		}
		return $result;
    }

    public function menuall(Request $request)
	{
        if(!(isset($_SESSION['user_data']))) {
            return redirect('/')->with('error', 'Silahkan melakukan login ulang');
        }

        $all_menu = [];

		$menus = $this->display_roles($all_menu, $request->name, 0);

        // $menus = Sec_menu::
        //             where('sts', 1)
        //             ->orderByRaw('coalesce(urut, ids, sao), sao, ids, urut')
        //             ->get();
		
		return view('pages.bmdmenu.menu')
				->with('menus', $menus);
	}

    public function forminsertmenu(Request $request)
	{
		if(!(isset($_SESSION['user_data']))) {
            return redirect('/')->with('error', 'Silahkan melakukan login ulang');
        }

		$maxids = Sec_menu::max('ids');
		$urut = intval(Sec_menu::where('sao', $request->sao)
				->max('urut'));

		if ($request->urut) {
			$urut = $request->urut;
		} else {
			if (is_null($urut)) {
				$urut = 1;
			} else {
				$urut = $urut + 1;
			}
		}
		is_null($request->desk) ? $desk = '' : $desk = $request->desk;
		is_null($request->zket) ? $zket = '' : $zket = $request->zket;
		$request->sao == 0 ? $sao = '' : $sao = $request->sao;  

		$insert = [
				'sts'       => 1,
				'uname'     => $_SESSION['user_data']['usname'],
				'tgl'       => date('Y-m-d H:i:s'),
				'ip'        => '',
				'logbuat'   => '',
				'suspend'   => '',
				'urut'      => $urut,
				'desk'      => $desk,
				'validat'   => '',
				'isi'       => '',
				'ipserver'  => '',
				'child'     => 0,
				'sao'       => $sao,
				'tipe'      => '',
				'icon'      => '',
				'zfile'     => '',
				'zket'      => $zket,
				'iconnew'   => $request->iconnew,
				'urlnew'    => $request->urlnew,
				'tampilnew' => $request->tampilnew,
                'is_bpad'   => (isset($request->is_bpad) ? '1' : null),
                'is_skpd'   => (isset($request->is_skpd) ? '1' : null),
                'is_admin'   => (isset($request->is_admin) ? '1' : null),
			];

		if (Sec_menu::insert($insert) && $sao > 0) {
			$query = Sec_menu::
						where('ids', $sao)
						->update([
							'child' => 1,
						]);
		}

		return redirect('/menu/menu')
					->with('success', 'Menu '.$request->desk.' berhasil ditambah');
	}

    public function formupdatemenu(Request $request)
	{
		if(!(isset($_SESSION['user_data']))) {
            return redirect('/')->with('error', 'Silahkan melakukan login ulang');
        }

		Sec_menu::
			where('ids', $request->ids)
			->update([
				'desk'      => $request->desk,
				'zket'      => $request->zket,
				'urut'      => $request->urut,
				'iconnew'   => $request->iconnew,
				'urlnew'    => $request->urlnew,
				'tampilnew' => $request->tampilnew,
                'is_bpad'   => (isset($request->is_bpad) ? '1' : null),
                'is_skpd'   => (isset($request->is_skpd) ? '1' : null),
                'is_admin'   => (isset($request->is_admin) ? '1' : null),
			]);

		return redirect('/menu/menu')
					->with('success', 'Menu '.$request->desk.' berhasil diubah');
	}

    public function deleteLoopMenu($ids)
	{
		$childids = Sec_menu::
					where('sao', $ids)
					->get('ids');

		foreach ($childids as $id) {
			$this->deleteLoopMenu($id['ids']);
			Sec_menu::
				where('sao', $id['ids'])
				->delete();
		}

		return 1;
	}

    public function formdeletemenu(Request $request)
    {
        if(!(isset($_SESSION['user_data']))) {
            return redirect('/')->with('error', 'Silahkan melakukan login ulang');
        }

		// hapus menu dari tabel menu
		$this->deleteLoopMenu($request->ids);

		$delete = Sec_menu::
					where('ids', $request->ids)
					->delete();
		
		// cek if menu masih punya child
		$cekchild = Sec_menu::
					where('sao', $request->sao)
					->count();

		if ($cekchild == 0) {
			$updatechild = Sec_menu::
							where('ids', $request->sao)
							->update([
								'child' => 0,
							]);
		}

		return redirect('/menu/menu')
					->with('success', 'Menu '.$request->desk.' berhasil dihapus');
    }
}
