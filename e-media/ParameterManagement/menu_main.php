<?
include_once "_includes/classes/param_class.php";

$params = new param ( $ses_userId );

@$_action = $comfunc->replacetext ( $_REQUEST ["data_action"] );
$parrent = $comfunc->replacetext ( $_REQUEST ["parrent"] );

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

$paging_request = "main_page.php?method=par_menu&parrent=" . $parrent;
$acc_page_request = "menu_acc.php";
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

$grid = "grid_menu.php";
$gridHeader = array ("Menu", "Link", "Method", "Nama File", "Sort", "Status", "Jml Sub Menu");
$gridDetail = array ("menu_name", "menu_link", "menu_method", "menu_file", "menu_sort", "status", "jml_sub");
$gridWidth = array ("15", "21", "10", "22", "5", "5", "8");

$key_by = array ("Menu", "Link", "Method", "Nama File", "Status");
$key_field = array ("a.menu_name", "a.menu_link", "a.menu_method", "a.menu_file", "status");

$widthAksi = "15";
$iconEdit = "1";
$iconDel = "1";
$iconDetail = "0";
// === end grid ===//

switch ($_action) {
	case "getadd" :
		$_nextaction = "postadd";
		$page_request = $acc_page_request;
		$page_title = "Tambah Menu";
		break;
	case "getedit" :
		$_nextaction = "postedit";
		$page_request = $acc_page_request;
		$fdata_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs = $params->menu_data_viewlist ( $fdata_id );
		$page_title = "Ubah Menu";
		break;
	case "postadd" :
		$fparrent_id = $comfunc->replacetext ( $_POST ["parrent_id"] );
		$fname = $comfunc->replacetext ( $_POST ["name"] );
		$flink = $comfunc->replacetext ( $_POST ["link"] );
		$fmethod = $comfunc->replacetext ( $_POST ["method"] );
		$ffile = $comfunc->replacetext ( $_POST ["file"] );
		$fsort = $comfunc->replacetext ( $_POST ["sort"] );
		$fstatus = $comfunc->replacetext ( $_POST ["status"] );
		if ($fname != "" && $flink != "" && $fmethod != "" && $ffile != "" && $fsort != "" && $fstatus != "") {
			$params->menu_add ( $fparrent_id, $fname, $flink, $fmethod, $ffile, $fsort, $fstatus );
			$comfunc->js_alert_act ( 3 );
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
		$flink = $comfunc->replacetext ( $_POST ["link"] );
		$fmethod = $comfunc->replacetext ( $_POST ["method"] );
		$ffile = $comfunc->replacetext ( $_POST ["file"] );
		$fsort = $comfunc->replacetext ( $_POST ["sort"] );
		$fstatus = $comfunc->replacetext ( $_POST ["status"] );
		if ($fname != "" && $flink != "" && $fmethod != "" && $ffile != "" && $fsort != "" && $fstatus != "") {
			$params->menu_edit ( $fdata_id, $fname, $flink, $fmethod, $ffile, $fsort, $fstatus );
			$comfunc->js_alert_act ( 1 );
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
		$params->menu_delete ( $fdata_id );
		$comfunc->js_alert_act ( 2 );
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	default :
		$recordcount = $params->menu_count ( $parrent, $key_search, $val_search, $key_field);
		$rs = $params->menu_grid ( $parrent, $key_search, $val_search, $key_field, $offset, $num_row );
		$page_title = "Daftar Menu";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
