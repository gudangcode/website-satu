<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class rekomendasi {
	var $_db;
	var $userId;
	function rekomendasi($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	
	// rekomendasi
	function rekomendasi_count($id_finding, $status="", $key_search, $val_search, $all_field) {
		$condition = "";
		if($status!="") $condition = "and rekomendasi_status = '".$status."' ";
		
		$condition2 = "";
		if($val_search!=""){
			if($key_search!="") $condition2 = " and ".$key_search." like '%".$val_search."%' ";
			else {
				for($i=0;$i<count($all_field);$i++){
					$or = " or ";
					if($i==0) $or = "";
					$condition2 .= $or.$all_field[$i]." like '%".$val_search."%' ";
				}
				$condition2 = " and (".$condition2.")";
			}
		}
		
		$sql = "select count(*) FROM rekomendasi_internal
				left join auditee_pic on rekomendasi_pic_id = pic_id
				where rekomendasi_finding_id = '" . $id_finding . "' ".$condition.$condition2;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function rekomendasi_view_grid($id_finding, $key_search, $val_search, $all_field, $offset, $num_row) {
		$condition2 = "";
		if($val_search!=""){
			if($key_search!="") $condition2 = " and ".$key_search." like '%".$val_search."%' ";
			else {
				for($i=0;$i<count($all_field);$i++){
					$or = " or ";
					if($i==0) $or = "";
					$condition2 .= $or.$all_field[$i]." like '%".$val_search."%' ";
				}
				$condition2 = " and (".$condition2.")";
			}
		}
		$sql = "select rekomendasi_id, rekomendasi_desc, rekomendasi_dateline, pic_name, 
				case rekomendasi_status 
					when '1' then 'Selesai'
					else 'Belum Selesai' 
				end as rekomendasi_status
				from rekomendasi_internal
				left join auditee_pic on rekomendasi_pic_id = pic_id 
				where rekomendasi_finding_id = '" . $id_finding . "' ".$condition2."
				order by rekomendasi_date DESC
				LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function rekomendasi_viewlist($id) {
		$sql = "select rekomendasi_id, rekomendasi_desc, rekomendasi_pic_id, rekomendasi_dateline, assign_no, finding_no, finding_kondisi, auditee_name, rekomendasi_id_code, rekomendasi_status
				from rekomendasi_internal 
				join finding_internal on rekomendasi_finding_id = finding_id
				join assignment on finding_assign_id = assign_id
				join auditee on finding_auditee_id = auditee_id
				where rekomendasi_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function rekomendasi_add($id_finding, $rekomendasi_code, $rekomendasi_desc, $rekomendasi_pic_id, $rekomendasi_dateline, $rekomendasi_date) {
		$sql = "insert into rekomendasi_internal 
				(rekomendasi_id, rekomendasi_finding_id, rekomendasi_id_code, rekomendasi_desc, rekomendasi_pic_id, rekomendasi_dateline, rekomendasi_date) 
				values 
				('" . $this->uniq_id () . "', '" . $id_finding . "', '" . $rekomendasi_code . "', '" . $rekomendasi_desc . "', '" . $rekomendasi_pic_id . "', '" . $rekomendasi_dateline . "', '" . $rekomendasi_date . "')";
		$aksinyo = "Menambah Rekomendasi dengan ID " . $this->uniq_id ();
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function rekomendasi_edit($id, $rekomendasi_code, $rekomendasi_desc, $rekomendasi_pic_id, $rekomendasi_dateline) {
		$sql = "update rekomendasi_internal set rekomendasi_id_code = '" . $rekomendasi_code . "', rekomendasi_desc = '" . $rekomendasi_desc . "', rekomendasi_pic_id = '" . $rekomendasi_pic_id . "', rekomendasi_dateline = '" . $rekomendasi_dateline . "'
				where rekomendasi_id = '" . $id . "' ";
		$aksinyo = "Mengubah Rekomendasi ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function rekomendasi_delete($id) {
		$sql = "delete from rekomendasi_internal where rekomendasi_id = '" . $id . "' ";
		$aksinyo = "Menghapus rekomendasi dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_status_rekomendasi($id) {
		$sql = "update rekomendasi_internal set rekomendasi_status = '1' where rekomendasi_id = '" . $id . "' ";
		$aksinyo = "Mengubah Status Rekomendasi ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function get_temuan_id($id_rek) {
		$sql = "select distinct rekomendasi_finding_id FROM rekomendasi_internal where rekomendasi_id = '" . $id_rek . "' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
}
?>
