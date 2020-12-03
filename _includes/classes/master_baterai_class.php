<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class masterbaterai {
	var $_db;
	var $userId;
	function masterbaterai($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_baterai_count($key_search, $val_search, $all_field) {
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
		
		$sql = "select count(*) FROM master_baterai
				where baterai_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_baterai_view_data($baterai_id) {
		$sql = "select baterai_id, baterai_merk, baterai_serialnumber, baterai_capacity, baterai_jenis, baterai_tglpembelian,
				baterai_harga, status_assembly, status_kondisi from master_baterai
				where baterai_id = '" . $baterai_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_baterai_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select baterai_id, baterai_merk, baterai_serialnumber, baterai_capacity, baterai_jenis, baterai_tglpembelian,
				baterai_harga, status_assembly, status_kondisi, created_on, created_by,updated_on,updated_by 
		where baterai_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_baterai_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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
		
		$sql = "select baterai_id, baterai_merk, baterai_serialnumber, baterai_capacity, baterai_jenis, baterai_tglpembelian,
				baterai_harga, status_assembly, status_kondisi, created_on, created_by,updated_on,updated_by  FROM master_baterai where 1=1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_baterai_add($baterai_merk, $baterai_serialnumber, $status_kondisi, $baterai_capacity, $baterai_jenis,
		$baterai_tglpembelian, $baterai_harga) {
		$id = $this->uniq_id ();
		$sql = "insert into master_baterai 
				(baterai_id, baterai_merk, baterai_serialnumber, status_kondisi, baterai_capacity, baterai_jenis, 
				baterai_tglpembelian, baterai_harga) 
				values 
				('" . $id . "', '" . $baterai_merk . "','".$baterai_serialnumber."','".$status_kondisi.
					"','".$baterai_capacity."','".$baterai_jenis."','".$baterai_tglpembelian."','".$baterai_harga."')";
		$aksinyo = "Menambah baterai ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_baterai_edit($id, $baterai_merk, $baterai_serialnumber, $status_kondisi, $baterai_capacity, $baterai_jenis, $baterai_tglpembelian, $baterai_harga) {
		$sql = "update master_baterai set baterai_merk = '" . $baterai_merk . "',baterai_serialnumber = '".$baterai_serialnumber."', 
				status_kondisi = '" . $status_kondisi . "' ";

		if(isset($baterai_capacity) && $baterai_capacity!="" ){
			$sql = $sql." , baterai_capacity ='".$baterai_capacity."' ";
		}
		if(isset($baterai_jenis) && $baterai_jenis!=""){
			$sql = $sql." , baterai_jenis ='".$baterai_jenis."' ";
		}
		if(isset($baterai_tglpembelian) && $baterai_tglpembelian!=""){
			$sql = $sql." , baterai_tglpembelian ='".$baterai_tglpembelian."' ";
		}
		if(isset($baterai_harga) && $baterai_harga!=""){
			$sql = $sql." , baterai_harga ='".$baterai_harga."' ";
		}
		
		$sql = $sql." where baterai_id = '" . $id . "' ";

		$aksinyo = "Mengubah baterai dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_baterai_delete($id) {
		$sql = "delete from master_baterai where baterai_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus baterai dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_baterai_edit_used_assembly($id) {
		$sql = "update master_baterai set status_assembly = 1 where baterai_id = '" . $id . "' ";
		$aksinyo = "Mengubah baterai dengan ID " . $id . " untuk proses assembly";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
