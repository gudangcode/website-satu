<?
@session_start();
error_reporting ( E_ALL );
if (@$position == 1) {
	include_once "_includes/classes/login_class.php";
	include_once "_includes/common.php";
} else {
	include_once "../_includes/classes/login_class.php";
	include_once "../_includes/common.php";
}

$index = "index.php";
$comfunc = new comfunction ();
$logins = new login ();

@$ses_userId = $_SESSION ['ses_userId'];
@$ses_userName = $_SESSION ['ses_userName'];
@$ses_group_id = $_SESSION ['ses_groupId'];
@$ses_id_int = $_SESSION ['ses_id_int'];
@$ses_id_eks = $_SESSION ['ses_id_eks'];

$h_groupName = $logins->getGroup_name($ses_group_id);

@$method = $comfunc->replacetext ( $_GET ['method'] );
if ($ses_userId) {
	$isLogin = $logins->isLogin ( $ses_userId );
	switch ($isLogin) {
		/**
		 * Expired *
		 */
		case 1 :
			$logins->deleteLogin ( $ses_userId );
			echo "<script>alert('Masa Waktu Login Ada Telah Habis'); parent.location.href='" . $index . "';</script>";
			break;
		/**
		 * Lanjut*
		 */
		case 2 :
			break;
		/**
		 * IP Beda *
		 */
		case 3 :
			echo "<script>alert('Nama pengguna yang anda masukkan sedang aktif pada saat ini'); parent.location.href='" . $index . "';</script>";
			break;
		/**
		 * No Data *
		 */
		case 4 :
			echo "<script>alert('Silahkan Login Terlebih Dahulu'); parent.location.href='" . $index . "';</script>";
			break;
		/**
		 * masa aktif expired *
		 */
		case 5 :
			echo "<script>alert('Masa Aktif Anda Telah Habis, Silahkan Hubungi Administrator'); parent.location.href='" . $index . "';</script>";
			break;
	}
} else {
	echo "<script>alert('Anda Harus Login Terlebih Dahulu'); parent.location.href='" . $index . "';</script>";
}

$getajukan_tl = $comfunc->cek_akses ( $ses_group_id, $method, 'getajukan_tl' );
$getapprove_tl = $comfunc->cek_akses ( $ses_group_id, $method, 'getapprove_tl' );

$iconAdd = $comfunc->cek_akses ( $ses_group_id, $method, 'getadd' );
$iconEdit = $comfunc->cek_akses ( $ses_group_id, $method, 'getedit' );
$iconDel = $comfunc->cek_akses ( $ses_group_id, $method, 'getdelete' );

$getajukan = $comfunc->cek_akses ( $ses_group_id, $method, 'getajukan' );
$getapprove = $comfunc->cek_akses ( $ses_group_id, $method, 'getapprove' );

$getajukan_penugasan = $comfunc->cek_akses ( $ses_group_id, $method, 'getajukan_penugasan' );
$getapprove_penugasan = $comfunc->cek_akses ( $ses_group_id, $method, 'getapprove_penugasan' );

// menejemen risiko
$risk_identifikasi = $comfunc->cek_akses ( $ses_group_id, $method, 'risk_identifikasi' );
$view_analisa = $comfunc->cek_akses ( $ses_group_id, $method, 'view_analisa' );
$view_evaluasi = $comfunc->cek_akses ( $ses_group_id, $method, 'view_evaluasi' );
$view_penanganan = $comfunc->cek_akses ( $ses_group_id, $method, 'view_penanganan' );
$view_monitoring = $comfunc->cek_akses ( $ses_group_id, $method, 'view_monitoring' );

// menejemen audit
$set_perencanaan = $comfunc->cek_akses ( $ses_group_id, $method, 'view_plan' );
$anggota_plan = $comfunc->cek_akses ( $ses_group_id, $method, 'anggota_plan' );

$anggota_assign_akses = $comfunc->cek_akses ( $ses_group_id, $method, 'anggota_assign' );
$surat_tugas_akses = $comfunc->cek_akses ( $ses_group_id, $method, 'surattugas' );
$programaudit_akses = $comfunc->cek_akses ( $ses_group_id, $method, 'programaudit' );
$kertas_kerja_akses = $comfunc->cek_akses ( $ses_group_id, $method, 'kertas_kerja' );
$finding_kka_akses = $comfunc->cek_akses ( $ses_group_id, $method, 'finding_kka' );
$rekomendasi_akses = $comfunc->cek_akses ( $ses_group_id, $method, 'rekomendasi' );

$base_on_login = "";
$base_on_id_int = "";
$base_on_id_eks = "";
?>
