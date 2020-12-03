<?
include_once "_includes/classes/tx_negativenews_class.php";
$tx_negativenewsms = new txnegativenews ( $ses_userId );

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

$paging_request = "main_page.php?method=txnegativenews";
$acc_page_request = "tx_negativenews_acc.php";
$list_page_request = "tx_negativenews_view.php";

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
$gridHeader = array ("Media", "Judul Berita", "Tanggal Terbit/Tayang", "Poin");
$gridDetail = array ("9","1", "2","7");
$gridWidth = array ("7", "12","7","3");

$key_by = array ("Judul Berita", "Nama Media");
$key_field = array ("a.news_title", "b.media_name");

$widthAksi = "13";
$iconEdit = "1";
$iconDel = "1";
$iconDetail = "0";
// === end grid ===//

switch ($_action) {
	case "getadd" :
		$_nextaction = "postadd";
		$page_request = $acc_page_request;
		$page_title = "Tambah Berita Positif";
		break;
	case "getedit" :
		$_nextaction = "postedit";
		$page_request = $acc_page_request;
		$fmediaid = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs = $tx_negativenewsms->tx_negativenews_view_data ( $fmediaid );

		$arr = $rs->FetchRow ();
		$page_title = "Modify Berita Positif";
		break;
	case "getdetail" :
		$page_request = $acc_page_request;
		$fuser_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs_exist = $tx_negativenewsms->master_provider_viewlist ( $fuser_id );
		$page_title = "Detail Berita Positif";
		break;
	case "postadd" :
		$fnewsid = $tx_negativenewsms->uniq_id();

		$fnewstitle = $comfunc->replacetext ( $_POST ["news_title"] );
		$fnewsbroadcastdate = $comfunc->replacetext ( $_POST ["news_broadcastdate"] );
		$fnewspage = $comfunc->replacetext ( $_POST ["news_page"] );
		$fnewssize = $comfunc->replacetext ( $_POST ["news_size"] );
		$fnewswriter = $comfunc->replacetext ( $_POST ["news_writer"] );
		$fnewsimage = $comfunc->UploadFiles("Upload/DataBeritaNegatif/".$fnewsid, "beritanegatif", $_FILES);
		$fpoint = $comfunc->replacetext ( $_POST ["news_point"] );
		$fmediaid = $comfunc->replacetext ( $_POST["media_id"]);
		$fnewsurl = $comfunc->replacetext ( $_POST["news_url"]);

		if ($fnewstitle != "" && $fmediaid != "") {
			$tx_negativenewsms->tx_negativenews_add ( $fnewsid, $fnewstitle, $fnewsbroadcastdate,  $fnewspage, 
			$fnewssize, $fnewswriter, $fnewsimage, $fpoint, $fmediaid, $fnewsurl, $ses_userName );
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
		$fnewsid = $comfunc->replacetext ( $_POST ["data_id"] );
		$fnewstitle = $comfunc->replacetext ( $_POST ["news_title"] );
		$fnewsbroadcastdate = $comfunc->replacetext ( $_POST ["news_broadcastdate"] );
		$fnewspage = $comfunc->replacetext ( $_POST ["news_page"] );
		$fnewssize = $comfunc->replacetext ( $_POST ["news_size"] );
		$fnewswriter = $comfunc->replacetext ( $_POST ["news_writer"] );
		$fnewsimage = $comfunc->UploadFiles("Upload/DataBeritaNegatif/".$fnewsid, "beritanegatif", $_FILES);
		$fpoint = $comfunc->replacetext ( $_POST ["news_point"] );
		$fmediaid = $comfunc->replacetext ( $_POST["media_id"]);
		$fnewsurl = $comfunc->replacetext ( $_POST["news_url"]);
		
		if ($fnewsid != "" && $fnewstitle != "" && $fmediaid != "") {
			$tx_negativenewsms->tx_negativenews_edit ( $fnewsid, $fnewstitle, $fnewsbroadcastdate,  $fnewspage, 
			$fnewssize, $fnewswriter, $fnewsimage, $fpoint, $fmediaid, $fnewsurl, $ses_userName);
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
		$fmediaid = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$tx_negativenewsms->_db->conn->BeginTrans ();
		$tx_negativenewsms->tx_negativenews_delete ( $fmediaid );
		$tx_negativenewsms->_db->conn->CommitTrans ();
		$comfunc->js_alert_act ( 2 );
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	default :
		$recordcount = $tx_negativenewsms->tx_negativenews_count ($key_search, $val_search, $key_field);
		$rs = $tx_negativenewsms->tx_negativenews_viewlist ( $key_search, $val_search, $key_field, $offset, $num_row, "");
		$page_title = "Daftar Berita Negatif";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
