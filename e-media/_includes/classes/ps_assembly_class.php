<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class psassembly {
	var $_db;
	var $userId;
	function psassembly($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function lg_assembly_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM lg_assembly
				where assembly_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function ps_assembly_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM ps_assembly
				where assembly_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function ps_assembly_view_data($assembly_id) {
		$sql = "select assembly_id, assembly_name, simcard_id, baterai_id, modem_id, status_ready, status_kondisi, created_on, created_by,updated_on,updated_by from ps_assembly
				where assembly_id = '" . $assembly_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function ps_assembly_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select assembly_id, assembly_name, simcard_id, baterai_id, modem_id, status_ready, status_kondisi, created_on, created_by,updated_on,updated_by
		from ps_assembly where assembly_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function ps_assembly_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select ps_assembly.assembly_id, ps_assembly.assembly_name,
		master_simcard.simcard_number, master_baterai.baterai_merk,
		master_modem.modem_merk, ps_assembly.status_ready, ps_assembly.status_kondisi, ps_assembly.created_on,
		ps_assembly.created_by,ps_assembly.updated_on,ps_assembly.updated_by
		FROM ps_assembly
		left join master_simcard on ps_assembly.simcard_id = master_simcard.simcard_id
		left join master_baterai on ps_assembly.baterai_id = master_baterai.baterai_id
		left join master_modem on ps_assembly.modem_id = master_modem.modem_id
		where 1=1 ".$condition." LIMIT $offset, $num_row";

		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function lg_assembly_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select lg_assembly.assembly_id, lg_assembly.assembly_name,
		master_simcard.simcard_number, master_baterai.baterai_merk,
		master_modem.modem_merk, lg_assembly.created_on,
		lg_assembly.created_by,lg_assembly.updated_on,lg_assembly.updated_by
		FROM lg_assembly
		left join master_simcard on lg_assembly.simcard_id = master_simcard.simcard_id
		left join master_baterai on lg_assembly.baterai_id = master_baterai.baterai_id
		left join master_modem on lg_assembly.modem_id = master_modem.modem_id
		where 1=1 ".$condition." LIMIT $offset, $num_row";

		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function ps_assembly_add($assembly_name, $simcard_id, $baterai_id, $modem_id, $status_kondisi) {
		$id = $this->uniq_id ();
		$sql = "insert into ps_assembly
				(assembly_id, assembly_name, simcard_id, baterai_id, modem_id, status_kondisi)
				values
				('" . $id . "', '" . $assembly_name . "','".$simcard_id."','".$baterai_id."','".$modem_id."','".$status_kondisi."')";

		$aksinyo = "Menambah assembly ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function ps_assembly_edit($id, $assembly_name, $simcard_id, $baterai_id, $modem_id, $status_kondisi) {
		$sql = "update ps_assembly set assembly_name = '" . $assembly_name . "',simcard_id = '".$simcard_id."'
				,baterai_id = '".$baterai_id."',modem_id = '".$modem_id."',status_kondisi = '" . $status_kondisi . "'
				where assembly_id = '" . $id . "' ";
		$aksinyo = "Mengubah assembly dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function ps_assembly_delete($id) {
		$sql = "delete from ps_assembly where assembly_id = '" . $id . "' ";
		$aksinyo = "Menghapus assembly dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
