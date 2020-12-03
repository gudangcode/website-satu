<?
session_start ();
include_once "classes/login_class.php";
$logins = new login ();
$userId = $_GET ['uid'];
$logins->log_out ( $userId );
session_destroy ();
echo "<script>window.open('../index.php','_parent');</script>";
?>
