<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class txassembly {
	var $_db;
	var $userId;
	function txassembly($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function tx_assembly_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM tx_assembly
				where assembly_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function tx_assembly_view_data($assembly_id) {
		$sql = "select assembly_id, assembly_name, simcard_id, baterai_id, modem_id,  created_on, created_by,updated_on,updated_by from tx_assembly
				where assembly_id = '" . $assembly_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function tx_assembly_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select assembly_id, assembly_name, simcard_id, baterai_id, modem_id, created_on, created_by,updated_on,updated_by
		from tx_assembly where assembly_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_assembly_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select tx_assembly.assembly_id, tx_assembly.assembly_name,
		master_simcard.simcard_number, master_baterai.baterai_merk,
		master_modem.modem_merk, tx_assembly.created_on,
		tx_assembly.created_by,tx_assembly.updated_on,tx_assembly.updated_by
		FROM tx_assembly
		left join master_simcard on tx_assembly.simcard_id = master_simcard.simcard_id
		left join master_baterai on tx_assembly.baterai_id = master_baterai.baterai_id
		left join master_modem on tx_assembly.modem_id = master_modem.modem_id
		where 1=1 ".$condition." LIMIT $offset, $num_row";

		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_assembly_add($assembly_name, $simcard_id, $baterai_id, $modem_id) {
		$id = $this->uniq_id ();
		$sql = "insert into tx_assembly
				(assembly_id, assembly_name, simcard_id, baterai_id, modem_id)
				values
				('" . $id . "', '" . $assembly_name . "','".$simcard_id."','".$baterai_id."','".$modem_id."')";

		$aksinyo = "Menambah assembly ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function tx_assembly_edit($id, $assembly_name, $simcard_id, $baterai_id, $modem_id) {
		$sql = "update tx_assembly set assembly_name = '" . $assembly_name . "',simcard_id = '".$simcard_id."'
				,baterai_id = '".$baterai_id."',modem_id = '".$modem_id."' 
				where assembly_id = '" . $id . "' ";
		$aksinyo = "Mengubah assembly dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function tx_assembly_delete($id) {
		$sql = "delete from tx_assembly where assembly_id = '" . $id . "' ";
		$aksinyo = "Menghapus assembly dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
