<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class userm {
	var $_db;
	var $userId;
	function userm($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function users_count($user_id = "", $key_search = "", $val_search = "", $all_field = "") {

		$condition = "";
		if ($user_id != "")  $condition = " and user_id = '" . $user_id . "' ";

		$condition2 = "";
		if($val_search!=""){
			if($key_search!="") $condition2 = " and ".$key_search." like '%".$val_search."%' ";
			else {
				for($i=0;$i<count($all_field);$i++){
					$or = " or ";
					if($i==0) $or = "";
					$condition2 .= $or.$all_field[$i]." like '%".$val_search."%' ";
				}
				$condition2 = " and (".$condition2.")";
			}
		}

		$sql = "select count(*) FROM user_apps
				left join par_group on user_id_group = group_id
				where user_status != 0 " . $condition.$condition2;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function users_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($val_search!=""){
			if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
			else {
				for($i=0;$i<count($all_field);$i++){
					$or = " or ";
					if($i==0) $or = "";
					$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
				}
				$condition = " and (".$condition.")";
			}
		}

		$sql = "select user_id, user_username, group_name, '1' as login_as, (select count(*) from login_expired where login_exp_id_user = user_id) as status_login
				from user_apps
				left join par_group on user_id_group = group_id
				where user_status != 0 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function users_view_data($user_id) {
		$sql = "select user_id, user_username, user_id_group, user_login_as,  user_status
				from user_apps
				where user_id = '" . $user_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function users_cek_name($username, $user_id = "") {
		$condition = "";
		if ($user_id != "")
			$condition .= " and user_id != '" . $user_id . "'";
		if ($username != "")
			$condition .= " and upper(user_username)='" . $username . "'";
		$sql = "select user_id, user_status FROM user_apps where 1=1 " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function users_add($name, $password, $group_id, $login_as) {
		$id_user = $this->uniq_id ();
		$pass = md5 ( crypt ( $password, md5 ( $name ) ) );
		$sql = "insert into user_apps (user_id, user_username, user_password, user_id_group, user_login_as, user_status, user_create_by, user_create_date) VALUES ('" . $id_user . "', '" . $name . "', '" . $pass . "', '" . $group_id . "', '" . $login_as . "',  '1', '" . $this->userId . "', '" . strtotime ( "now" ) . "')";
		$aksinyo = "Menambah User $name";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function users_edit($id_user, $name, $password, $group_id, $login_as, $internal_id, $eksternal_id) {
		$condition = "";
		if ($password != "") {
			$pass = md5 ( crypt ( $password, md5 ( $name ) ) );
			$condition = ", user_password = '" . $pass . "' ";
		}
		$sql = "update user_apps set user_username = '" . $name . "' " . $condition . ", user_id_group = '" . $group_id . "', user_login_as = '" . $login_as . "' where user_id = '" . $id_user . "' ";
		$aksinyo = "Mengubah Data User ID $id_user";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function users_change_pass($id_user, $name, $password) {
		$pass = md5 ( crypt ( $password, md5 ( $name ) ) );

		$sql = "update user_apps set user_username = '" . $name . "', user_password = '" . $pass . "'  where user_id = '" . $id_user . "' ";
		$aksinyo = "Mengubah Password";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function users_delete($user_id) {
		$sql = "update user_apps set user_status = '0' where user_id = '" . $user_id . "' ";
		$aksinyo = "Menghapus Username Dengan id " . $user_id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function users_update_del_to_add($user_id, $name, $password, $group_id, $login_as, $internal_id, $eksternal_id) {
		$pass = md5 ( crypt ( $password, md5 ( $name ) ) );
		$sql = "update user_apps set user_username = '" . $name . "', user_password = '" . $pass . "' , user_id_group = '" . $group_id . "', user_login_as = '" . $login_as . "' , user_id_internal = '" . $internal_id . "', user_id_ekternal = '" . $eksternal_id . "', user_status='1' where user_id = '" . $user_id . "' ";
		$aksinyo = "Menampilkan kembali username dengan ID $user_id";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function list_auditor($auditor_id="") {
		$condition = "";
		if ($auditor_id != "") $condition = " and user_id_internal != '".$auditor_id."' ";

		$sql = "select auditor_id, auditor_name
				from auditor
				where auditor_del_st = 1 and auditor_id not in (select user_id_internal from user_apps where 1=1 and user_status != 0 ".$condition.")  order by auditor_name";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_pass_old($username, $passwd) {
		$passwd = md5 ( crypt ( $passwd, md5 ( $username ) ) );
		$sql = "SELECT count(*) FROM user_apps WHERE user_username = '" . $username . "' and user_password = '" . $passwd . "' ";
		$rs = $this->_db->_dbquery ( $sql );
		$row = $rs->FetchRow ();
		return $row [0];
	}
	function users_kill($userId) {
		$sql = "delete from login_expired where login_exp_id_user = '" . $userId . "' ";
		$this->_db->_dbquery ( $sql );
	}

	// group
	function group_count() {
		$sql = "select count(*) FROM par_group where group_del_st != 0 ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function group_viewlist($offset, $num_row) {
		$sql = "select group_id, group_name
				from par_group
				where group_del_st != 0 LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function group_data_viewlist($group_id) {
		$sql = "select group_id, group_name FROM par_group where group_id = '" . $group_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_group($nama, $data_id = "") {
		$condition = "";
		if ($data_id != "")
			$condition = "and group_id != '" . $data_id . "' ";
		$sql = "select group_id, group_del_st FROM par_group where LCASE(group_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function group_add($id, $name) {
		$sql = "insert into par_group (group_id, group_name, group_del_st) values ('" . $id . "','" . $name . "','1')";
		$aksinyo = "Menambah Group " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function group_add_roles($id, $menu_id) {
		$sql = "insert into role_group_menu (role_menu_id, role_menu_group_id, role_menu_menu_id) values ('" .$this->uniq_id(). "','" . $id . "','" . $menu_id . "')";
		$this->_db->_dbquery ( $sql );
	}

	function group_edit($id, $name) {
		$sql = "update par_group set group_name = '" . $name . "' where group_id = '" . $id . "' ";
		$aksinyo = "Mengubah Data Group ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function group_delete($id) {
		$sql = "update par_group set group_del_st = '0' where group_id = '" . $id . "' ";
		$this->clean_role($id);
		$this->clean_role_data($id);
		$aksinyo = "Menghapus Group ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_group_del($group_id) {
		$sql = "update par_group set group_del_st = '1' where group_id = '" . $group_id . "' ";
		$aksinyo = "Menampilakan Kembali Group ID " . $group_id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function cek_menu($menu_id, $group_id) {
		$sql = "select count(*) from role_group_menu where role_menu_group_id = '" . $group_id . "' and role_menu_menu_id = '" . $menu_id . "' "; // echo $sql;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function clean_role($group_id) {
		$condition = "";
		$sql = "delete from role_group_menu where role_menu_group_id = '" . $group_id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function group_add_role_data ( $group_id, $data_menu, $data_method, $data_parrent_id ) {
		$sql = "insert into role_group_data (role_data_id_group, role_data_menu, role_data_method, role_data_status) values ('" . $group_id . "','" . $data_menu . "','" . $data_method . "','" . $data_parrent_id . "')";
		$this->_db->_dbquery ( $sql );
	}
	function clean_role_data($group_id) {
		$condition = "";
		$sql = "delete from role_group_data where role_data_id_group = '" . $group_id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function cek_data($menu_id, $group_id) {
		$sql = "select role_data_status from role_group_data where role_data_id_group = '" . $group_id . "' and role_data_menu = '" . $menu_id . "' "; // echo $sql;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	// end group

	//log
	function log_count() {
		$sql = "select count(*) FROM log_activity";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function log_viewlist($offset, $num_row) {
		$sql = "select log_activity_id, user_username, log_activity_action, log_activity_date
		from log_activity
		left join user_apps on log_activity_id_user = user_id
		where 1=1 order by log_activity_date DESC
		LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	//end log
}
?>
