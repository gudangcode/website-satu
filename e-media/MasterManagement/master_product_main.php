<?
include_once "_includes/classes/master_product_class.php";
$master_productms = new masterproduct ( $ses_userId );

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

$paging_request = "main_page.php?method=mstrproduct";
$acc_page_request = "master_product_acc.php";
$list_page_request = "master_product_view.php";

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
$gridHeader = array ("Media", "Nama Produk", "Satuan", "Harga");
$gridDetail = array ("5","1", "2","3");
$gridWidth = array ( "7","7","7","7");

$key_by = array ("Nama Produk", "Nama Media");
$key_field = array ("a.product_name", "b.media_name");

$widthAksi = "13";
$iconEdit = "1";
$iconDel = "1";
$iconDetail = "0";
// === end grid ===//

switch ($_action) {
	case "getadd" :
		$_nextaction = "postadd";
		$page_request = $acc_page_request;
		$page_title = "Tambah Produk";
		break;
	case "getedit" :
		$_nextaction = "postedit";
		$page_request = $acc_page_request;
		$fproductid = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs = $master_productms->master_product_view_data ( $fproductid );

		$arr = $rs->FetchRow ();
		$page_title = "Ubah Produk";
		break;
	case "getdetail" :
		$page_request = $acc_page_request;
		$fuser_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs_exist = $master_productms->master_provider_viewlist ( $fuser_id );
		$page_title = "Detail Produk";
		break;
	case "postadd" :
		$fproductid = $master_productms->uniq_id();

		$fproductname = strtoupper($comfunc->replacetext ( $_POST ["product_name"] ));
		$fproductuom = strtoupper($comfunc->replacetext ( $_POST ["product_uom"] ));
		$fproductprice = $comfunc->replaceformattedmoney ( $_POST ["product_price"] );
		$fmediaid = $comfunc->replacetext ( $_POST ["media_id"] );

		if ($fproductname != "" && $fmediaid != "") {
			$master_productms->master_product_add ( $fproductid, $fproductname, $fproductuom,  $fproductprice, 
			$fmediaid, $ses_userName );
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
		$fproductid = $comfunc->replacetext ( $_POST ["data_id"] );
		$fproductname = strtoupper($comfunc->replacetext ( $_POST ["product_name"] ));
		$fproductuom = strtoupper($comfunc->replacetext ( $_POST ["product_uom"] ));
		$fproductprice = $comfunc->replaceformattedmoney ( $_POST ["product_price"] );
		$fmediaid = $comfunc->replacetext ( $_POST ["media_id"] );
	
		if ($fproductname != "" && $fmediaid != "" ) {
			$master_productms->master_product_edit ( $fproductid, $fproductname, $fproductuom,  
			$fproductprice, $fmediaid, $ses_userName);
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
		$fproductid = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$master_productms->_db->conn->BeginTrans ();
		$master_productms->master_product_delete ( $fproductid );
		$master_productms->_db->conn->CommitTrans ();
		$comfunc->js_alert_act ( 2 );
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	default :
		$recordcount = $master_productms->master_product_count ($key_search, $val_search, $key_field);
		$rs = $master_productms->master_product_viewlist ( $key_search, $val_search, $key_field, $offset, $num_row, "");
		$page_title = "Daftar Produk";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
