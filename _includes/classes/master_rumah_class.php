<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class masterrumah {
	var $_db;
	var $userId;
	function masterrumah($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_rumah_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM master_rumah
				where rumah_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_rumah_view_data($rumah_id) {
		$sql = "select rumah_id, rumah_nomor, rumah_tipe from master_rumah
				where rumah_id = '" . $rumah_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_rumah_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select rumah_id, rumah_nomor, rumah_tipe where rumah_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_rumah_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select rumah_id, rumah_nomor, rumah_tipe FROM master_rumah where 1=1 ".$condition." order by rumah_nomor LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_rumah_add($rumah_nomor, $rumah_tipe) {
		$id = $this->uniq_id ();
		$sql = "insert into master_rumah
				(rumah_id, rumah_nomor, rumah_tipe)
				values
				('" . $id . "', '" . $rumah_nomor . "','". $rumah_tipe ."')";
		$aksinyo = "Menambah rumah ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_rumah_edit($id, $rumah_nomor, $rumah_tipe) {
		$sql = "update master_rumah set rumah_nomor = '" . $rumah_nomor . "', rumah_tipe = '" . $rumah_tipe . "'
				where rumah_id = '" . $id . "' ";

		$aksinyo = "Mengubah rumah dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_rumah_delete($id) {
		$sql = "delete from master_rumah where rumah_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus rumah dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
