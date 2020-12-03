<?
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class login {
	var $_db = null;
	function login() {
		$this->_db = new db ();
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function cek_username($username, $passwd) {
		$passwd = md5 ( crypt ( $passwd, md5 ( $username ) ) );
		$sql = "SELECT count(*)FROM user_apps WHERE user_username = '" . $username . "' and user_password = '" . $passwd . "' ";
		$rs = $this->_db->_dbquery ( $sql );
		$row = $rs->FetchRow ();
		return $row [0];
	}
	function data_user($username) {
		$sql = "SELECT user_id, user_username, user_status, user_id_group
				from user_apps
				where user_username = '" . $username . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cekLogin($userId) {
		$sql = "select count(*) from login_expired where login_exp_id_user = '" . $userId . "' and login_exp_ip != '" . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "' ";
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		if ($arr [0] == 0) {
			return 1;
		}
	}
	function insertStatus($userId, $date) {
		$sql = "insert into login_expired (login_exp_id, login_exp_id_user, login_exp_last_acces, login_exp_ip) values ('" . $this->uniq_id () . "', '" . $userId . "', '" . $date . "', '" . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "')";
		$aksinyo = "User Login";
		$this->_db->_dbexecquery ( $sql, $userId, $aksinyo );
	}
	function isLogin($userId) {
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$timeNow = strtotime ( "now" );
		$q = $this->list_expired ( $userId );
		$jml = $q->RecordCount ();
		if ($jml > 0) {
			$rs = $q->FetchRow ();
			$lastLogin = $rs ['2'];
			$lastIp = $rs ['3'];
			$selisih = $lastLogin + 3600; // 15 menit;
			/**
			 * kalo expired *
			 */
			//if ($timeNow > $selisih) {
				//return 1; // expired
			//} else {
				/**
				 * lanjut/noproblemo *
				 */
				if ($ip !== $lastIp) {
					//return 3; // beda IP
					return 2; //force login
				} else {
					$sqlUpdate = "update login_expired set login_exp_last_acces = '" . strtotime ( "now" ) . "' where login_exp_id = '" . $userId . "' ";
					$this->_db->_dbquery ( $sqlUpdate );
					return 2; // lanjut
				}
			//}
		} else {
			return 4; // gak ada datanya di tabel login_expired
		}
	}
	function cekPending($userId) {
		$print_detik = "";
		$date_sys = date ( "Y-m-d" );
		$sql = "select login_exp_last_acces from login_expired where login_exp_id_user = '" . $userId . "' ";
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		$lastLogin = $arr [0];
		$date_last = date ( 'Y-m-d', $lastLogin );
		if ($date_sys == $date_last) {
			$mulai = date ( "H:i:s" );
			$date_finis = explode ( " ", date ( 'Y-m-d H:i:s', $lastLogin + 1800 ) );
			$time_finis = explode ( ":", $date_finis [1] );
			$selesai = $time_finis [0] . ":" . $time_finis [1] . ":" . $time_finis [2];

			$mulai_time = (is_string ( $mulai ) ? strtotime ( $mulai ) : $mulai);
			$selesai_time = (is_string ( $selesai ) ? strtotime ( $selesai ) : $selesai);
			$detik = $selesai_time - $mulai_time;
			$menit = floor ( $detik / 60 );
			if ($menit > 0) {
				$sisa_detik = $detik % $menit;
				$print_detik = "$sisa_detik Detik";
				$result = "Mohon Tunggu $menit menit $print_detik, User Sedang Digunakan";
			} else {
				$this->deleteLogin ( $userId );
				$result = "silahkan login kembali";
			}
		} else {
			$this->deleteLogin ( $userId );
			$result = "silahkan login kembali";
		}
		return $result;
	}
	function deleteLogin($userId) {
		$sql = "delete from login_expired where login_exp_id_user = '" . $userId . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function log_out($userId) {
		$value = array (
				$userId
		);
		$sql = "delete from login_expired where login_exp_id_user = '" . $userId . "' ";
		$aksinyo = "User Logout";
		$this->_db->_dbexecquery ( $sql, $userId, $aksinyo );
	}
	function list_expired($userId) {
		$sql = "select login_exp_id, login_exp_id_user, login_exp_last_acces, login_exp_ip from login_expired where login_exp_id_user = '" . $userId . "' "; // echo $sql;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function getGroup_name($group_id) {
		$sql = "SELECT group_name from par_group where group_id= '" . $group_id . "' "; // echo $sql;
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr ['group_name'];
	}
	function get_auditee_from_pic($pic_id) {
		$sql = "SELECT pic_auditee_id from auditee_pic where pic_id= '" . $pic_id . "' "; // echo $sql;
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr ['pic_auditee_id'];
	}
	function get_id_inspektorat($auditor_id) {
		$sql = "SELECT auditor_id_inspektorat from auditor where auditor_id= '" . $auditor_id . "' "; // echo $sql;
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr ['auditor_id_inspektorat'];
	}
	function deleteLoginsytem(){
		$date = strtotime (date('d-m-Y')." 00:00");
		$sql = "delete from login_expired where login_exp_last_acces < '".$date."' ";
		$this->_db->_dbquery($sql);
	}
}
?>
