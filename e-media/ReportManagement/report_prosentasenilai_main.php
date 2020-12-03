<?
include_once "_includes/classes/report_prosentasenilai_class.php";
$report_prosentasenilaims = new reportprosentasenilai ( $ses_userId );

@$_action = $comfunc->replacetext ( $_REQUEST ["data_action"] );

if(isset($_POST["date1"]) && isset($_POST["date2"])){
	@session_start();
	$_SESSION['date1'] = $comfunc->replacetext($_POST["date1"]);
	$_SESSION['date2'] = $comfunc->replacetext($_POST["date2"]);
	$_SESSION['media'] = $comfunc->replacetext($_POST["media"]);
}

$date1 = @$_SESSION['date1'];
$date2 = @$_SESSION['date2'];
$media = @$_SESSION['media'];


$gridHeader = array ("Nama Media", "Penanggung Jawab Wilayah", "Nilai Positif", "Nilai Negatif","Nilai Advertorial","Prosentase");
$gridDetail = array ("1","2", "3","4","5","6");
$gridWidth = array ( "7","7","7","7");


$paging_request = "main_page.php?method=mstrproduct";
$acc_page_request = "report_prosentasenilai_acc.php";
$list_page_request = "report_prosentasenilai_view.php";

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

$recordcount = $report_prosentasenilaims->report_prosentasenilai_count ($date1, $date2, $media);
$rs = $report_prosentasenilaims->report_prosentasenilai_viewlist ( $date1, $date2, $media, $offset, $num_row, "");
$page_title = "Laporan Prosentase Nilai";
$page_request = $list_page_request;

include_once $page_request;
?>
