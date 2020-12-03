<?
header ( 'Content-Type: text/plain' );
include_once "../_includes/classes/users_class.php";
include_once "../_includes/common.php";

$userms = new userm ( $ses_userId );
$comfunc = new comfunction ();

$_action = $comfunc->replacetext ( $_REQUEST ["data_action"] );
switch ($_action) {
	case "cek_old_pass" :
		$username = $comfunc->replacetext ( $_POST ["username"] );
		$pass_old = $comfunc->replacetext ( $_POST ["pass_old"] );
		$cek = $userms->cek_pass_old ( $username, $pass_old );
		echo $cek;
		exit ();
		break;
}
?>