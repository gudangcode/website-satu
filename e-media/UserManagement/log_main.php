<?
include_once "_includes/classes/users_class.php";
$userms = new userm ( $ses_userId );

@$_action = $comfunc->replacetext ( $_REQUEST ["data_action"] );

$paging_request = "main_page.php?method=log_aktifitas";
$list_page_request = "user_view.php";

// ==== buat grid ===//
$num_row = 15;
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

$gridHeader = array ("Username", "Aktifitas", "Tanggal");
$gridDetail = array ("1", "2", "3");
$gridWidth = array ("10", "60", "20");

$widthAksi = "5";
$iconEdit = "0";
$iconDel = "0";
$iconDetail = "0";
// === end grid ===//

switch ($_action) {
	case "getdetail" :
		$page_request = $acc_page_request;
		$fuser_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs_exist = $userms->users_view_data ( $fuser_id );
		$page_title = "Detail Pengguna";
		break;
	default :
		$recordcount = $userms->log_count ();
		$rs = $userms->log_viewlist ( $offset, $num_row );
		$page_title = "Daftar Pengguna";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
