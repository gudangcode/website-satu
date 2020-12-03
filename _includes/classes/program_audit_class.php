<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class programaudit {
	var $_db;
	var $userId;
	function programaudit($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function program_audit_count($assign_id, $key_search, $val_search, $all_field) {
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
		
		$sql = "select count(*) FROM program_audit
				left join auditee on program_id_auditee = auditee_id
				left join ref_program_audit on program_id_ref = ref_program_id
				left join auditor on program_id_auditor = auditor_id
				where program_id_assign = '" . $assign_id . "' ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function program_audit_view_grid($assign_id, $key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select program_id, auditee_name, ref_program_code, ref_program_title, auditor_name
				from program_audit
				left join auditee on program_id_auditee = auditee_id
				left join ref_program_audit on program_id_ref = ref_program_id
				left join auditor on program_id_auditor = auditor_id
				where program_id_assign = '" . $assign_id . "'  ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function program_audit_viewlist($id) {
		$sql = "select program_id, program_id_assign, program_id_auditee, program_id_ref, program_id_auditor, program_start, program_end, program_day, auditee_name, auditor_name, ref_program_title, ref_program_code, ref_program_procedure, program_jam, ref_program_kriteria
				FROM program_audit 
				left join auditee on program_id_auditee = auditee_id
				left join auditor on program_id_auditor = auditor_id
				left join ref_program_audit on program_id_ref = ref_program_id
				where program_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function program_audit_add($assign_id, $id_auditee, $id_ref, $id_auditor, $program_jam) {
		$id = $this->uniq_id ();
		$sql = "insert into program_audit 
				(program_id, program_id_assign, program_id_auditee, program_id_ref, program_id_auditor, program_jam) 
				values 
				('" . $id . "', '" . $assign_id . "', '" . $id_auditee . "', '" . $id_ref . "', '" . $id_auditor . "', '" . $program_jam . "')";
		$aksinyo = "Menambah Program Audit ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function program_audit_edit($id, $id_auditee, $id_ref, $id_auditor, $program_jam) {
		$sql = "update program_audit set program_id_auditee = '" . $id_auditee . "',program_id_ref = '" . $id_ref . "', program_id_auditor = '" . $id_auditor . "', program_jam = '" . $program_jam . "'
				where program_id = '" . $id . "' ";
		$aksinyo = "Mengubah Program Audit dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function kertas_kerja_prog_delete($id) {
		$sql = "delete from kertas_kerja where kertas_kerja_id_program = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function program_audit_delete($id) {
		$this->kertas_kerja_prog_delete ( $id );
		$sql = "delete from program_audit where program_id = '" . $id . "' ";
		$aksinyo = "Menghapus Program Audit dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
