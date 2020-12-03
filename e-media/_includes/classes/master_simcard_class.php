<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class mastersimcard {
	var $_db;
	var $userId;
	function mastersimcard($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_simcard_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM master_simcard
				where simcard_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_simcard_view_data($simcard_id) {
		$sql = "select simcard_id, provider_id, simcard_number, status_assembly, status_kondisi, simcard_tglpembelian, simcard_masaberlaku, simcard_harga from master_simcard
				where simcard_id = '" . $simcard_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_simcard_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select simcard_id, provider_id, simcard_number, status_assembly, status_kondisi from master_simcard
		where simcard_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_simcard_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select master_simcard.simcard_id, master_provider.provider_name, master_simcard.simcard_number,
				master_simcard.status_assembly, master_simcard.status_kondisi, master_simcard.simcard_tglpembelian, master_simcard.simcard_masaberlaku, master_simcard.simcard_harga
				from master_simcard left join master_provider on master_simcard.provider_id = master_provider.provider_id
				where 1=1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_simcard_add($provider_id, $simcard_number, $status_kondisi, $simcard_tglpembelian, $simcard_masaberlaku, $simcard_harga) {
		$id = $this->uniq_id ();
		$sql = "insert into master_simcard
				(simcard_id, provider_id, simcard_number, status_kondisi, simcard_tglpembelian, simcard_masaberlaku, simcard_harga) 
				values
				('" . $id . "', '" . $provider_id . "','".$simcard_number."','".$status_kondisi."', '".$simcard_tglpembelian."', '".$simcard_masaberlaku."', '".$simcard_harga."')";
		$aksinyo = "Menambah simcard ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_simcard_edit($id, $provider_id, $simcard_number, $status_kondisi, $simcard_tglpembelian, $simcard_masaberlaku, $simcard_harga) {
		$sql = "update master_simcard set provider_id = '" . $provider_id . "',simcard_number = '".$simcard_number."'
				,status_kondisi = '" . $status_kondisi . "', simcard_tglpembelian='".$simcard_tglpembelian."', simcard_masaberlaku='".$simcard_masaberlaku."', simcard_harga='".$simcard_harga."'
				 where simcard_id = '" . $id . "' ";
		$aksinyo = "Mengubah simcard dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_simcard_delete($id) {
		$sql = "delete from master_simcard where simcard_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus simcard dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_simcard_edit_used_assembly($id) {
		$sql = "update master_simcard set status_assembly = 1 where simcard_id = '" . $id . "' ";
		$aksinyo = "Mengubah simcard dengan ID " . $id . " untuk proses assembly";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
