<?
include_once "_includes/classes/master_parameterlevel1_class.php";
$master_parameterlevel1ms = new masterparameterlevel1 ( $ses_userId );

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

$paging_request = "main_page.php?method=mstrparameterlevel1";
$acc_page_request = "master_parameterlevel1_acc.php";
$list_page_request = "master_parameterlevel1_view.php";

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
$gridHeader = array ("Parameter Key", "Parameter Value", "Status Active");
$gridDetail = array ("1", "2","3");
$gridWidth = array ("7", "15","10");

$key_by = array ("Parameter Key", "Parameter Value");
$key_field = array ("parameter_key", "parameter_value");

$widthAksi = "13";
$iconEdit = "1";
$iconDel = "1";
$iconDetail = "0";
// === end grid ===//

switch ($_action) {
	case "getadd" :
		$_nextaction = "postadd";
		$page_request = $acc_page_request;
		$page_title = "Add New Parameter";
		break;
	case "getedit" :
		$_nextaction = "postedit";
		$page_request = $acc_page_request;
		$fcustomerid = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs = $master_parameterlevel1ms->master_parameterlevel1_view_data ( $fcustomerid );

		$arr = $rs->FetchRow ();
		$page_title = "Modify Parameter";
		break;
	case "getdetail" :
		$page_request = $acc_page_request;
		$fuser_id = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$rs_exist = $master_parameterlevel1ms->master_parameterlevel1_viewlist ( $fuser_id );
		$page_title = "Detail Parameter";
		break;
	case "postadd" :
		$fparameterkey = strtoupper($comfunc->replacetext($_POST["parameter_key"]));
		$fparametervalue = $comfunc->replacetext ( $_POST ["parameter_value"] );
		$fstatusactive = $_POST["status_active"];

		if ($fparameterkey != "" && $fparametervalue != "") {
			$master_parameterlevel1ms->master_parameterlevel1_add ( $fparameterkey, $fparametervalue, $ses_userName,
			$fstatusactive );
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
		$fparameterid = $comfunc->replacetext ( $_POST ["data_id"] );
		$fparameterkey = strtoupper($comfunc->replacetext($_POST["parameter_key"]));
		$fparametervalue = $comfunc->replacetext ( $_POST ["parameter_value"] );
		if(isset($_POST["status_active"])){
			$fstatusactive = $comfunc->replacetext ( $_POST ["status_active"] );
		}


		if ($fparameterkey != "" && $fparametervalue != "" ) {
			$master_parameterlevel1ms->master_parameterlevel1_edit ( $fparameterid, $fparameterkey, $fparametervalue,
					$fstatusactive, $ses_userName);
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
		$fparameterid = $comfunc->replacetext ( $_REQUEST ["data_id"] );
		$master_parameterlevel1ms->_db->conn->BeginTrans ();
		$master_parameterlevel1ms->master_parameterlevel1_delete ( $fparameterid );
		$master_parameterlevel1ms->_db->conn->CommitTrans ();
		//$comfunc->js_alert_act ( 2 );
		?>
<script>window.open('<?=$def_page_request?>', '_self');</script>
<?
		$page_request = "blank.php";
		break;
	default :
		$recordcount = $master_parameterlevel1ms->master_parameterlevel1_count ($key_search, $val_search, $key_field);
		$rs = $master_parameterlevel1ms->master_parameterlevel1_viewlist ( $key_search, $val_search, $key_field, $offset, $num_row );
		$page_title = "List of Parameter";
		$page_request = $list_page_request;
		break;
}
include_once $page_request;
?>
