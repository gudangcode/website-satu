<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class mastermodem {
	var $_db;
	var $userId;
	function mastermodem($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_modem_count($key_search, $val_search, $all_field) {
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
		
		$sql = "select count(*) FROM master_modem
				where modem_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_modem_view_data($modem_id) {
		$sql = "select modem_id, modem_merk, modem_serialnumber, modem_modelnumber, status_assembly, status_kondisi, modem_tglpembelian, modem_harga from master_modem
				where modem_id = '" . $modem_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_modem_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select modem_id, modem_merk, modem_serialnumber, modem_modelnumber, status_assembly, status_kondisi, created_on, created_by,updated_on,updated_by 
		where modem_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_modem_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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
		
		$sql = "select modem_id, modem_merk, modem_serialnumber, modem_modelnumber, status_assembly, status_kondisi, created_on, created_by,updated_on,updated_by,modem_tglpembelian, modem_harga  FROM master_modem where 1=1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_modem_add($modem_merk, $modem_serialnumber, $modem_modelnumber, $status_kondisi, $modem_tglpembelian, $modem_harga) {
		$id = $this->uniq_id ();
		$sql = "insert into master_modem 
				(modem_id, modem_merk, modem_serialnumber, modem_modelnumber, status_kondisi,modem_tglpembelian, modem_harga) 
				values 
				('" . $id . "', '" . $modem_merk . "','".$modem_serialnumber."','".$modem_modelnumber."','".$status_kondisi."','".$modem_tglpembelian."','".$modem_harga."'";
		$aksinyo = "Menambah modem ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_modem_edit($id, $modem_merk, $modem_serialnumber, $modem_modelnumber, $status_kondisi, $modem_tglpembelian, $modem_harga) {
		$sql = "update master_modem set modem_merk = '" . $modem_merk . "',modem_serialnumber = '".$modem_serialnumber."' 
				,modem_modelnumber = '".$modem_modelnumber."',status_kondisi = '" . $status_kondisi . "', modem_tglpembelian = '".$modem_tglpembelian."' , modem_harga='".$modem_harga."'
				where modem_id = '" . $id . "' ";
		$aksinyo = "Mengubah modem dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_modem_delete($id) {
		$sql = "delete from master_modem where modem_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus modem dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_modem_edit_used_assembly($id) {
		$sql = "update master_modem set status_assembly = 1
				where modem_id = '" . $id . "' ";
		$aksinyo = "Mengubah modem dengan ID " . $id . " untuk proses assembly";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
