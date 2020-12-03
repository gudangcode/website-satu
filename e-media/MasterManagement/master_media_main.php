<?
include_once "_includes/classes/master_media_class.php";
$master_mediams = new mastermedia ( $ses_userId );

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

$paging_request = "main_page.php?method=mstrmedia";
$acc_page_request = "master_media_acc.php";
$list_page_request = "master_media_view.php";
$product_page_request = "master_product_main.php";

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
$gridHeader = array ("Tipe Media", "Nama Media", "Nama Perusahaan", "Email", "Penanggung Jawab Wilayah", "Nomor Telepon");
$gridDetail = array ("7","1", "2","4", "8", "5");
$gridWidth = array ("10", "7","10","7","10","7");

$key_by = array ("Nama Media", "Nama Perusahaan");
$key_field = array ("media_name", "media_company");

$widthAksi = "13";
$iconEdit = "1";
$iconDel = "1";
$iconDetail = "0";
$iconAddProduct = "1";
// === end grid ===//

switch ($_action) {
	case "getaddproduct" :
		$_nextaction = "getadd";
		$page_request = $product_page_request;
		$page_title = "Tambah Media";
		break;
	case "getadd" :
		$_nextaction = "postadd";
		$page_request = $acc_page_request;
		$page_title = "Tambah Media";
		break;
	case "getedit" :
		$_nextaction = "postedit";
		$page_request = $acc_page_request;
		$fmediaid = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs = $master_mediams->master_media_view_data ( $fmediaid );

		$arr = $rs->FetchRow ();
		$page_title = "Modify media";
		break;
	case "getdetail" :
		$page_request = $acc_page_request;
		$fuser_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs_exist = $master_mediams->master_provider_viewlist ( $fuser_id );
		$page_title = "Detail media";
		break;
	case "postadd" :
		$fmediaid = $master_mediams->uniq_id();

		$fmedianame = strtoupper($comfunc->replacetext ( $_POST ["media_name"] ));
		$fmediacompany = strtoupper($comfunc->replacetext ( $_POST ["media_company"] ));
		$fmediaaddress = $comfunc->replacetext ( $_POST ["media_address"] );
		$fmediaemail = $comfunc->replacetext ( $_POST ["media_email"] );
		$fmediatelp = $comfunc->replacetext ( $_POST ["media_telp"] );
		$fmediawhatsapp = $comfunc->replacetext ( $_POST ["media_whatsapp"] );
		$fmediatype = $comfunc->replacetext ( $_POST["media_type"]);
		$fmediapicname = strtoupper($comfunc->replacetext ( $_POST["media_picname"]));
		$fmediapicnik = $comfunc->replacetext ( $_POST["media_picnik"]);
		$fmediapicaddress = $comfunc->replacetext ( $_POST["media_picaddress"]);
		$fmediapicktp = $comfunc->UploadFiles("Upload/DataPenanggungJawab/".$fmediaid, "ktp", $_FILES);
		$fmediapicphoto = $comfunc->UploadFiles("Upload/DataPenanggungJawab/".$fmediaid, "photo", $_FILES);
		$fmediapiccorporatedoc = $comfunc->UploadFiles("Upload/DataPenanggungJawab/".$fmediaid, "corporatedoc", $_FILES);
		

		if ($fmedianame != "" && $fmediaaddress != "") {
			$master_mediams->master_media_add ( $fmediaid, $fmedianame, $fmediacompany,  $fmediaaddress, 
			$fmediaemail, $fmediatelp, $fmediawhatsapp, $fmediatype, $fmediapicname, $fmediapicnik,
			$fmediapicaddress, $fmediapicktp, $fmediapicphoto,
			$fmediapiccorporatedoc, $ses_userName );
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
		$fmediaid = $comfunc->replacetext ( $_POST ["data_id"] );
		$fmedianame = strtoupper($comfunc->replacetext ( $_POST ["media_name"] ));
		$fmediacompany = strtoupper($comfunc->replacetext ( $_POST ["media_company"] ));
		$fmediaaddress = $comfunc->replacetext ( $_POST ["media_address"] );
		$fmediaemail = $comfunc->replacetext ( $_POST ["media_email"] );
		$fmediatelp = $comfunc->replacetext ( $_POST ["media_telp"] );
		$fmediawhatsapp = $comfunc->replacetext ( $_POST ["media_whatsapp"] );
		$fmediatype = $comfunc->replacetext	( $_POST ["media_type"]);
		$fmediapicname = strtoupper($comfunc->replacetext ( $_POST["media_picname"]));
		$fmediapicnik = $comfunc->replacetext ( $_POST["media_picnik"]);
		$fmediapicaddress = $comfunc->replacetext ( $_POST["media_picaddress"]);
		$fmediapicktp = $comfunc->UploadFiles("Upload/DataPenanggungJawab/".$fmediaid, "ktp", $_FILES);
		$fmediapicphoto = $comfunc->UploadFiles("Upload/DataPenanggungJawab/".$fmediaid, "photo", $_FILES);
		$fmediapiccorporatedoc = $comfunc->UploadFiles("Upload/DataPenanggungJawab/".$fmediaid, "corporatedoc", $_FILES);
		
		if ($fmedianame != "" && $fmediaaddress != "" ) {
			$master_mediams->master_media_edit ( $fmediaid, $fmedianame, $fmediacompany,  
			$fmediaaddress, $fmediaemail, $fmediatelp, $fmediawhatsapp, 
			$fmediatype, $fmediapicname, $fmediapicnik, $fmediapicaddress, $fmediapicktp,
			$fmediapicphoto, $fmediapiccorporatedoc, $ses_userName);
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
		$master_mediams->_db->conn->BeginTrans ();
		$master_mediams->master_media_delete ( $fmediaid );
		$master_mediams->_db->conn->CommitTrans ();
		$comfunc->js_alert_act ( 2 );
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	default :
		$recordcount = $master_mediams->master_media_count ($key_search, $val_search, $key_field);
		$rs = $master_mediams->master_media_viewlist ( $key_search, $val_search, $key_field, $offset, $num_row, "");
		$page_title = "Daftar Media";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
