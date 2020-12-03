<?php

$position = 1;
include "_includes/classes/login_class.php";
include "_includes/common.php";

$comfunc = new comfunction ();
$logins = new login ();

$username = $comfunc->replacetext ( $_POST ['username'] );
$passwd = $comfunc->replacetext ( $_POST ['password'] );
$rsCek = 0;
$rsCek = $logins->cek_username ( $username, $passwd );
echo $rsCek;

?>