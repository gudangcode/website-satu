<?
include_once "_includes/classes/param_class.php";

$params = new param ( $ses_userId );

@$_action = $comfunc->replacetext ( $_REQUEST ["data_action"] );

if(isset($_POST["val_search"])){
	@session_start();
	$_SESSION['key_search'] = $comfunc->replacetext($_POST["key_search"]);
	$_SESSION['val_search'] = $comfunc->replacetext($_POST["val_search"]);
	$_SESSION['val_method'] = $method;
}
$key_search = @$_SESSION['key_search'];
$val_search = @$_SESSION['val_search'];
$val_method = @$_SESSION['val_method'];

if(@$method!=@$val_method){
	unset($_SESSION['key_search']);
	unset($_SESSION['val_search']);
	unset($_SESSION['val_method']);
}

$paging_request = "main_page.php?method=par_propinsi";
$acc_page_request = "propinsi_acc.php";
$list_page_request = "param_view.php";

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
$gridHeader = array ("Propinsi");
$gridDetail = array ("propinsi_name");
$gridWidth = array ("80");

$key_by = array ("Propinsi");
$key_field = array ("propinsi_name");

$widthAksi = "15";
$iconEdit = "1";
$iconDel = "1";
$iconDetail = "0";
// === end grid ===//

switch ($_action) {
	case "getadd" :
		$_nextaction = "postadd";
		$page_request = $acc_page_request;
		$page_title = "Add New Province";
		break;
	case "getedit" :
		$_nextaction = "postedit";
		$page_request = $acc_page_request;
		$fdata_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs = $params->propinsi_data_viewlist ( $fdata_id );
		$page_title = "Modify Province";
		break;
	case "postadd" :
		$fname = $comfunc->replacetext ( $_POST ["name"] );
		if ($fname != "") {
			$rs_nama = $params->cek_nama_propinsi ( $fname );
			$arr_nama = $rs_nama->FetchRow ();
			$fpropinsi_id = $arr_nama ['propinsi_id'];
			$del_st = $arr_nama ['propinsi_del_st'];
			if ($fpropinsi_id == "") {
				$params->propinsi_add ( $fname );
				$comfunc->js_alert_act ( 3 );
			} else {
				if ($del_st == "0") {
					$params->update_propinsi_del ( $fpropinsi_id );
					$comfunc->js_alert_act ( 3 );
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
			$rs_nama = $params->cek_nama_propinsi ( $fname, $fdata_id );
			$arr_nama = $rs_nama->FetchRow ();
			$fpropinsi_id = $arr_nama ['propinsi_id'];
			$del_st = $arr_nama ['propinsi_del_st'];
			if ($fpropinsi_id == "") {
				$params->propinsi_edit ( $fdata_id, $fname );
				$comfunc->js_alert_act ( 1 );
			} else {
				if ($del_st == "0") {
					$params->update_propinsi_del ( $fpropinsi_id );
					$params->propinsi_delete ( $fdata_id );
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
		$params->propinsi_delete ( $fdata_id );
		$comfunc->js_alert_act ( 2 );
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	default :
		$recordcount = $params->propinsi_count ($key_search, $val_search, $key_field);
		$rs = $params->propinsi_view_grid ( $key_search, $val_search, $key_field, $offset, $num_row );
		$page_title = "List of Province";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
