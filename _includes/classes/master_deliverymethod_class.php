<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class masterdeliverymethod {
	var $_db;
	var $userId;
	function masterdeliverymethod($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_deliverymethod_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM master_deliverymethod
				where deliverymethod_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_deliverymethod_view_data($deliverymethod_id) {
		$sql = "select deliverymethod_id, deliverymethod_name, status from master_deliverymethod
				where deliverymethod_id = '" . $deliverymethod_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_deliverymethod_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select deliverymethod_id, deliverymethod_name, status where deliverymethod_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_deliverymethod_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select deliverymethod_id, deliverymethod_name, status FROM master_deliverymethod where 1=1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_deliverymethod_add($deliverymethod_name) {
		$id = $this->uniq_id ();
		$sql = "insert into master_deliverymethod
				(deliverymethod_id, deliverymethod_name)
				values
				('" . $id . "', '" . $deliverymethod_name . "')";
		$aksinyo = "Menambah deliverymethod ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_deliverymethod_edit($id, $deliverymethod_name, $status) {
		$sql = "update master_deliverymethod set deliverymethod_name = '" . $deliverymethod_name . "',status = '" . $status . "'
				where deliverymethod_id = '" . $id . "' ";

		$aksinyo = "Mengubah deliverymethod dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_deliverymethod_delete($id) {
		$sql = "delete from master_deliverymethod where deliverymethod_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus deliverymethod dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
