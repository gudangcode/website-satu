<?
include_once "_includes/classes/users_class.php";

$userms = new userm ( $ses_userId );

@$_action = $comfunc->replacetext ( $_REQUEST ["data_action"] );

$paging_request = "main_page.php?method=par_group";
$acc_page_request = "group_acc.php";
$list_page_request = "user_view.php";

// ==== buat grid ===//
$num_row = 10;
@$str_page = $comfunc->replacetext ( $_GET ['page'] );
if (isset ( $str_page )) {
	if (is_numeric ( $str_page ) && $str_page != 0) {
		$noPage = $str_page;
	} else {
		$noPage = 1;
	}
} else {
	$noPage = 1;
}
$offset = ($noPage - 1) * $num_row;

$def_page_request = $paging_request . "&page=$noPage";

$grid = "grid.php";
$gridHeader = array (
		"Group" 
);
$gridDetail = array (
		"1" 
);
$gridWidth = array (
		"80" 
);
$widthAksi = "15";
$iconEdit = "1";
$iconDel = "1";
$iconDetail = "0";
// === end grid ===//

switch ($_action) {
	case "getadd" :
		$_nextaction = "postadd";
		$page_request = $acc_page_request;
		$page_title = "Tambah Group";
		break;
	case "getedit" :
		$_nextaction = "postedit";
		$page_request = $acc_page_request;
		$fdata_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs = $userms->group_data_viewlist ( $fdata_id );
		$page_title = "Ubah Group";
		break;
	case "postadd" :
		$fname = $comfunc->replacetext ( $_POST ["name"] );
		if ($fname != "") {
			$rs_nama = $userms->cek_nama_group ( $fname );
			$arr_nama = $rs_nama->FetchRow ();
			$fgroup_id = $arr_nama ['group_id'];
			$del_st = $arr_nama ['group_del_st'];
			if ($fgroup_id == "") {
				$fgroup_id = $userms->uniq_id ();
				$userms->group_add ( $fgroup_id, $fname );
				/*
				method parrent 1 = risk_penetapantujuan;risk_reviu;risk_fil_report
				method parrent 2 = risk_result;auditplan;auditassign;followupassign;reportaudit
				method parrent 3 = auditormgmt
				method parrent 4 = auditeemgmt
				**/
				for($data_parrent=1;$data_parrent<=4;$data_parrent++){
					$data_method = "";
					$data_parrent_id = $comfunc->replacetext ( $_POST ["parrent_" . $data_parrent] );
					if($data_parrent==1) $data_method = 'risk_penetapantujuan;risk_reviu;risk_fil_report';
					elseif($data_parrent==2) $data_method = 'risk_result;auditplan;auditassign;followupassign;reportaudit';
					elseif($data_parrent==3) $data_method = 'auditormgmt';
					elseif($data_parrent==4) $data_method = 'auditeemgmt';
					$userms->group_add_role_data ( $fgroup_id, $data_parrent, $data_method, $data_parrent_id );
				}
				$rs_menu = $comfunc->menu_list_view ();
				while ( $arr_menu = $rs_menu->FetchRow () ) {
					$menu_id = $comfunc->replacetext ( $_POST ["menu_" . $arr_menu ['menu_id']] );
					if (! empty ( $menu_id )) $userms->group_add_roles ( $fgroup_id, $menu_id );
				}
				
				$comfunc->js_alert_act ( 3 );
			} else {
				if ($del_st == "0") {
					$userms->update_group_del ( $fgroup_id );
					$userms->clean_role ( $fgroup_id );
					$userms->clean_role_data ( $fgroup_id );

					for($data_parrent=1;$data_parrent<=4;$data_parrent++){
						$data_method = "";
						$data_parrent_id = $comfunc->replacetext ( $_POST ["parrent_" . $data_parrent] );
						if($data_parrent==1) $data_method = 'risk_penetapantujuan;risk_reviu;risk_fil_report';
						elseif($data_parrent==2) $data_method = 'risk_result;auditplan;auditassign;followupassign;reportaudit';
						elseif($data_parrent==3) $data_method = 'auditormgmt';
						elseif($data_parrent==4) $data_method = 'auditeemgmt';
						$userms->group_add_role_data ( $fgroup_id, $data_parrent, $data_method, $data_parrent_id );
					}
					
					$rs_menu = $comfunc->menu_list_view ();
					while ( $arr_menu = $rs_menu->FetchRow () ) {
						$menu_id = $comfunc->replacetext ( $_POST ["menu_" . $arr_menu ['menu_id']] );
						if (! empty ( $menu_id ))
							$userms->group_add_roles ( $fgroup_id, $menu_id );
					}
					$comfunc->js_alert_act ( 1 );
				} else {
					$comfunc->js_alert_act ( 4, $fname );
				}
			}
		} else {
			$comfunc->js_alert_act ( 5 );
		}
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	case "postedit" :
		$fdata_id = $comfunc->replacetext ( $_POST ["data_id"] );
		$fname = $comfunc->replacetext ( $_POST ["name"] );
		if ($fname != "") {
			$rs_nama = $userms->cek_nama_group ( $fname, $fdata_id );
			$arr_nama = $rs_nama->FetchRow ();
			$fgroup_id = $arr_nama ['group_id'];
			$del_st = $arr_nama ['group_del_st'];
			if ($fgroup_id == "") {
				$userms->group_edit ( $fdata_id, $fname );
				$userms->clean_role ( $fdata_id );
				$userms->clean_role_data ( $fdata_id );
				/*
				method parrent 1 = risk_penetapantujuan;risk_reviu;risk_fil_report
				method parrent 2 = risk_result;auditplan;auditassign;followupassign;reportaudit
				method parrent 3 = auditormgmt
				method parrent 4 = auditeemgmt
				**/
				for($data_parrent=1;$data_parrent<=4;$data_parrent++){
					$data_method = "";
					$data_parrent_id = $comfunc->replacetext ( $_POST ["parrent_" . $data_parrent] );
					if($data_parrent==1) $data_method = 'risk_penetapantujuan;risk_reviu;risk_fil_report';
					elseif($data_parrent==2) $data_method = 'risk_result;auditplan;auditassign;followupassign;reportaudit';
					elseif($data_parrent==3) $data_method = 'auditormgmt';
					elseif($data_parrent==4) $data_method = 'auditeemgmt';
					$userms->group_add_role_data ( $fdata_id, $data_parrent, $data_method, $data_parrent_id );
				}
				
				$rs_menu = $comfunc->menu_list_view ();
				while ( $arr_menu = $rs_menu->FetchRow () ) {
					$menu_id = $comfunc->replacetext ( $_POST ["menu_" . $arr_menu ['menu_id']] );
					if (! empty ( $menu_id )) $userms->group_add_roles ( $fdata_id, $menu_id );
				}
				
				$comfunc->js_alert_act ( 1 );
			} else {
				if ($del_st == "0") {
					$userms->update_group_del ( $fgroup_id );
					$userms->group_delete ( $fdata_id );
					$userms->clean_role ( $fgroup_id );
					$userms->clean_role_data ( $fgroup_id );
						
					for($data_parrent=1;$data_parrent<=4;$data_parrent++){
						$data_method = "";
						$data_parrent_id = $comfunc->replacetext ( $_POST ["parrent_" . $data_parrent] );
						if($data_parrent==1) $data_method = 'risk_penetapantujuan;risk_reviu;risk_fil_report';
						elseif($data_parrent==2) $data_method = 'risk_result;auditplan;auditassign;followupassign;reportaudit';
						elseif($data_parrent==3) $data_method = 'auditormgmt';
						elseif($data_parrent==4) $data_method = 'auditeemgmt';
						$userms->group_add_role_data ( $fgroup_id, $data_parrent, $data_method, $data_parrent_id );
					}
					
					$rs_menu = $comfunc->menu_list_view ();
					$i=0;
					while ( $arr_menu = $rs_menu->FetchRow () ) {
						$i++; 
						echo $i;
						$menu_id = $comfunc->replacetext ( $_POST ["menu_" . $arr_menu ['menu_id']] );
						if (! empty ( $menu_id )) $userms->group_add_roles ( $fgroup_id, $menu_id );
					}
					exit();
					$comfunc->js_alert_act ( 1 );
				} else {
					$comfunc->js_alert_act ( 4, $fname );
				}
			}
		} else {
			$comfunc->js_alert_act ( 5 );
		}
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	case "getdelete" :
		$fdata_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$userms->group_delete ( $fdata_id );
		$comfunc->js_alert_act ( 2 );
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	default :
		$recordcount = $userms->group_count ();
		$rs = $userms->group_viewlist ( $offset, $num_row );
		$page_title = "Daftar Group";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
