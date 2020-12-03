<?
session_start();
$position = 1;

include_once "_includes/classes/login_class.php";
include_once "_includes/common.php";

$comfunc = new comfunction ();
$logins = new login ();
$logins->deleteLoginsytem();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="e-Media">
    <meta name="author" content="M.Irfan">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="img/logo-emedia.png">

    <title>e-Media</title>

    <!-- Icons -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet">

</head>
<?
$index = "index.php";
if (@$_POST ['submit'] == "Login") {

	$username = $comfunc->replacetext ( $_POST ['username'] );
	$passwd = $comfunc->replacetext ( $_POST ['password'] );
	if ($username != "" && $passwd != "") {
		$rsCek = 0;
		$userStatusAktif = 0;
		$cekLogin = 0;

		$rsCek = $logins->cek_username ( $username, $passwd );
		if (! $rsCek == "0") {
			$rs_user = $logins->data_user ( $username );
			$arr_user = $rs_user->FetchRow ();
			$userStatusAktif = $arr_user ['user_status'];
			if ($userStatusAktif == "1") {
				$cekLogin = $logins->cekLogin ( $arr_user ['user_id'] );
				if ($cekLogin == 1) {
					$date = $comfunc->date_db ( date ( "Y-m-d H:i:s" ) );
					$logins->insertStatus ( $arr_user ['user_id'], $date );

					$_SESSION ['ses_userId'] = $arr_user ['user_id'];
					$_SESSION ['ses_userName'] = $arr_user ['user_username'];
					$_SESSION ['ses_groupId'] = $arr_user ['user_id_group'];
					echo "<script>location.href='main_page.php';</script>";
				} else {
					$pending = $logins->cekPending ( $arr_user ['user_id'] );
					echo "<script>alert('$pending'); location.href='" . $index . "';</script>";
				}
			} else {
				echo "<script>alert('Your username has been deleted or inactive, Please call administrator'); location.href='" . $index . "';</script>";
			}
		} else {
			$alert = "Please input valid username and password";
			echo "<script>alert('$alert'); location.href='" . $index . "';</script>";
		}
	} else {
		echo "<script>alert('Username and Password cant be leave empty'); location.href='" . $index . "';</script>";
	}
}
?>
<body>

	<div class="container-orchardgarden d-table">
        <div class="d-100vh-va-middle">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card-group">
                        <div class="card p-2">
                            <div class="card-block">
                                <h2>Login</h2>
                                <p class="text-muted">Masuk menggunakan data pengguna dan kata sandi</p>
                                <form action="#" method="POST">
                                <div class="input-group mb-1">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Username"
                                    name="username">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                    	<input type="submit" class="btn btn-orchardgarden px-2"  name="submit" value="Login">
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="card card-inverse card-orchardgarden py-3 hidden-md-down" style="width:44%">
                            <div class="card-block text-xs-center">
                                <div>
                                    <h2><img src="img/logo-emedia.png" width="200px" /></h2>
                                    <p>E-MEDIA TUBABA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- Bootstrap and necessary plugins -->
    <script src="js/libs/jquery.min.js"></script>
    <script src="js/libs/tether.min.js"></script>
    <script src="js/libs/script">

    <script>
        function verticalAlignMiddle() {
        				var bodyHeight = $(window).height();
        		        var formHeight = $('.vamiddle').height();
        		        var marginTop = (bodyHeight / 2) - (formHeight / 2);

        				if (marginTop > 0) {
        					$('.vamiddle').css('margin-top', marginTop);
        				}
        			}

        			$(document).ready(function(){
        				verticalAlignMiddle();
        			});
        			$(window).bind('resize', verticalAlignMiddle);
    </script>

</body>
</html>
