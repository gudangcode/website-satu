<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class masterprovider {
	var $_db;
	var $userId;
	function masterprovider($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_provider_count($key_search, $val_search, $all_field) {
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
		
		$sql = "select count(*) FROM master_provider
				where provider_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_provider_view_data($provider_id) {
		$sql = "select provider_id, provider_name, status from master_provider
				where provider_id = '" . $provider_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_provider_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select provider_id, provider_name, status where provider_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_provider_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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
		
		$sql = "select provider_id, provider_name, status FROM master_provider where 1=1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_provider_add($provider_name) {
		$id = $this->uniq_id ();
		$sql = "insert into master_provider 
				(provider_id, provider_name) 
				values 
				('" . $id . "', '" . $provider_name . "')";
		$aksinyo = "Menambah Provider ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_provider_edit($id, $provider_name, $status) {
		$sql = "update master_provider set provider_name = '" . $provider_name . "',status = '" . $status . "'
				where provider_id = '" . $id . "' ";
		
		$aksinyo = "Mengubah Provider dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_provider_delete($id) {
		$sql = "delete from master_provider where provider_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus Provider dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
