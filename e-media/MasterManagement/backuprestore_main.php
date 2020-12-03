<?
include_once "_includes/classes/backuprestore_class.php";
$backuprestores = new backuprestore ( $ses_userId );

@$_action = $comfunc->replacetext ( $_REQUEST ["data_action"] );

$paging_request = "main_page.php?method=backuprestore";
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
		"Username",
		"Tanggal Backup" 
);
$gridDetail = array (
		"1",
		"2"
);
$gridWidth = array (
		"40", 
		"40"
);
$widthAksi = "15";
$iconEdit = "0";
$iconDel = "0";
$iconDetail = "0";
// === end grid ===//

switch ($_action) {
	case "restore_database" :
		$fdata_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$nama_file = $backuprestores->backup_viewlist($fdata_id);
		$backuprestores->restore_database($nama_file);
		$date = $comfunc->date_db(date("d-m-Y H:i:s"));
		$backuprestores->backup_update_restore ( $fdata_id, $date );
		$comfunc->js_alert_act ( 12 );
		?>
		<script>window.open('<?=$def_page_request?>', '_self');</script>
		<?
		$page_request = "blank.php";
		break;
	case "backup_database" :
		$nama_file = $comfunc->date_db(date("d-m-Y H:i:s"));
		$backuprestores->backup_add_history ( $nama_file );
		$backuprestores->backupdatabase ( $nama_file );
		$comfunc->js_alert_act ( 11 );
		?>
		<script>window.open('<?=$def_page_request?>', '_self');</script>
		<?
		$page_request = "blank.php";
		break;
	default :
		$recordcount = $backuprestores->backup_count ();
		$rs = $backuprestores->backup_view_grid ( $offset, $num_row );
		$page_title = "Daftar Backup Database";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
