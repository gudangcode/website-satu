<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class auditor {
	var $_db;
	var $userId;
	function auditor($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function auditor_count($base_on_id_int="", $key_search, $val_search, $all_field) {
		$condition = "";
		if($base_on_id_int!="") $condition = " and auditor_id = '".$base_on_id_int."' ";
		
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
		
		$sql = "select count(*) FROM auditor
				left join par_pangkat_auditor on auditor_id_pangkat = pangkat_id
				where auditor_del_st != 0 ".$condition.$condition2;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function auditor_viewlist($base_on_id_int="", $key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($base_on_id_int!="") $condition = " and auditor_id = '".$base_on_id_int."' ";
		
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
		
		$sql = "select auditor_id, auditor_nip, auditor_name, concat(pangkat_name,' - ',pangkat_desc) as auditor_pangkat, auditor_golongan, auditor_email
				from auditor
				left join par_pangkat_auditor on auditor_id_pangkat = pangkat_id
				where auditor_del_st != 0 ".$condition.$condition2." order by auditor_name LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nip_auditor($nip, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and auditor_id != '" . $id . "' ";
		$sql = "select auditor_id, auditor_del_st FROM auditor where LCASE(auditor_nip) = '" . strtolower ( $nip ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function auditor_data_viewlist($id) {
		$sql = "select auditor_id, auditor_nip, auditor_name, auditor_tempat_lahir, auditor_tgl_lahir, auditor_golongan, auditor_mobile, auditor_telp, auditor_email, concat(pangkat_name,' - ',pangkat_desc) as auditor_pangkat, auditor_id_pangkat, auditor_id_jabatan, jenis_jabatan, jenis_jabatan_sub, auditor_id_inspektorat, inspektorat_name
				FROM auditor
				left join par_pangkat_auditor on auditor_id_pangkat = pangkat_id
				left join par_jenis_jabatan on auditor_id_jabatan = jenis_jabatan_id
				left join par_inspektorat on auditor_id_inspektorat = inspektorat_id
				where auditor_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function auditor_add($nip, $name, $tempat_lahir, $tanggal_lahir, $pangkat, $jabatan, $golongan, $mobile, $telp, $email, $inpektorat_id) {
		$sql = "insert into auditor (auditor_id, auditor_nip, auditor_name, auditor_tempat_lahir, auditor_tgl_lahir, auditor_id_pangkat,  	auditor_id_jabatan, auditor_golongan, auditor_mobile, auditor_telp, auditor_email, auditor_del_st, auditor_id_inspektorat) values ('" . $this->uniq_id () . "','" . $nip . "','" . $name . "','" . $tempat_lahir . "','" . $tanggal_lahir . "','" . $pangkat . "','" . $jabatan . "','" . $golongan . "','" . $mobile . "','" . $telp . "','" . $email . "','1','" . $inpektorat_id . "')";
		$aksinyo = "Menambah " . $nip . " - " . $name . ".Sebagai Auditor";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function auditor_edit($id, $nip, $name, $tempat_lahir, $tanggal_lahir, $pangkat, $jabatan, $golongan, $mobile, $telp, $email, $inpektorat_id) {
		$sql = "update auditor set auditor_nip = '" . $nip . "', auditor_name = '" . $name . "', auditor_tempat_lahir = '" . $tempat_lahir . "', auditor_tgl_lahir = '" . $tanggal_lahir . "', auditor_id_pangkat = '" . $pangkat . "', auditor_id_jabatan = '" . $jabatan . "', auditor_golongan = '" . $golongan . "', auditor_mobile = '" . $mobile . "', auditor_telp = '" . $telp . "', auditor_email = '" . $email . "', auditor_id_inspektorat = '" . $inpektorat_id . "' where auditor_id = '" . $id . "' ";
		$aksinyo = "Mengubah Data Auditor dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function auditor_delete($id) {
		$sql = "update auditor set auditor_del_st = '0' where auditor_id = '" . $id . "' ";
		$aksinyo = "Menghapus Auditor ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_auditor_del($id, $nip, $name, $tempat_lahir, $tanggal_lahir, $pangkat, $jabatan, $golongan, $mobile, $telp, $email, $inpektorat_id) {
		$sql = "update auditor set auditor_del_st = '1', auditor_nip = '" . $nip . "', auditor_name = '" . $name . "', auditor_tempat_lahir = '" . $tempat_lahir . "', auditor_tgl_lahir = '" . $tanggal_lahir . "', auditor_id_pangkat = '" . $pangkat . "', auditor_id_jabatan = '" . $jabatan . "', auditor_golongan = '" . $golongan . "', auditor_mobile = '" . $mobile . "', auditor_telp = '" . $telp . "', auditor_email = '" . $email . "', auditor_id_inspektorat = '" . $inpektorat_id . "' where auditor_id = '" . $id . "' ";
		$aksinyo = "Menampilakan Kembali Auditor dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	
	// pelatihan
	function pelatihan_count($auditor_id) {
		$sql = "select count(*) FROM auditor_pelatihan
				where pelatihan_auditor_id = '" . $auditor_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function pelatihan_viewlist($auditor_id, $offset, $num_row) {
		$sql = "select pelatihan_id, kompetensi_name, pelatihan_nama, concat(pelatihan_durasi, ' Jam') as lengkap, pelatihan_penyelenggara, pelatihan_tanggal_akhir
				from auditor_pelatihan
				left join par_kompetensi on pelatihan_kompetensi_id = kompetensi_id
				where pelatihan_auditor_id = '" . $auditor_id . "' 
				LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function pelatihan_data_viewlist($id) {
		$sql = "select pelatihan_id, pelatihan_kompetensi_id, pelatihan_nama, pelatihan_durasi, pelatihan_tanggal_awal, pelatihan_tanggal_akhir, pelatihan_penyelenggara, pelatihan_sertifikat, kompetensi_name
				FROM auditor_pelatihan
				left join par_kompetensi on pelatihan_kompetensi_id = kompetensi_id
				where pelatihan_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function pelatihan_add($auditor_id, $kompetensi, $name, $jam, $tanggal_awal, $tanggal_akhir, $penyelenggara, $sertifikat) {
		$sql = "insert into auditor_pelatihan (pelatihan_id, pelatihan_auditor_id, pelatihan_kompetensi_id, pelatihan_nama, pelatihan_durasi, pelatihan_tanggal_awal, pelatihan_tanggal_akhir, pelatihan_penyelenggara, pelatihan_sertifikat) 
				values 
				('" . $this->uniq_id () . "','" . $auditor_id . "','" . $kompetensi . "','" . $name . "','" . $jam . "','" . $tanggal_awal . "','" . $tanggal_akhir . "','" . $penyelenggara . "','" . $sertifikat . "')";
		$aksinyo = "Menambah Pelatihan Auditor";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function pelatihan_edit($id, $kompetensi, $name, $jam, $tanggal_awal, $tanggal_akhir, $penyelenggara, $sertifikat) {
		$sql = "update auditor_pelatihan set pelatihan_kompetensi_id = '" . $kompetensi . "', pelatihan_nama = '" . $name . "', pelatihan_durasi = '" . $jam . "', pelatihan_tanggal_awal = '" . $tanggal_awal . "', pelatihan_tanggal_akhir = '" . $tanggal_akhir . "', pelatihan_penyelenggara = '" . $penyelenggara . "', pelatihan_sertifikat = '" . $sertifikat . "'
				where pelatihan_id = '" . $id . "' ";
		$aksinyo = "Mengubah Data Pelatihan Auditor dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function pelatihan_delete($id) {
		$sql = "delete from auditor_pelatihan where pelatihan_id = '" . $id . "' ";
		$aksinyo = "Menghapus Auditor ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	
	//history
	function history_penugasan_count($auditor_id) {
		$sql = "select count(DISTINCT assign_auditor_id_assign) 
				from assignment_auditor
				left join assignment on assign_auditor_id_assign = assign_id
				left join auditee on assign_auditor_id_auditee = auditee_id
				left join par_posisi_penugasan on assign_auditor_id_posisi = posisi_id
				where assign_auditor_id_auditor = '" . $auditor_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function history_penugasan_viewlist($auditor_id) {
		$sql = "select DISTINCT assign_auditor_id_assign, assign_no, auditee_name, posisi_name
				from assignment_auditor
				left join assignment on assign_auditor_id_assign = assign_id
				left join auditee on assign_auditor_id_auditee = auditee_id
				left join par_posisi_penugasan on assign_auditor_id_posisi = posisi_id
				where assign_auditor_id_auditor = '" . $auditor_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
}
?>
