<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class assign {
	var $_db;
	var $userId;
	function assign($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function assign_count($base_on_id_int="", $key_search, $val_search, $all_field) {
		$condition = "";
		if($base_on_id_int=='0') $base_on_id_int="";
		if($base_on_id_int!="") $condition = " and assign_auditor_id_auditor = '".$base_on_id_int."' ";

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
		
		$sql = "select count(distinct assign_id) FROM assignment
				left join par_inspektorat on assign_pelaksana_id = inspektorat_id
				left join assignment_auditor on assign_id = assign_auditor_id_assign
				left join assignment_lha on assign_id = lha_id_assign
				where 1=1 ".$condition.$condition2;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function assign_view_grid($base_on_id_int="", $key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($base_on_id_int=='0') $base_on_id_int="";
		if($base_on_id_int!="") $condition = " and assign_auditor_id_auditor = '".$base_on_id_int."' ";
		
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
		
		$sql = "select distinct assign_id, assign_start_date, assign_end_date, assign_status, assign_tahun, assign_no, assign_no_lha, lha_status
				from assignment 
				left join par_inspektorat on assign_pelaksana_id = inspektorat_id
				left join assignment_auditor on assign_id = assign_auditor_id_assign
				left join assignment_lha on assign_id = lha_id_assign
				where 1=1 ".$condition.$condition2." order by assign_created_date DESC LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function assign_viewlist($id) {
		$sql = "select assign_id, assign_tipe_id, assign_tahun, assign_start_date, assign_end_date, assign_tugas, assign_dasar, audit_type_name, assign_no, assign_letter_date, assign_tujuan, assign_pelaksana_id, assign_periode, inspektorat_name
				FROM assignment 
				left join par_audit_type on assign_tipe_id = audit_type_id
				left join par_inspektorat on assign_pelaksana_id = inspektorat_id
				where assign_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function assign_auditee_viewlist($id="", $auditee_id = "") {
		$condition = "";
		if ($auditee_id != "") $condition = " and assign_auditee_id_auditee = '" . $auditee_id . "' ";
		if ($id != "") $condition = " and assign_auditee_id_assign = '" . $id . "' ";
		$sql = "select DISTINCT assign_auditee_id_auditee, auditee_name
				FROM assignment_auditee
				join auditee on assign_auditee_id_auditee = auditee_id
				where 1=1 " . $condition. " order by auditee_name";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function assign_auditee_inspektorat_viewlist() {
		$sql = "select DISTINCT inspektorat_id, inspektorat_name
				FROM assignment_auditee
				join auditee on assign_auditee_id_auditee = auditee_id
				join par_inspektorat on auditee_inspektorat_id = inspektorat_id
				where 1=1 " ;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function assign_add($id, $no_surat, $date_surat, $tipe_audit, $tahun, $tanggal_awal, $tanggal_akhir, $pertimbangan, $dasar, $hari_kerja, $periode, $tujuan, $assign_pelaksana) {
		$this->assign_add_lha($id);
		$sql = "insert into assignment 
				(assign_id, assign_no, assign_letter_date, assign_tipe_id, assign_tahun, assign_start_date, assign_end_date, assign_tugas, assign_dasar, assign_hari, assign_periode, assign_tujuan, assign_pelaksana_id) 
				values 
				('" . $id . "', '" . $no_surat . "', '" . $date_surat . "', '" . $tipe_audit . "', '" . $tahun . "', '" . $tanggal_awal . "', '" . $tanggal_akhir . "', '" . $pertimbangan . "', '" . $dasar . "', '" . $hari_kerja . "', '" . $periode . "', '" . $tujuan . "', '" . $assign_pelaksana . "')";
		$aksinyo = "Menambah Penugasan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function assign_add_lha($id) {
		$sql = "insert into assignment_lha (lha_id, lha_id_assign) values ('" . $this->uniq_id() . "', '" . $id . "')";
		$this->_db->_dbquery ( $sql );
	}	
	function assign_add_auditee($id, $id_auditee) {
		$sql = "insert into assignment_auditee 
				(assign_auditee_id_assign, assign_auditee_id_auditee) 
				values
				('" . $id . "','" . $id_auditee . "')";
		$this->_db->_dbquery ( $sql );
	}
	function assign_del_auditee($id) {
		$sql = "delete from assignment_auditee where assign_auditee_id_assign = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function assign_edit($id, $no_surat, $date_surat, $tipe_audit, $tahun, $tanggal_awal, $tanggal_akhir, $tugas, $dasar, $hari_kerja, $periode, $tujuan, $finpektorat) {
		$sql = "update assignment set assign_no = '" . $no_surat . "', assign_letter_date = '" . $date_surat . "', assign_tipe_id = '" . $tipe_audit . "', assign_tahun = '" . $tahun . "', assign_start_date = '" . $tanggal_awal . "', assign_end_date = '" . $tanggal_akhir . "', assign_tugas = '" . $tugas . "', assign_dasar = '" . $dasar . "', assign_hari = '" . $hari_kerja . "', assign_periode = '" . $periode . "', assign_tujuan = '" . $tujuan . "', assign_pelaksana_id = '" . $finpektorat . "'
				where assign_id = '" . $id . "' ";
		$aksinyo = "Mengubah Penugasan Audit dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function assign_delete($id) {
		$this->assign_del_auditee ( $id );
		$this->assign_del_auditor ( $id );
		$sql = "delete from assignment where assign_id = '" . $id . "' ";
		$aksinyo = "Menghapus Penugasan Audit dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function count_auditor_assign($assign_id) {
		$sql = "select count(*) FROM assignment_auditor where assign_auditor_id_assign = '" . $assign_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function view_auditor_assign($assign_id, $surat_tugas_to="") {
		$condition = "";
		if($surat_tugas_to=="pt") $condition = " and posisi_id != '1fe7f8b8d0d94d54685cbf6c2483308aebe96229' ";
		if($surat_tugas_to=="pm") $condition = " and posisi_id = '1fe7f8b8d0d94d54685cbf6c2483308aebe96229' ";
		$sql = "select auditor_id, auditor_name, auditor_nip, posisi_name, MIN(assign_auditor_start_date) as start_date, MAX(assign_auditor_end_date) as end_date
				FROM assignment_auditor
				left join auditor on assign_auditor_id_auditor = auditor_id
				left join par_posisi_penugasan on assign_auditor_id_posisi = posisi_id
				where assign_auditor_id_assign = '" . $assign_id . "'  ".$condition." group by auditor_id, auditor_name, auditor_nip, posisi_name order by posisi_sort";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function assign_update_status($id, $status) {
		$sql = "update assignment set assign_status = '".$status."' where assign_id = '" . $id . "' ";
		$aksinyo = "Mengubah Status Penugasan Audit dengan ID " . $id ." menjadi ".$status;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function assign_add_komentar($id, $komentar, $tanggal) {
		$sql = "insert into assignment_comment 
				(assign_comment_id, assign_comment_assign_id, assign_comment_user_id, assign_comment_desc, assign_comment_date) 
				values
				('" . $this->uniq_id () . "','" . $id . "','" . $this->userId . "','" . $komentar . "','" . $tanggal . "')";
		$aksinyo = "Mengomentari Penugasan dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function assign_komentar_viewlist($id) {
		$sql = "select auditor_name, assign_comment_desc, assign_comment_date
				FROM assignment_comment
				left join user_apps on assign_comment_user_id = user_id
				left join auditor on user_id_internal = auditor_id
				where assign_comment_assign_id = '" . $id . "' order by assign_comment_date ASC";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	// anggota
	function auditor_assign_count($assign_id, $key_search, $val_search, $all_field) {
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
		$sql = "select count(*) 
				from assignment_auditor 
				join assignment on assign_auditor_id_assign = assign_id
				left join auditee on assign_auditor_id_auditee = auditee_id
				left join auditor on assign_auditor_id_auditor = auditor_id
				left join par_posisi_penugasan on assign_auditor_id_posisi = posisi_id
				where assign_auditor_id_assign = '" . $assign_id . "' ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function auditor_assign_view_grid($assign_id, $key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select assign_auditor_id, auditor_name, auditee_name, posisi_name, assign_auditor_cost, assign_auditor_day, assign_status
				from assignment_auditor 
				join assignment on assign_auditor_id_assign = assign_id
				left join auditee on assign_auditor_id_auditee = auditee_id
				left join auditor on assign_auditor_id_auditor = auditor_id
				left join par_posisi_penugasan on assign_auditor_id_posisi = posisi_id
				where assign_auditor_id_assign = '" . $assign_id . "' ".$condition."
				LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function assign_auditor_add($id, $auditee_id, $anggota_id, $posisi_id, $tanggal_awal, $tanggal_akhir, $jml_hari, $assign_id) {
		$sql = "insert into assignment_auditor 
				(assign_auditor_id, assign_auditor_id_auditee, assign_auditor_id_auditor, assign_auditor_id_posisi, assign_auditor_start_date, assign_auditor_end_date, assign_auditor_day, assign_auditor_id_assign) 
				values
				('" . $id . "','" . $auditee_id . "','" . $anggota_id . "','" . $posisi_id . "','" . $tanggal_awal . "','" . $tanggal_akhir . "','" . $jml_hari . "','" . $assign_id . "')";
		$aksinyo = "Menambah anggota dengan id " . $id . " pada penugasan id " . $assign_id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function assign_auditor_viewlist($id) {
		$sql = "select assign_auditor_id, assign_auditor_id_auditee, assign_auditor_id_auditor, assign_auditor_id_posisi, assign_auditor_day, assign_auditor_cost, auditor_golongan, assign_auditor_start_date, assign_auditor_end_date
				from assignment_auditor 
				left join auditor on assign_auditor_id_auditor = auditor_id 
				where assign_auditor_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function assign_auditor_edit($id, $auditee_id, $anggota_id, $posisi_id, $tanggal_awal, $tanggal_akhir, $fjml_hari) {
		$sql = "update assignment_auditor set assign_auditor_id_auditee = '" . $auditee_id . "', assign_auditor_id_auditor = '" . $anggota_id . "', assign_auditor_id_posisi = '" . $posisi_id . "', assign_auditor_start_date = '" . $tanggal_awal . "', assign_auditor_end_date = '" . $tanggal_akhir . "', assign_auditor_day = '" . $fjml_hari . "'
				where assign_auditor_id = '" . $id . "' ";
		$aksinyo = "Mengubah Anggota id " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function assign_auditor_delete($id) {
		$sql = "delete from assignment_auditor where assign_auditor_id = '" . $id . "' ";
		$aksinyo = "Menghapus anggota id " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function assign_del_auditor($id) {
		$sql = "delete from assignment_auditor where assign_auditor_id_assign = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function assign_auditor_detil_add($id, $kode, $jml_hari, $nilai, $total) {
		$sql = "insert into assignment_auditor_detil
				(anggota_assign_detil_id, anggota_assign_detil_kode_sbu, anggota_assign_detil_jml_hari, anggota_assign_detil_nilai, anggota_assign_detil_total) 
				values
				('" . $id . "','" . $kode . "','" . $jml_hari . "','" . $nilai . "','" . $total . "')";
		$this->_db->_dbquery ( $sql );
	}
	function assign_auditor_detil_clean($id) {
		$sql = "delete from assignment_auditor_detil where anggota_assign_detil_id = '".$id."' ";
		$this->_db->_dbquery ( $sql );
	}
	function assign_auditor_update_sum_biaya($id, $biaya_audit) {
		$sql = "update assignment_auditor set assign_auditor_cost = '" . $biaya_audit . "' where assign_auditor_id = '" . $id . "' "; 
		$this->_db->_dbquery ( $sql );
	}
	function assign_auditor_detil_viewlist($id) {
		$sql = "select anggota_assign_detil_id, anggota_assign_detil_kode_sbu, anggota_assign_detil_jml_hari, anggota_assign_detil_nilai, anggota_assign_detil_total
				from assignment_auditor_detil
				where anggota_assign_detil_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function assign_cek_katim( $assign_id, $userId ) {
		$sql = "select count(*)
				from assignment_auditor
				left join user_apps on assign_auditor_id_auditor = user_id_internal
				where assign_auditor_id_assign = '" . $assign_id . "' and user_id = '" . $userId . "'  and assign_auditor_id_posisi = '8918ca5378a1475cd0fa5491b8dcf3d70c0caba7' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow();
		return $arr[0];
	}
	//end anggota
	
	//surat tugas
	function surat_tugas_count($assign_id, $key_search, $val_search, $all_field) {
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
		$sql = "select count(*) 
				from assignment_surat_tugas 
				join assignment on assign_surat_id_assign = assign_id
				left join auditor on assign_surat_id_auditorTTD = auditor_id
				where assign_surat_id_assign = '" . $assign_id . "' ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function surat_tugas_view_grid($assign_id, $key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select assign_surat_id, assign_surat_id_assign, assign_start_date, assign_end_date, assign_surat_no, assign_surat_tgl, auditor_name, case assign_surat_status when '1' then 'Sedang Direview' when '2' then 'Disetujui' when '3' then 'Ditolak' else '-' end as status, assign_surat_status
				from assignment_surat_tugas 
				join assignment on assign_surat_id_assign = assign_id
				left join auditor on assign_surat_id_auditorTTD = auditor_id
				where assign_surat_id_assign = '" . $assign_id . "' ".$condition."
				LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function surat_tugas_add ( $assign_id, $id, $no_surat, $tanggal_surat, $ttd_id, $jenis_surat, $tembusan ) {
		$sql = "insert into assignment_surat_tugas
				(assign_surat_id_assign, assign_surat_id, assign_surat_no, assign_surat_tgl, assign_surat_id_auditorTTD, assign_surat_type, assign_surat_tembusan) 
				values
				('".$assign_id."', '".$id."', '".$no_surat."', '".$tanggal_surat."', '".$ttd_id."', '".$jenis_surat."', '".$tembusan."')";
		$this->_db->_dbquery ( $sql );
	}
	function surat_tugas_edit ( $id, $no_surat, $tanggal_surat, $ttd_id, $jenis_surat, $tembusan ) {
		$sql = "update assignment_surat_tugas set assign_surat_no = '" . $no_surat . "', assign_surat_tgl = '" . $tanggal_surat . "', assign_surat_id_auditorTTD = '" . $ttd_id . "', assign_surat_type = '" . $jenis_surat . "', assign_surat_tembusan = '" . $tembusan . "' where assign_surat_id = '" . $id . "' ";
		$aksinyo = "Mengubah Surat Tugas dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function surat_tugas_viewlist($id) {
		$sql = "select assign_surat_id, assign_surat_no, assign_surat_tgl, assign_surat_id_auditorTTD, assign_surat_tembusan, auditor_name, assign_surat_type
				from assignment_surat_tugas
				left join auditor on assign_surat_id_auditorTTD = auditor_id
				where assign_surat_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function surat_assign_viewlist($id) {
		$sql = "select assign_surat_id, assign_surat_no, assign_surat_tgl, assign_dasar, assign_surat_tembusan, auditor_name, assign_surat_type, assign_surat_id_assign, assign_tugas, assign_tahun, assign_letter_date, auditor_nip, assign_surat_status
				from assignment_surat_tugas
				left join auditor on assign_surat_id_auditorTTD = auditor_id
				left join assignment on assign_surat_id_assign = assign_id
				where assign_surat_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function surat_tugas_add_komentar($id, $komentar, $tanggal) {
		$sql = "insert into assignment_surat_comment 
				(surat_comment_id, surat_comment_surat_id, surat_comment_user_id, surat_comment_desc, surat_comment_date) 
				values
				('" . $this->uniq_id () . "','" . $id . "','" . $this->userId . "','" . $komentar . "','" . $tanggal . "')";
		$aksinyo = "Mengomentari Surat Tugas dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function surat_tugas_komentar_viewlist($id) {
		$sql = "select auditor_name, surat_comment_desc, surat_comment_date
				FROM assignment_surat_comment
				left join user_apps on surat_comment_user_id = user_id
				left join auditor on user_id_internal = auditor_id
				where surat_comment_surat_id = '" . $id . "' order by surat_comment_date ASC";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function surat_tugas_update_status($id, $status, $tanggal) {
		$sql = "update assignment_surat_tugas set assign_surat_status = '".$status."', assign_surat_id_userPropose = '".$this->userId."', assign_surat_tgl_userPropose = '".$tanggal."' where assign_surat_id = '" . $id . "' ";
		$aksinyo = "Mengubah Status Surat Tugas dengan ID " . $id ." menjadi ".$status;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function surat_tugas_delete($id) {
		$sql = "delete from assignment_surat_tugas where assign_surat_id = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	//end surat tugas
	
	// laporan
	function assign_tahun_viewlist() {
		$sql = "select distinct assign_tahun from assignment" ;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function assign_lha_viewlist($id) {
		$sql = "select lha_no, lha_date, lha_ringkasan, lha_metodologi, lha_sasaran, lha_ruanglingkup, lha_batasan, lha_kegiatan, lha_informasi, lha_hasil, assign_id, assign_no, assign_no_lha, assign_date_lha, assign_periode, assign_dasar, assign_tujuan, assign_start_date, assign_end_date, lha_status, lha_id
				from assignment_lha
				left join assignment on assign_id = lha_id_assign
				where lha_id_assign = '".$id."' " ;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function list_lha_lampiran($id) {
		$sql = "select lha_attach_id_assign, lha_attach_name
				from assignment_lha_attachment where lha_attach_id_assign = '".$id."' " ;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function insert_lampiran_lha($id, $attach_name) {
		$sql = "insert into assignment_lha_attachment (lha_attach_id, lha_attach_id_assign, lha_attach_name) values ('" . $this->uniq_id() . "', '" . $id . "', '" . $attach_name . "')";
		$this->_db->_dbquery ( $sql );
	}
	function delete_lampiran_kka($id, $attach_name) {
		$sql = "delete from assignment_lha_attachment where lha_attach_id_assign = '" . $id . "' and lha_attach_name = '" . $attach_name . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function assign_update_lha($id, $no_lha, $tanggal_lha) {
		$sql = "update assignment set assign_no_lha = '".$no_lha."', assign_date_lha = '".$tanggal_lha."' where assign_id = '" . $id . "' ";
		$aksinyo = "Mengubah LHA Penugasan AUdit dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function lha_update ( $id, $no_lha, $tanggal_lha, $ringkasan, $metodologi_audit, $sasaran_audit, $ruang_lingkup, $batasan_tanggung_jawab, $kegiatan_auditan, $infomasi_umum, $hasil_yang_dicapai, $status_lha) {
		$sql = "update assignment_lha set lha_no = '".$no_lha."', lha_date = '".$tanggal_lha."', lha_ringkasan = '".$ringkasan."', lha_metodologi = '".$metodologi_audit."', lha_sasaran = '".$sasaran_audit."', lha_ruanglingkup = '".$ruang_lingkup."', lha_batasan = '".$batasan_tanggung_jawab."', lha_kegiatan = '".$kegiatan_auditan."', lha_informasi = '".$infomasi_umum."', lha_hasil = '".$hasil_yang_dicapai."', lha_status = '".$status_lha."' where lha_id_assign = '" . $id . "'";
		$data = $this->_db->_dbquery ( $sql );
	}
	function lha_update_status($id, $status) {
		$sql = "update assignment_lha set lha_status = '".$status."' where lha_id_assign = '" . $id . "' ";
		$aksinyo = "Mengubah Status LHA dengan ID " . $id ." menjadi ".$status;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	
	function temuan_list($assign_id) {
		$sql = "select finding_id, finding_judul, finding_kondisi, finding_kriteria, finding_sebab, finding_akibat, finding_tanggapan_auditee, finding_tanggapan_auditor
				FROM finding_internal
				where finding_assign_id = '".$assign_id."' "; 
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function get_user_by_posisi($id_assign, $id_posisi=""){
		$condition = '';
		if($id_posisi!='') $condition = " and assign_auditor_id_posisi = '".$id_posisi."' ";
		$sql = "select DISTINCT user_id from assignment_auditor
				join user_apps on assign_auditor_id_auditor = user_id_internal
				where assign_auditor_id_assign = '".$id_assign."'". $condition;
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr [0];
	}
	
	function notif_user_all_byinpektorat($inspektorat_id="", $user_id="") {
		$condition = "";
		if($inspektorat_id!="") $condition .= " and auditor_id_inspektorat = '".$inspektorat_id."' ";
		if($user_id!="") $condition .= " and user_id = '".$this->userId."' ";
		$sql = "select user_id from user_apps
				join auditor on user_id_internal = auditor_id
				join par_jenis_jabatan on auditor_id_jabatan = jenis_jabatan_id 
				where jenis_jabatan_sub LIKE '%Inspektur%' ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function lha_add_komentar($id, $komentar, $tanggal) {
		$sql = "insert into assignment_lha_comment 
				(lha_comment_id, lha_comment_lha_id, lha_comment_user_id, lha_comment_desc, lha_comment_date) 
				values
				('" . $this->uniq_id () . "','" . $id . "','" . $this->userId . "','" . $komentar . "','" . $tanggal . "')";
		$aksinyo = "Mengomentari LHA dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	
	function lha_komentar_viewlist($id) {
		$sql = "select auditor_name, lha_comment_desc, lha_comment_date
				FROM assignment_lha_comment
				left join user_apps on lha_comment_user_id = user_id
				left join auditor on user_id_internal = auditor_id
				where lha_comment_lha_id = '" . $id . "' order by lha_comment_date ASC";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function anggota_list($assign_id) {
		$sql = "select auditor_name, posisi_name
				from assignment_auditor
				left join auditor on assign_auditor_id_auditor = auditor_id
				left join par_posisi_penugasan on assign_auditor_id_posisi = posisi_id
				where assign_auditor_id_assign = '" . $assign_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function rekomendasi_list($find_id) {
		$sql = "select rekomendasi_desc
				from rekomendasi_internal
				where rekomendasi_finding_id = '" . $find_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
}
?>
