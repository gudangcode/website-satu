<?
include_once "_includes/login_history.php";

$fullPath = $comfunc->baseurl('user_manual').$comfunc->replacetext($_GET["namafile"]);

if (file_exists($fullPath)) {
    header('Content-Description: File Transfer');
	switch($fformat_file){
		case "pdf";
			header('Content-Type: application/octet-stream');
		break;
		case "csv";
			header("Content-type: text/csv");
		break;
		case "xls";
			header("Content-type: application/vnd.ms-excel");
		break;
		case "xlsx";
			header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		break;
		case "txt";
			header("Content-type: text/plain");
		break;
		case "doc";
			header("Content-type: application/msword");
		break;
		case "docx";
			header("Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
		break;
	}
    header('Content-Disposition: attachment; filename='.basename($fullPath));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    #header('Cache-Control: ');
    #header('Pragma: ');
    header('Content-Length: ' . filesize($fullPath));
    set_time_limit(0);
    ob_end_flush();
    @readfile($fullPath);
    exit();
}
?>