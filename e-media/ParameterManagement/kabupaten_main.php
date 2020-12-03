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
	$key_search = "";
	$val_search = "";
	$val_method = "";
}

$paging_request = "main_page.php?method=par_kabupaten";
$acc_page_request = "kabupaten_acc.php";
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
$gridHeader = array ("Kabupaten/Kota", "Propinsi", "Status");
$gridDetail = array ("kabupaten_name", "propinsi_name", "active_st");
$gridWidth = array ("35", "35", "10");

$key_by = array ("Kabupaten/Kota", "Propinsi");
$key_field = array ("kabupaten_name", "propinsi_name");

$widthAksi = "15";
$iconEdit = "1";
$iconDel = "1";
$iconDetail = "0";
// === end grid ===//

switch ($_action) {
	case "getadd" :
		$_nextaction = "postadd";
		$page_request = $acc_page_request;
		$page_title = "Add New Kabupaten/Kota";
		break;
	case "getedit" :
		$_nextaction = "postedit";
		$page_request = $acc_page_request;
		$fdata_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs = $params->kabupaten_data_viewlist ( $fdata_id );
		$page_title = "Modify Kabupaten/Kota";
		break;
	case "postadd" :
		$fpropinsi = $comfunc->replacetext ( $_POST ["propinsi"] );
		$fname = $comfunc->replacetext ( $_POST ["kabupaten"] );
		if ($fpropinsi != "" && $fname != "") {
			$rs_cek = $params->cek_nama_kabupaten ( $fname );
			$arr_cek = $rs_cek->FetchRow ();
			$fkabupaten_id = $arr_cek ['kabupaten_id'];
			$del_st = $arr_cek ['kabupaten_del_st'];
			if ($fkabupaten_id == "") {
				$params->kabupaten_add ( $fpropinsi, $fname );
				$comfunc->js_alert_act ( 3 );
			} else {
				if ($del_st == "0") {
					$params->update_kabupaten_del ( $fkabupaten_id, $fpropinsi, $fname );
					$comfunc->js_alert_act ( 3 );
				} else {
					$comfunc->js_alert_act ( 4, $fname);
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
		$fpropinsi = $comfunc->replacetext ( $_POST ["propinsi"] );
		$fname = $comfunc->replacetext ( $_POST ["kabupaten"] );
		$fstatus = $comfunc->replacetext ( $_POST["active_st"] );
		if ($fpropinsi != "" && $fname != "") {
			$rs_cek = $params->cek_nama_kabupaten ( $fname );
			$arr_cek = $rs_cek->FetchRow ();
			//$fkabupaten_id = $arr_cek ['kabupaten_id'];
			//$del_st = $arr_cek ['kabupaten_del_st'];

			if ($fdata_id != "") {
				$params->kabupaten_edit ( $fdata_id, $fpropinsi, $fname, $fstatus );
				$comfunc->js_alert_act ( 1 );
			} else {
			  $comfunc->js_alert_act ( 5 );
			}
		} else {
			$comfunc->js_alert_act ( 5);
		}
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	case "getdelete" :
		$fdata_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$params->kabupaten_delete ( $fdata_id );
		$comfunc->js_alert_act ( 2 );
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	default :
		$recordcount = $params->kabupaten_count ($key_search, $val_search, $key_field);
		$rs = $params->kabupaten_view_grid ( $key_search, $val_search, $key_field, $offset, $num_row );
		$page_title = "List of Kabupaten/Kota";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
