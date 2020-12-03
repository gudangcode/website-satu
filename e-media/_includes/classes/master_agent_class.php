<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class masteragent {
	var $_db;
	var $userId;
	function masteragent($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_agent_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM master_agent
				where agent_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_agent_view_data($agent_id) {
		$sql = "select agent_id, agent_number, agent_name, agent_address, agent_remarks, status_active,  kabupaten_id,
				agent_pic, agent_picphonenumber, agent_type
				from master_agent
				where agent_id = '" . $agent_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_agent_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select agent_id, agent_number, agent_name, agent_address, agent_remarks, kabupaten_id, status_active, created_on, created_by,updated_on,updated_by,agent_pic, agent_picphonenumber, agent_type
		where agent_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_agent_viewlist($key_search, $val_search, $all_field, $offset, $num_row, $additionalcondition) {
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
		if(isset($additionalcondition)){
			 if($additionalcondition!=""){
			 		$condition = " and (".$additionalcondition." ". $condition. ")";
			 }
		}

		$sql = "select a.agent_id, a.agent_number, a.agent_name, a.agent_address, a.agent_remarks, a.status_active, a.created_on, a.created_by,a.updated_on,a.updated_by,b.kabupaten_name,a.agent_pic, a.agent_picphonenumber, a.agent_type
						FROM master_agent a left join par_kabupaten b on a.kabupaten_id = b.kabupaten_id where 1=1 ".$condition." ORDER BY a.agent_number ASC LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_agent_add($agent_number, $agent_name, $agent_address, $agent_remarks,
		$user, $kabupaten_id, $agent_pic, $agent_picphonenumber, $agent_type) {
		$id = $this->uniq_id ();
		$status_active = 1;
		$sql = "insert into master_agent
				(agent_id, agent_number, agent_name, agent_address, agent_remarks, status_active, created_by, updated_by,kabupaten_id,agent_pic, agent_picphonenumber, agent_type)
				values
				('" . $id . "', '" . $agent_number . "','".$agent_name."','".$agent_address.
					"','".$agent_remarks."','".$status_active."','".$user."','".$user."', '".$kabupaten_id."', '".$agent_pic."','".$agent_picphonenumber."','".$agent_type."')";
		$aksinyo = "Menambah agent ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_agent_edit($id, $agent_name, $agent_address, $agent_remarks, $status_active, $user, $kabupaten_id, $agent_pic, $agent_picphonenumber, $agent_type) {
		$sql = "update master_agent set agent_name = '" . $agent_name . "',agent_address = '".$agent_address."',
				agent_remarks = '".$agent_remarks."',  status_active = '" . $status_active . "', updated_by = '".$user."',
				kabupaten_id = '".$kabupaten_id."' , agent_pic = '".$agent_pic."', agent_picphonenumber = '".$agent_picphonenumber."',
				agent_type = '".$agent_type."'";

		$sql = $sql." where agent_id = '" . $id . "' ";

		$aksinyo = "Mengubah agent dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_agent_delete($id) {
		$sql = "delete from master_agent where agent_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus agent dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function get_last_agent_number() {
		$sql = "select agent_number from master_agent order by created_on desc limit 0,1 ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
}
?>
