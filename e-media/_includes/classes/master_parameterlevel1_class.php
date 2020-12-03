<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class masterparameterlevel1 {
	var $_db;
	var $userId;
	function masterparameterlevel1($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_parameterlevel1_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM master_parameterlevel1
				where parameter_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_parameterlevel1_view_data($parameter_id) {
		$sql = "select parameter_id, parameter_key, parameter_value, status_active
				from master_parameterlevel1
				where parameter_id = '" . $parameter_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_parameterlevel1_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select parameter_id, parameter_key, parameter_value, status_active, created_on, created_by,updated_on,updated_by
		where parameter_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_parameterlevel1_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select parameter_id, parameter_key, parameter_value, status_active, created_on, created_by,updated_on,updated_by
						FROM master_parameterlevel1 where 1=1 ".$condition." ORDER BY parameter_key ASC LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_parameterlevel1_add($parameter_key, $parameter_value, $user, $status_active) {
		$id = $this->uniq_id ();
		$sql = "insert into master_parameterlevel1
				(parameter_id, parameter_key, parameter_value, status_active, created_by, updated_by)
				values
				('" . $id . "', '" . $parameter_key . "','". $parameter_value ."', '".$status_active."','".$user."','".$user."')";
		$aksinyo = "Menambah parameterlevel1 ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function master_parameterlevel1_edit($id, $parameter_key, $parameter_value, $status_active, $user) {
		$sql = "update master_parameterlevel1 set parameter_value = '" . $parameter_value . "', status_active = '" . $status_active . "', updated_by = '".$user."' ";
		$sql = $sql." where parameter_id = '" . $id . "' ";

		$aksinyo = "Mengubah parameterlevel1 dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function master_parameterlevel1_delete($id) {
		$sql = "delete from master_parameterlevel1 where parameter_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus parameterlevel1 dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
