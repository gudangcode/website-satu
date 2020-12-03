<?
include_once "_includes/classes/tx_advertorialnews_class.php";
$tx_advertorialnewsms = new txadvertorialnews ( $ses_userId );

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

$paging_request = "main_page.php?method=txadvertorialnews";
$acc_page_request = "tx_advertorialnews_acc.php";
$list_page_request = "tx_advertorialnews_view.php";

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
$gridHeader = array ("Media", "Judul Berita", "Tanggal Terbit/Tayang", "Poin", "Harga");
$gridDetail = array ("10","1", "2","7","8");
$gridWidth = array ("7", "12","7","3","7");

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
		$page_title = "Tambah Berita Advetorial";
		break;
	case "getedit" :
		$_nextaction = "postedit";
		$page_request = $acc_page_request;
		$fmediaid = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs = $tx_advertorialnewsms->tx_advertorialnews_view_data ( $fmediaid );

		$arr = $rs->FetchRow ();
		$page_title = "Modify Berita Advetorial";
		break;
	case "getdetail" :
		$page_request = $acc_page_request;
		$fuser_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs_exist = $tx_advertorialnewsms->master_provider_viewlist ( $fuser_id );
		$page_title = "Detail Berita Advetorial";
		break;
	case "postadd" :
		$fnewsid = $tx_advertorialnewsms->uniq_id();

		$fnewstitle = $comfunc->replacetext ( $_POST ["news_title"] );
		$fnewsbroadcastdate = $comfunc->replacetext ( $_POST ["news_broadcastdate"] );
		$fnewspage = $comfunc->replacetext ( $_POST ["news_page"] );
		$fnewssize = $comfunc->replacetext ( $_POST ["news_size"] );
		$fnewswriter = $comfunc->replacetext ( $_POST ["news_writer"] );
		$fnewsimage = $comfunc->UploadFiles("Upload/DataBeritaAdvertorial/".$fnewsid, "beritaadvertorial", $_FILES);
		$fpoint = $comfunc->replacetext ( $_POST ["news_point"] );
		$fnewsprice = $comfunc->replaceformattedmoney ( $_POST ["news_price"] );
		$fmediaid = $comfunc->replacetext ( $_POST["media_id"]);
		$fnewsurl = $comfunc->replacetext ( $_POST["news_url"]);

		if ($fnewstitle != "" && $fmediaid != "") {
			$tx_advertorialnewsms->tx_advertorialnews_add ( $fnewsid, $fnewstitle, $fnewsbroadcastdate,  $fnewspage, 
			$fnewssize, $fnewswriter, $fnewsimage, $fpoint, $fnewsprice, $fmediaid, $fnewsurl, $ses_userName );
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
		$fnewsimage = $comfunc->UploadFiles("Upload/DataBeritaAdvertorial/".$fnewsid, "beritaadvertorial", $_FILES);
		$fpoint = $comfunc->replacetext ( $_POST ["news_point"] );
		$fnewsprice = $comfunc->replaceformattedmoney ( $_POST ["news_price"] );
		$fmediaid = $comfunc->replacetext ( $_POST["media_id"]);
		$fnewsurl = $comfunc->replacetext ( $_POST["news_url"]);
		
		if ($fnewsid != "" && $fnewstitle != "" && $fmediaid != "") {
			$tx_advertorialnewsms->tx_advertorialnews_edit ( $fnewsid, $fnewstitle, $fnewsbroadcastdate,  $fnewspage, 
			$fnewssize, $fnewswriter, $fnewsimage, $fpoint, $fnewsprice, $fmediaid, $fnewsurl, $ses_userName);
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
		$tx_advertorialnewsms->_db->conn->BeginTrans ();
		$tx_advertorialnewsms->tx_advertorialnews_delete ( $fmediaid );
		$tx_advertorialnewsms->_db->conn->CommitTrans ();
		$comfunc->js_alert_act ( 2 );
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	default :
		$recordcount = $tx_advertorialnewsms->tx_advertorialnews_count ($key_search, $val_search, $key_field);
		$rs = $tx_advertorialnewsms->tx_advertorialnews_viewlist ( $key_search, $val_search, $key_field, $offset, $num_row, "");
		$page_title = "Daftar Berita Advertorial";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
