<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class finding {
	var $_db;
	var $userId;
	function finding($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	
	// finding
	function finding_tl_count($id_assign, $status = "", $key_search, $val_search, $all_field) {
		$condition = "";
		if ($status == "1") $condition .= "and finding_status = '8' "; //selesai
		if ($status == "2") $condition .= "and finding_status != '8' "; //belum selesai
		
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
		
		$sql = "select count(*) FROM finding_internal 
				join auditee on finding_auditee_id = auditee_id
				where finding_assign_id = '" . $id_assign . "' and (finding_status = 3 or finding_status = 4 or finding_status = 8) " . $condition.$condition2;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function finding_tl_view_grid($id_assign, $key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select finding_id, finding_no, finding_judul, auditee_name, finding_date, case finding_status when '8' then 'Selesai' else 'Belum Selesai' end as status, finding_assign_id
				from finding_internal
				join auditee on finding_auditee_id = auditee_id
				where finding_assign_id = '" . $id_assign . "' and (finding_status = 3 or finding_status = 4 or finding_status = 8) ".$condition2." order by finding_date DESC
				LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function finding_count($id_assign, $id_kka = "", $key_search, $val_search, $all_field) {
		$condition = "";
		if ($id_kka != "") $condition .= "and finding_kka_id = '" . $id_kka . "' ";
		
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
		
		$sql = "select count(*) FROM finding_internal 
				left join auditee on finding_auditee_id = auditee_id
				where finding_assign_id = '" . $id_assign . "' " . $condition.$condition2; 
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function finding_view_grid($id_assign, $id_kka = "", $key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if ($id_kka != "") $condition = "and finding_kka_id = '" . $id_kka . "' ";
		
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
		
		$sql = "select DISTINCT finding_id, finding_no, finding_judul, auditee_name, finding_date, finding_status, finding_assign_id
				from finding_internal
				left join auditee on finding_auditee_id = auditee_id
				where finding_assign_id = '" . $id_assign . "' " . $condition . $condition2. "
				order by finding_date DESC
				LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function finding_viewlist($id) {
		$sql = "select finding_id, finding_auditee_id, finding_no, finding_internal.finding_type_id, finding_judul, finding_date, 
				finding_kondisi, finding_kriteria, finding_sebab, finding_akibat, finding_attachment, finding_status, finding_tanggapan_auditee, finding_tanggapan_auditor, finding_penyebab_id,
				auditee_name, finding_type_name, assign_no, finding_sub_id, finding_jenis_id, jenis_temuan_name, jenis_temuan_code, finding_assign_id, finding_nilai, kode_penyebab_name
				FROM finding_internal
				left join assignment on finding_assign_id = assign_id
				left join par_finding_type on finding_internal.finding_type_id = par_finding_type.finding_type_id
				left join par_finding_jenis on finding_jenis_id = jenis_temuan_id
				left join auditee on finding_auditee_id = auditee_id
				left join par_kode_penyebab on finding_penyebab_id = kode_penyebab_id
				where finding_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function finding_add($id_assign, $finding_auditee, $finding_no, $finding_type, $finding_sub_id, $finding_jenis_id, $finding_judul, $finding_date, $finding_kondisi, $finding_kriteria, $finding_sebab, $finding_akibat, $finding_attachment, $id_kka, $tanggapan_auditee, $tanggapan_auditor, $finding_penyebab_id, $finding_nilai) {
		$sql = "insert into finding_internal 
				(finding_id, finding_assign_id, finding_auditee_id, finding_no, finding_type_id, finding_sub_id, finding_jenis_id, finding_judul, finding_date, finding_kondisi, finding_kriteria, finding_sebab, finding_akibat, finding_attachment, finding_kka_id, finding_tanggapan_auditee, finding_tanggapan_auditor, finding_penyebab_id, finding_nilai) 
				values 
				('" . $this->uniq_id () . "', '" . $id_assign . "', '" . $finding_auditee . "', '" . $finding_no . "', '" . $finding_type . "', '" . $finding_sub_id . "', '" . $finding_jenis_id . "', '" . $finding_judul . "', '" . $finding_date . "', '" . $finding_kondisi . "', '" . $finding_kriteria . "', '" . $finding_sebab . "', '" . $finding_akibat . "', '" . $finding_attachment . "', '" . $id_kka . "', '" . $tanggapan_auditee . "', '" . $tanggapan_auditor . "', '" . $finding_penyebab_id . "', '" . $finding_nilai . "')";
		$aksinyo = "Menambah Temuan No " . $finding_no;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function finding_edit($id, $finding_auditee, $finding_no, $finding_type, $finding_sub_id, $finding_jenis_id, $finding_judul, $finding_date, $finding_kondisi, $finding_kriteria, $finding_sebab, $finding_akibat, $finding_attachment, $tanggapan_auditee, $tanggapan_auditor, $finding_penyebab_id, $finding_nilai) {
		$sql = "update finding_internal set finding_auditee_id = '" . $finding_auditee . "', finding_no = '" . $finding_no . "', finding_type_id = '" . $finding_type . "', finding_sub_id = '" . $finding_sub_id . "', finding_jenis_id = '" . $finding_jenis_id . "', finding_judul = '" . $finding_judul . "', finding_date = '" . $finding_date . "', finding_kondisi = '" . $finding_kondisi . "', finding_kriteria = '" . $finding_kriteria . "', finding_sebab = '" . $finding_sebab . "', finding_akibat = '" . $finding_akibat . "', finding_attachment = '" . $finding_attachment . "', finding_tanggapan_auditee = '" . $tanggapan_auditee . "', finding_tanggapan_auditor = '" . $tanggapan_auditor . "', finding_penyebab_id = '" . $finding_penyebab_id . "', finding_nilai = '" . $finding_nilai . "'
				where finding_id = '" . $id . "' ";
		$aksinyo = "Mengubah Temuan Audit No " . $finding_no;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function finding_delete($id) {
		$sql = "delete from finding_internal where finding_id = '" . $id . "' ";
		$aksinyo = "Menghapus Temuan Audit dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function finding_update_status($id, $status) {
		$sql = "update finding_internal set finding_status = '" . $status . "'
				where finding_id = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function finding_komentar_viewlist($id) {
		$sql = "select auditor_name, find_comment_desc, find_comment_date
				FROM finding_internal_comment
				left join user_apps on find_comment_user_id = user_id
				left join auditor on user_id_internal = auditor_id
				where find_comment_find_id = '" . $id . "' order by find_comment_date ASC";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function finding_add_komentar($id, $komentar, $tanggal) {
		$sql = "insert into finding_internal_comment 
				(find_comment_id, find_comment_find_id, find_comment_user_id, find_comment_desc, find_comment_date) 
				values
				('" . $this->uniq_id () . "','" . $id . "','" . $this->userId . "','" . $komentar . "','" . $tanggal . "')";
		$aksinyo = "Mengomentari Temuan dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function cek_posisi($id_assign){
		$sql = "select DISTINCT assign_auditor_id_posisi from assignment_auditor
				left join user_apps on assign_auditor_id_auditor = user_id_internal
				where user_id = '".$this->userId."' and assign_auditor_id_assign = '".$id_assign."'";
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr [0];
	}
	// end finding
}
?>
