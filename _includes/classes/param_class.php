<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class param {
	var $_db;
	var $userId;
	function param($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}

	// propinsi
	function propinsi_count($key_search, $val_search, $all_field) {

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
		$sql = "select count(*) FROM par_propinsi where propinsi_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function propinsi_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select propinsi_id, propinsi_name
				FROM par_propinsi where propinsi_del_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_propinsi($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and propinsi_id != '" . $id . "' ";
		$sql = "select propinsi_id, propinsi_del_st FROM par_propinsi where LCASE(propinsi_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function propinsi_data_viewlist($id="",$additionalcondition="") {
		$condition = "";
		if($id!="") $condition = " and propinsi_id = '" . $id . "' ";
		$sql = "select propinsi_id, propinsi_name FROM par_propinsi where 1=1 ".$condition." ".$additionalcondition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function propinsi_add($name) {
		$sql = "insert into par_propinsi (propinsi_id, propinsi_name, propinsi_del_st) values ('" . $this->uniq_id () . "','" . $name . "','1')";
		$aksinyo = "Menambah Parameter Propinsi " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function propinsi_edit($id, $nama) {
		$sql = "update par_propinsi set propinsi_name = '" . $nama . "' where propinsi_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Propinsi dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function propinsi_delete($id) {
		$sql = "update par_propinsi set propinsi_del_st = '0' where propinsi_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Propinsi ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_propinsi_del($id) {
		$sql = "update par_propinsi set propinsi_del_st = '1' where propinsi_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Propinsi ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end propinsi

	// Inspektorat
	function inspektorat_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_inspektorat where inspektorat_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function inspektorat_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select inspektorat_id, inspektorat_name
				FROM par_inspektorat where inspektorat_del_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_inspektorat($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and inspektorat_id != '" . $id . "' ";
		$sql = "select inspektorat_id, inspektorat_del_st FROM par_inspektorat where LCASE(inspektorat_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function inspektorat_data_viewlist($id) {
		$sql = "select inspektorat_id, inspektorat_name FROM par_inspektorat where inspektorat_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function inspektorat_add($name) {
		$sql = "insert into par_inspektorat (inspektorat_id, inspektorat_name, inspektorat_del_st) values ('" . $this->uniq_id () . "','" . $name . "','1')";
		$aksinyo = "Menambah Parameter Inspektorat " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function inspektorat_edit($id, $nama) {
		$sql = "update par_inspektorat set inspektorat_name = '" . $nama . "' where inspektorat_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Inspektorat dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function inspektorat_delete($id) {
		$sql = "update par_inspektorat set inspektorat_del_st = '0' where inspektorat_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Inspektorat ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_inspektorat_del($id) {
		$sql = "update par_inspektorat set inspektorat_del_st = '1' where inspektorat_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Inspektorat ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Inspektorat

	// pic
	function pic_count($auditee_id) {
		$sql = "select count(*) FROM auditee_pic where pic_del_st = 1  and pic_auditee_id = '" . $auditee_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function pic_viewlist($auditee_id, $offset, $num_row) {
		$sql = "select pic_id, pic_nip, pic_name, jabatan_pic_name, pic_email
				FROM auditee_pic
				left join par_jabatan_pic on pic_jabatan_id = jabatan_pic_id
				where pic_del_st = 1 and pic_auditee_id = '" . $auditee_id . "' order by pic_name LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nip_pic($nip, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and pic_id != '" . $id . "' ";
		$sql = "select pic_id, pic_del_st FROM auditee_pic where LCASE(pic_nip) = '" . strtolower ( $nip ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function pic_data_viewlist($id) {
		$sql = "select pic_id, pic_nip, pic_name, pic_jabatan_id, pic_mobile, pic_telp, pic_email, jabatan_pic_name
				FROM auditee_pic
				left join par_jabatan_pic on pic_jabatan_id = jabatan_pic_id
				where pic_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function pic_add($nip, $name, $jabatan_id, $mobile, $telp, $email, $auditee) {
		$sql = "insert into auditee_pic (pic_id, pic_nip, pic_name, pic_jabatan_id, pic_mobile, pic_telp, pic_email, pic_auditee_id, pic_del_st) values ('" . $this->uniq_id () . "','" . $nip . "','" . $name . "','" . $jabatan_id . "','" . $mobile . "','" . $telp . "','" . $email . "','" . $auditee . "','1')";
		$aksinyo = "Menambah " . $name . " sebagai PIC Auditee";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function pic_edit($id, $nip, $name, $jabatan_id, $mobile, $telp, $email) {
		$sql = "update auditee_pic set pic_nip = '" . $nip . "', pic_name = '" . $name . "', pic_jabatan_id = '" . $jabatan_id . "', pic_mobile = '" . $mobile . "', pic_telp = '" . $telp . "', pic_email = '" . $email . "' where pic_id = '" . $id . "' ";
		$aksinyo = "Mengubah PIC dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function pic_delete($id) {
		$sql = "update auditee_pic set pic_del_st = '0' where pic_id = '" . $id . "' ";
		$aksinyo = "Menghapus PIC ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_pic_del($id, $nip, $name, $jabatan_id, $mobile, $telp, $email, $auditee) {
		$sql = "update auditee_pic set pic_del_st = '1', pic_nip = '" . $nip . "', pic_name = '" . $name . "', pic_jabatan_id = '" . $jabatan_id . "', pic_mobile = '" . $mobile . "', pic_telp = '" . $telp . "', pic_email = '" . $email . "', pic_auditee_id = '" . $auditee . "' where pic_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali PIC dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end PIC

	// jabatan pic
	function jabatan_pic_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_jabatan_pic where jabatan_pic_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function jabatan_pic_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select jabatan_pic_id, jabatan_pic_name
				FROM par_jabatan_pic where jabatan_pic_del_st = 1 ".$condition." order by jabatan_pic_sort LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_jabatan_pic($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and jabatan_pic_id != '" . $id . "' ";
		$sql = "select jabatan_pic_id, jabatan_pic_del_st FROM par_jabatan_pic where LCASE(jabatan_pic_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function jabatan_pic_data_viewlist($id) {
		$sql = "select jabatan_pic_id, jabatan_pic_name, jabatan_pic_sort FROM par_jabatan_pic where jabatan_pic_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function jabatan_pic_add($name, $sort) {
		$sql = "insert into par_jabatan_pic (jabatan_pic_id, jabatan_pic_name, jabatan_pic_sort, jabatan_pic_del_st) values ('" . $this->uniq_id () . "','" . $name . "','" . $sort . "','1')";
		$aksinyo = "Menambah Parameter Jabatan PIC " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function jabatan_pic_edit($id, $nama, $sort) {
		$sql = "update par_jabatan_pic set jabatan_pic_name = '" . $nama . "', jabatan_pic_sort = '" . $sort . "' where jabatan_pic_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Jabatan PIC dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function jabatan_pic_delete($id) {
		$sql = "update par_jabatan_pic set jabatan_pic_del_st = '0' where jabatan_pic_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Jabatan PIC ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_jabatan_pic_del($id, $nama, $sort) {
		$sql = "update par_jabatan_pic set jabatan_pic_del_st = '1', jabatan_pic_name = '" . $nama . "', jabatan_pic_sort = '" . $sort . "' where jabatan_pic_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Jabatan PIC ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Jabatan PIC

	// Tipe Audit
	function audit_type_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_audit_type where audit_type_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function audit_type_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select audit_type_id, audit_type_name, audit_type_desc
				FROM par_audit_type where audit_type_del_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_audit_type($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and audit_type_id != '" . $id . "' ";
		$sql = "select audit_type_id, audit_type_del_st FROM par_audit_type where LCASE(audit_type_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function audit_type_data_viewlist($id) {
		$sql = "select audit_type_id, audit_type_name, audit_type_desc FROM par_audit_type where audit_type_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function audit_type_add($name, $desc) {
		$sql = "insert into par_audit_type (audit_type_id, audit_type_name, audit_type_desc, audit_type_del_st) values ('" . $this->uniq_id () . "','" . $name . "','" . $desc . "','1')";
		$aksinyo = "Menambah Parameter Tipe Audit " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function audit_type_edit($id, $nama, $desc) {
		$sql = "update par_audit_type set audit_type_name = '" . $nama . "', audit_type_desc = '" . $desc . "' where audit_type_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Tipe Audit dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function audit_type_delete($id) {
		$sql = "update par_audit_type set audit_type_del_st = '0' where audit_type_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Tipe Audit ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_audit_type_del($id, $nama, $desc) {
		$sql = "update par_audit_type set audit_type_del_st = '1', audit_type_name = '" . $nama . "', audit_type_desc = '" . $desc . "' where audit_type_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Tipe Audit ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Tipe Audit

	// Kode Penyebab
	function kode_penyebab_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_kode_penyebab where kode_penyebab_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function kode_penyebab_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select kode_penyebab_id, kode_penyebab_name, kode_penyebab_desc
				FROM par_kode_penyebab where kode_penyebab_del_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_kode_penyebab($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and kode_penyebab_id != '" . $id . "' ";
		$sql = "select kode_penyebab_id, kode_penyebab_del_st FROM par_kode_penyebab where LCASE(kode_penyebab_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function kode_penyebab_data_viewlist($id) {
		$sql = "select kode_penyebab_id, kode_penyebab_name, kode_penyebab_desc FROM par_kode_penyebab where kode_penyebab_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function kode_penyebab_add($name, $desc) {
		$sql = "insert into par_kode_penyebab (kode_penyebab_id, kode_penyebab_name, kode_penyebab_desc, kode_penyebab_del_st) values ('" . $this->uniq_id () . "','" . $name . "','" . $desc . "','1')";
		$aksinyo = "Menambah Parameter Kode Penyebab " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function kode_penyebab_edit($id, $nama, $desc) {
		$sql = "update par_kode_penyebab set kode_penyebab_name = '" . $nama . "', kode_penyebab_desc = '" . $desc . "' where kode_penyebab_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Kode Penyebab dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function kode_penyebab_delete($id) {
		$sql = "update par_kode_penyebab set kode_penyebab_del_st = '0' where kode_penyebab_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Kode Penyebab ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_kode_penyebab_del($id, $nama, $desc) {
		$sql = "update par_kode_penyebab set kode_penyebab_del_st = '1', kode_penyebab_name = '" . $nama . "', kode_penyebab_desc = '" . $desc . "' where kode_penyebab_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Kode Penyebab ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Kode Penyebab

	// Tipe Temuan
	function finding_type_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}

		$sql = "select count(*) FROM par_finding_type where finding_type_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function finding_type_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}

		$sql = "select finding_type_id, finding_type_code, finding_type_name
				FROM par_finding_type where finding_type_del_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_finding_type($nama, $id = "") {
		$condition = "";
		if ($id != "") $condition = "and finding_type_id != '" . $id . "' ";
		$sql = "select finding_type_id, finding_type_del_st FROM par_finding_type where LCASE(finding_type_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function finding_type_data_viewlist($id = "") {
		$condition = "";
		if ($id != "") $condition = "and finding_type_id = '" . $id . "' ";
		$sql = "select finding_type_id, finding_type_code, finding_type_name FROM par_finding_type where finding_type_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function finding_type_add($code, $name) {
		$sql = "insert into par_finding_type (finding_type_id, finding_type_code, finding_type_name, finding_type_del_st) values ('" . $this->uniq_id () . "','" . $code . "','" . $name . "','1')";
		$aksinyo = "Menambah Parameter Tipe Temuan " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function finding_type_edit($id, $code, $name) {
		$sql = "update par_finding_type set finding_type_code = '" . $code . "', finding_type_name = '" . $name . "' where finding_type_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Tipe Temuan dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function finding_type_delete($id) {
		$sql = "update par_finding_type set finding_type_del_st = '0' where finding_type_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Tipe Temuan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_finding_type_del($id, $code, $name) {
		$sql = "update par_finding_type set finding_type_del_st = '1', finding_type_code = '" . $code . "', finding_type_name = '" . $name . "' where finding_type_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Tipe Temuan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Tipe Temuan

	// holiday
	function holiday_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_holiday where holiday_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function holiday_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select holiday_id, holiday_date, holiday_desc
				FROM par_holiday where holiday_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_tanggal($tanggal, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and holiday_id != '" . $id . "' ";
		$sql = "select holiday_st FROM par_holiday where holiday_date = '" . $tanggal . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function holiday_data_viewlist($id) {
		$sql = "select holiday_id, holiday_date, holiday_desc FROM par_holiday where holiday_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function holiday_add($tanggal, $desc) {
		$sql = "insert into par_holiday (holiday_date, holiday_desc, holiday_st) values ('" . $tanggal . "','" . $desc . "','1')";
		$aksinyo = "Menambah Hari Libur Tanggal " . $tanggal;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function holiday_edit($id, $tanggal, $desc) {
		$sql = "update par_holiday set holiday_date = '" . $tanggal . "', holiday_desc = '" . $desc . "' where holiday_id = '" . $id . "' ";
		$aksinyo = "Mengubah Hari Libur Dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_holiday_weekday($tanggal, $desc, $st) {
		$sql = "update par_holiday set holiday_desc = '" . $desc . "', holiday_st = '" . $st . "' where holiday_date = '" . $tanggal . "' ";
		$aksinyo = "Mengubah id " . $tanggal . " weekend menjadi weekdays";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function holiday_delete($id) {
		$rs = $this->holiday_data_viewlist ( $id );
		$arr = $rs->FetchRow ();
		$sql = "delete from par_holiday where holiday_id = '" . $id . "' ";
		$aksinyo = "Menghapus Hari Libur Tanggal " . $arr ['holiday_date'];
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function insert_weekend($tanggal, $st) {
		$sql = "insert into par_holiday (holiday_date, holiday_st) values ('" . $tanggal . "','" . $st . "')";
		$this->_db->_dbquery ( $sql );
	}
	// end holiday

	// posisi penugasan
	function posisi_penugasan_count() {
		$sql = "select count(*) FROM par_posisi_penugasan where posisi_del_st = 1 ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function posisi_penugasan_viewlist($offset, $num_row) {
		$sql = "select posisi_id, posisi_name, posisi_sort
				FROM par_posisi_penugasan where posisi_del_st = 1 order by posisi_sort LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_posisi_penugasan($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and posisi_id != '" . $id . "' ";
		$sql = "select posisi_id, posisi_del_st FROM par_posisi_penugasan where LCASE(posisi_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function posisi_penugasan_data_viewlist($id) {
		$sql = "select posisi_id, posisi_name, posisi_sort FROM par_posisi_penugasan where posisi_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function posisi_penugasan_add($posisi, $name, $sort) {
		$sql = "insert into par_posisi_penugasan (posisi_id, posisi_name, posisi_sort, posisi_del_st) values ('" . $posisi . "','" . $name . "','" . $sort . "','1')";
		$aksinyo = "Menambah Parameter Posisi Penugasan " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function posisi_add_role($posisi, $akses) {
		$sql = "insert into par_posisi_role (audit_akses_posisi_id, audit_akses_action) values ('" . $posisi . "','" . $akses . "')";
		$this->_db->_dbquery ( $sql );
	}
	function posisi_penugasan_edit($id, $nama, $sort) {
		$sql = "update par_posisi_penugasan set posisi_name = '" . $nama . "', posisi_sort = '" . $sort . "' where posisi_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Posisi Penugasan dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function posisi_penugasan_delete($id) {
		$sql = "update par_posisi_penugasan set posisi_del_st = '0' where posisi_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Posisi Penugasan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_posisi_penugasan_del($id, $nama, $sort) {
		$sql = "update par_posisi_penugasan set posisi_del_st = '1', posisi_name = '" . $nama . "', posisi_sort = '" . $sort . "' where posisi_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Posisi Penugasan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function cek_posisi_akses($posisi_id, $akses) {
		$sql = "select count(*) from par_posisi_role where audit_akses_posisi_id = '" . $posisi_id . "' and audit_akses_action = '" . $akses . "' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function clean_posisi_role($posisi_id) {
		$sql = "delete from par_posisi_role where audit_akses_posisi_id = '" . $posisi_id . "'";
		$this->_db->_dbquery ( $sql );
	}
	// end posisi penugasan

	// ref prgram
	function ref_program_count() {
		$sql = "select count(*) FROM ref_program_audit where ref_program_del_st = 1 ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function ref_program_viewlist($offset, $num_row) {
		$sql = "select ref_program_id, ref_program_code, bidang_subtansi_name, ref_program_title
				FROM ref_program_audit
				left join par_bidang_subtansi on ref_program_bidang_id = bidang_subtansi_id
				where ref_program_del_st = 1 LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_kode_ref_program($code, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and ref_program_id != '" . $id . "' ";
		$sql = "select ref_program_id, ref_program_del_st FROM ref_program_audit where LCASE(ref_program_code) = '" . strtolower ( $code ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function ref_program_data_viewlist($id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and ref_program_id = '" . $id . "' ";
		$sql = "select ref_program_id, ref_program_id_type, ref_program_code, ref_program_bidang_id, ref_program_title, ref_program_tao, ref_program_risiko, ref_program_kriteria, ref_program_procedure, bidang_subtansi_name, concat(ref_program_code, ' - ' ,ref_program_title) as kode_judul, audit_type_name
				FROM ref_program_audit
				left join par_audit_type on ref_program_id_type = audit_type_id
				left join par_bidang_subtansi on ref_program_bidang_id = bidang_subtansi_id
				where ref_program_del_st = 1 " . $condition; //echo $sql;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function ref_program_add($tipe_audit, $code, $bidang_sub_id, $title, $tao, $prog_risiko, $prog_kriteria, $procedure) {
		$sql = "insert into ref_program_audit (ref_program_id, ref_program_id_type, ref_program_code, ref_program_bidang_id, ref_program_title, ref_program_tao, ref_program_risiko, ref_program_kriteria, ref_program_procedure, ref_program_del_st)
				values
				('" . $this->uniq_id () . "','" . $tipe_audit . "','" . $code . "','" . $bidang_sub_id . "','" . $title . "','" . $tao . "','" . $prog_risiko . "','" . $prog_kriteria . "','" . $procedure . "','1')";
		$aksinyo = "Menambah Referensi Program Audit " . $code;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function ref_program_edit($id, $tipe_audit, $code, $bidang_sub_id, $title, $tao, $prog_risiko, $prog_kriteria, $procedure) {
		$sql = "update ref_program_audit set ref_program_id_type = '" . $tipe_audit . "', ref_program_code = '" . $code . "', ref_program_bidang_id = '" . $bidang_sub_id . "', ref_program_title = '" . $title . "', ref_program_tao = '" . $tao . "', ref_program_risiko = '" . $prog_risiko . "', ref_program_kriteria = '" . $prog_kriteria . "', ref_program_procedure = '" . $procedure . "'
				where ref_program_id = '" . $id . "' ";
		$aksinyo = "Mengubah Referensi Program Audit dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function ref_program_delete($id) {
		$sql = "update ref_program_audit set ref_program_del_st = '0' where ref_program_id = '" . $id . "' ";
		$aksinyo = "Menghapus Referensi Program Audit ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_ref_program_del($id, $tipe_audit, $code, $bidang_sub_id, $title, $tao, $prog_risiko, $prog_kriteria, $procedure) {
		$sql = "update ref_program_audit set ref_program_del_st = '1', ref_program_id_type = '" . $tipe_audit . "', ref_program_code = '" . $code . "', ref_program_bidang_id = '" . $bidang_sub_id . "', ref_program_title = '" . $title . "', ref_program_tao = '" . $tao . "', ref_program_risiko = '" . $prog_risiko . "', ref_program_kriteria = '" . $prog_kriteria . "', ref_program_procedure = '" . $procedure . "' where ref_program_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Referensi Program Audit ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function get_ref_desc($id) {
		$id = str_replace(",","','",$id);
		$sql = "select ref_program_procedure, ref_program_code, ref_program_title FROM ref_program_audit where ref_program_id in ('" . $id ."') " ;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	// end ref prgram

	// ref audit
	function ref_audit_count() {
		$sql = "select count(*) FROM ref_audit where ref_audit_del_st = 1 ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function ref_audit_viewlist($offset, $num_row) {
		$sql = "select ref_audit_id, ref_audit_nama, ref_audit_desc, kategori_ref_name, ref_audit_attach
				FROM ref_audit
				left join par_kategori_ref on ref_audit_id_kategori = kategori_ref_id
				where ref_audit_del_st = 1 LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_kode_ref_audit($name, $id_kategori, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and ref_audit_id != '" . $id . "' ";
		$sql = "select ref_audit_id, ref_audit_del_st FROM ref_audit where LCASE(ref_audit_nama) = '" . strtolower ( $name ) . "' and ref_audit_id_kategori = '".$id_kategori."' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function ref_audit_data_viewlist($id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and ref_audit_id = '" . $id . "' ";
		$sql = "select ref_audit_id, ref_audit_nama, ref_audit_desc, ref_audit_id_kategori, ref_audit_attach
				FROM ref_audit
				where ref_audit_del_st = 1 " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function ref_audit_add($id_kat, $name, $desc, $attach) {
		$sql = "insert into ref_audit (ref_audit_id, ref_audit_id_kategori, ref_audit_nama, ref_audit_desc, ref_audit_attach, ref_audit_del_st)
				values
				('" . $this->uniq_id () . "','" . $id_kat . "','" . $name . "','" . $desc . "','" . $attach . "','1')";
		$aksinyo = "Menambah Referensi Audit " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function ref_audit_edit($id, $id_kat, $name, $desc, $attach) {
		$sql = "update ref_audit set ref_audit_id_kategori = '" . $id_kat . "', ref_audit_nama = '" . $name . "', ref_audit_desc = '" . $desc . "', ref_audit_attach = '" . $attach . "'
				where ref_audit_id = '" . $id . "' ";
		$aksinyo = "Mengubah Referensi Audit dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function ref_audit_delete($id) {
		$sql = "update ref_audit set ref_audit_del_st = '0' where ref_audit_id = '" . $id . "' ";
		$aksinyo = "Menghapus Referensi Audit ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_ref_audit_del($id, $id_kat, $name, $desc) {
		$sql = "update ref_audit set ref_audit_del_st = '1', ref_audit_id_kategori = '" . $id_kat . "', ref_audit_nama = '" . $name . "', ref_audit_desc = '" . $desc . "'  where ref_audit_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Referensi Audit ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end ref audit

	// kategori risiko
	function risk_kategori_count() {
		$sql = "select count(*) FROM par_risk_kategori where risk_kategori_del_st != 0 ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function risk_kategori_viewlist($offset, $num_row) {
		$sql = "select risk_kategori_id, risk_kategori
				from par_risk_kategori
				where risk_kategori_del_st != 0 LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_kategori_data_viewlist($id = "") {
		$condition = "";
		if ($id != "")
			$condition = " and risk_kategori_id = '" . $id . "'";
		$sql = "select risk_kategori_id, risk_kategori FROM par_risk_kategori where 1=1 " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_risk_kategori($nama, $data_id = "") {
		$condition = "";
		if ($data_id != "")
			$condition = "and risk_kategori_id != '" . $data_id . "' ";
		$sql = "select risk_kategori_id, risk_kategori_del_st FROM par_risk_kategori where LCASE(risk_kategori) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_kategori_add($name) {
		$sql = "insert into par_risk_kategori (risk_kategori_id, risk_kategori, risk_kategori_del_st)
				values
				('" . $this->uniq_id () . "','" . $name . "','1')";
		$aksinyo = "Menambah Kategori Risiko " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_kategori_edit($id, $name) {
		$sql = "update par_risk_kategori set risk_kategori = '" . $name . "' where risk_kategori_id = '" . $id . "' ";
		$aksinyo = "Mengubah Kategori Risiko ID " . $id . " Menjadi " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_kategori_delete($id) {
		$sql = "update par_risk_kategori set risk_kategori_del_st = '0' where risk_kategori_id = '" . $id . "' ";
		$aksinyo = "Menghapus Kategori Risiko ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_risk_kategori_del($id) {
		$sql = "update par_risk_kategori set risk_kategori_del_st = '1' where risk_kategori_id = '" . $id . "' ";
		$aksinyo = "Menampilakan Kembali Kategori Risiko ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end kategori risiko

	// selera risiko
	function risk_selera_count($key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM par_risk_selera where risk_selera_del_st != 0 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function risk_selera_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select risk_selera_id, risk_selera
				from par_risk_selera
				where risk_selera_del_st != 0 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_selera_data_viewlist($id) {
		$sql = "select risk_selera_id, risk_selera FROM par_risk_selera where risk_selera_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_risk_selera($nama, $data_id = "") {
		$condition = "";
		if ($data_id != "")
			$condition = "and risk_selera_id != '" . $data_id . "' ";
		$sql = "select risk_selera_id, risk_selera_del_st FROM par_risk_selera where LCASE(risk_selera) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_selera_add($name) {
		$sql = "insert into par_risk_selera (risk_selera_id, risk_selera, risk_selera_del_st)
				values
				('" . $this->uniq_id () . "','" . $name . "','1')";
		$aksinyo = "Menambah selera Risiko " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_selera_edit($id, $name) {
		$sql = "update par_risk_selera set risk_selera = '" . $name . "' where risk_selera_id = '" . $id . "' ";
		$aksinyo = "Mengubah selera Risiko ID " . $id . " Menjadi " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_selera_delete($id) {
		$sql = "update par_risk_selera set risk_selera_del_st = '0' where risk_selera_id = '" . $id . "' ";
		$aksinyo = "Menghapus selera Risiko ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_risk_selera_del($id) {
		$sql = "update par_risk_selera set risk_selera_del_st = '1' where risk_selera_id = '" . $id . "' ";
		$aksinyo = "Menampilakan Kembali Level Risiko ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end level risiko

	// Tingkat Kemungkinan
	function risk_tk_count($key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM par_risk_tk where 1=1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function risk_tk_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select tk_id, tk_name, tk_value, tk_desc
				FROM par_risk_tk
				where 1=1 ".$condition." order by tk_value LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_tk_data_viewlist($id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and tk_id = '" . $id . "' ";
		$sql = "select tk_id, tk_name, tk_value, concat(tk_name,' (',tk_value,')') as tk_lengkap, tk_desc FROM par_risk_tk where 1=1 " . $condition . " order by tk_value ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_tk_add($name, $value, $desc) {
		$sql = "insert into par_risk_tk (tk_id, tk_name, tk_value, tk_desc) values ('" . $this->uniq_id () . "','" . $name . "','" . $value . "', '" . $desc . "')";
		$aksinyo = "Menambah Parameter Tingkat Kemungkinan " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_tk_edit($id, $nama, $value, $desc) {
		$sql = "update par_risk_tk set tk_name = '" . $nama . "', tk_value = '" . $value . "', tk_desc = '" . $desc . "' where tk_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Tingkat Kemungkinan dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_tk_delete($id) {
		$sql = "delete from par_risk_tk where tk_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Tingkat Kemungkinan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Tingkat Kemungkinan

	// Tingkat Dampak
	function risk_td_count($key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM par_risk_td where 1=1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function risk_td_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select td_id, td_name, td_value, td_desc
				FROM par_risk_td where 1=1 ".$condition." order by td_value LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_td_data_viewlist($id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and td_id = '" . $id . "' ";
		$sql = "select td_id, td_name, td_value, concat(td_name,' (',td_value,')') as td_lengkap, td_desc FROM par_risk_td where 1=1 " . $condition . " order by td_value ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_td_add($name, $value, $desc) {
		$sql = "insert into par_risk_td (td_id, td_name, td_value, td_desc) values ('" . $this->uniq_id () . "','" . $name . "','" . $value . "', '" . $desc . "')";
		$aksinyo = "Menambah Parameter Tingkat Dampak " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_td_edit($id, $nama, $value, $desc) {
		$sql = "update par_risk_td set td_name = '" . $nama . "', td_value = '" . $value . "', td_desc = '" . $desc . "' where td_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Tingkat Dampak dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_td_delete($id) {
		$sql = "delete from par_risk_td where td_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Tingkat Dampak ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Tingkat Dampak

	// Tingkat Risiko Inheren
	function risk_ri_count($key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM par_risk_ri where 1=1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function risk_ri_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select ri_id, ri_name, concat(ri_bawah, ' <= x <= ', ri_atas) as range_ri, ri_value, ri_warna
				FROM par_risk_ri where 1=1 ".$condition." order by ri_value
				LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_ri_data_viewlist($id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and ri_id = '" . $id . "' ";
		$sql = "select ri_id, ri_name, ri_atas, ri_bawah, ri_value, ri_warna FROM par_risk_ri where 1=1 " . $condition . " order by ri_value ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_ri_add($name, $atas, $bawah, $value, $warna) {
		$sql = "insert into par_risk_ri (ri_id, ri_name, ri_atas, ri_bawah, ri_value, ri_warna) values ('" . $this->uniq_id () . "','" . $name . "','" . $atas . "','" . $bawah . "','" . $value . "','" . $name . "')";
		$aksinyo = "Menambah Parameter Tingkat Risiko Inheren " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_ri_edit($id, $name, $atas, $bawah, $value, $warna) {
		$sql = "update par_risk_ri set ri_name = '" . $name . "', ri_atas = '" . $atas . "', ri_bawah = '" . $bawah . "', ri_value = '" . $value . "', ri_warna = '" . $warna . "' where ri_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Tingkat Risiko Inheren dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_ri_delete($id) {
		$sql = "delete from par_risk_ri where ri_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Tingkat Risiko Inheren ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Tingkat Risiko Inheren

	// Tingkat Risiko Residu
	function risk_rr_count($key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM par_risk_rr where 1=1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function risk_rr_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select rr_id, rr_name, concat(rr_bawah, ' < x <= ', rr_atas) as range_rr, rr_value, rr_warna
				FROM par_risk_rr where 1=1 ".$condition."
				order by rr_value
				LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_rr_data_viewlist($id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and rr_id = '" . $id . "' ";
		$sql = "select rr_id, rr_name, rr_atas, rr_bawah, rr_value, rr_warna FROM par_risk_rr where 1=1 " . $condition . " order by rr_value ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_rr_add($name, $atas, $bawah, $value, $warna) {
		$sql = "insert into par_risk_rr (rr_id, rr_name, rr_atas, rr_bawah, rr_value, rr_warna) values ('" . $this->uniq_id () . "','" . $name . "','" . $atas . "','" . $bawah . "','" . $value . "','" . $warna . "')";
		$aksinyo = "Menambah Parameter Tingkat Risiko Residu " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_rr_edit($id, $name, $atas, $bawah, $value, $warna) {
		$sql = "update par_risk_rr set rr_name = '" . $name . "', rr_atas = '" . $atas . "', rr_bawah = '" . $bawah . "', rr_value = '" . $value . "', rr_warna = '" . $warna . "' where rr_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Tingkat Risiko Residu dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_rr_delete($id) {
		$sql = "delete from par_risk_rr where rr_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Tingkat Risiko Residu ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Tingkat Risiko Residu

	// Pengendalian Internal
	function risk_pi_count($key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM par_risk_pi where 1=1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function risk_pi_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select pi_id, pi_name, pi_value, pi_desc
				FROM par_risk_pi where 1=1 ".$condition." order by pi_value
				LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_pi_data_viewlist($id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and pi_id = '" . $id . "' ";
		$sql = "select pi_id, pi_name, pi_value, concat(pi_name,' (',pi_value,')') as pi_lengkap, pi_desc FROM par_risk_pi where 1=1 " . $condition . " order by pi_value desc";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_pi_add($name, $value, $desc) {
		$sql = "insert into par_risk_pi (pi_id, pi_name, pi_value, pi_desc) values ('" . $this->uniq_id () . "','" . $name . "','" . $value . "', '" . $desc . "')";
		$aksinyo = "Menambah Parameter Pengendalian Internal " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_pi_edit($id, $nama, $value, $desc) {
		$sql = "update par_risk_pi set pi_name = '" . $nama . "', pi_value = '" . $value . "', pi_desc = '" . $desc . "' where pi_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Pengendalian Internal dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_pi_delete($id) {
		$sql = "delete from par_risk_pi where pi_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Pengendalian Internal ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Pengendalian Internal

	// Matrix Residu
	function get_matrix_residu_val($ri_id, $pi_id) {
		$sql = "select ri_id, ri_name, ri_warna
				from par_risk_matrix_residu
				left join par_risk_ri on matrix_residu_value = ri_id
				where matrix_residu_ri_id = '" . $ri_id . "' and matrix_residu_pi_id = '" . $pi_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function mapp_risk_residu_add($ri_id, $pi_id, $nilai) {
		$sql = "insert into par_risk_matrix_residu (matrix_residu_id, matrix_residu_ri_id, matrix_residu_pi_id, matrix_residu_value) values ('" . $this->uniq_id () . "','" . $ri_id . "','" . $pi_id . "', '" . $nilai . "')";
		$this->_db->_dbquery ( $sql, $this->userId );
	}
	function mapp_risk_residu_clean() {
		$sql = "truncate table par_risk_matrix_residu";
		$this->_db->_dbquery ( $sql, $this->userId );
	}
	// end Matrix Residu

	// Penanganan Risiko
	function risk_penanganan_count() {
		$sql = "select count(*) FROM par_risk_penanganan ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function risk_penanganan_viewlist($offset, $num_row) {
		$sql = "select risk_penanganan_id, risk_penanganan_jenis, risk_penanganan_desc, case risk_penanganan_status when '1' then 'Ya' else 'Tidak' end as status
		FROM par_risk_penanganan
		LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_penanganan_data_viewlist($id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and risk_penanganan_id = '" . $id . "' ";
		$sql = "select risk_penanganan_id, risk_penanganan_jenis, risk_penanganan_desc, risk_penanganan_status FROM par_risk_penanganan where 1=1 " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_penanganan_add($jenis, $desc, $status) {
		$sql = "insert into par_risk_penanganan (risk_penanganan_id, risk_penanganan_jenis, risk_penanganan_desc, risk_penanganan_status) values ('" . $this->uniq_id () . "','" . $jenis . "','" . $desc . "', '" . $status . "')";
		$aksinyo = "Menambah Parameter Penanganan Risiko " . $jenis;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_penanganan_edit($id, $jenis, $desc, $status) {
		$sql = "update par_risk_penanganan set risk_penanganan_jenis = '" . $jenis . "', risk_penanganan_desc = '" . $desc . "', risk_penanganan_status = '" . $status . "' where risk_penanganan_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Penanganan Risiko dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_penanganan_delete($id) {
		$sql = "delete from par_risk_penanganan where risk_penanganan_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Penanganan Risiko ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Penanganan Risiko

	// kompetensi
	function kompetensi_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_kompetensi where kompetensi_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function kompetensi_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select kompetensi_id, kompetensi_name, kompetensi_desc
				FROM par_kompetensi where kompetensi_del_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_kompetensi($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and kompetensi_id != '" . $id . "' ";
		$sql = "select kompetensi_id, kompetensi_del_st FROM par_kompetensi where LCASE(kompetensi_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function kompetensi_data_viewlist($id) {
		$sql = "select kompetensi_id, kompetensi_name, kompetensi_desc FROM par_kompetensi where kompetensi_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function kompetensi_add($name, $desc) {
		$sql = "insert into par_kompetensi (kompetensi_id, kompetensi_name, kompetensi_desc, kompetensi_del_st) values ('" . $this->uniq_id () . "','" . $name . "','" . $desc . "','1')";
		$aksinyo = "Menambah Parameter Tipe Audit " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function kompetensi_edit($id, $nama, $desc) {
		$sql = "update par_kompetensi set kompetensi_name = '" . $nama . "', kompetensi_desc = '" . $desc . "' where kompetensi_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter kompetensi dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function kompetensi_delete($id) {
		$sql = "update par_kompetensi set kompetensi_del_st = '0' where kompetensi_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter kompetensi ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_kompetensi_del($id, $nama, $desc) {
		$sql = "update par_kompetensi set kompetensi_del_st = '1', kompetensi_name = '" . $nama . "', kompetensi_desc = '" . $desc . "' where kompetensi_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter kompetensi ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Tipe Audit

	// Esselon
	function esselon_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_esselon where esselon_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function esselon_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select esselon_id, esselon_name
				FROM par_esselon where esselon_del_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_esselon($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and esselon_id != '" . $id . "' ";
		$sql = "select esselon_id, esselon_del_st FROM par_esselon where LCASE(esselon_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function esselon_data_viewlist($id) {
		$sql = "select esselon_id, esselon_name FROM par_esselon where esselon_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function esselon_add($name) {
		$sql = "insert into par_esselon (esselon_id, esselon_name, esselon_del_st) values ('" . $this->uniq_id () . "','" . $name . "','1')";
		$aksinyo = "Menambah Parameter Unit Esselon 1 " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function esselon_edit($id, $nama) {
		$sql = "update par_esselon set esselon_name = '" . $nama . "' where esselon_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Unit Esselon 1 dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function esselon_delete($id) {
		$sql = "update par_esselon set esselon_del_st = '0' where esselon_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Unit Esselon 1 ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_esselon_del($id) {
		$sql = "update par_esselon set esselon_del_st = '1' where esselon_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Unit Esselon 1 ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Esselon

	// SBM
	function sbu_count($key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM par_sbu where sbu_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function sbu_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select sbu_id, sbu_kode, sbu_name, sbu_sort, case sbu_status when '1' then 'Sesuai Tanggal' when '2' then 'Sesuai Tanggal - 1' when '3' then '1' else '' end as status
				FROM par_sbu
				where sbu_del_st = 1 ".$condition." order by sbu_sort LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_kode_sbu($kode, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and sbu_id != '" . $id . "' ";
		$sql = "select sbu_id, sbu_del_st FROM par_sbu where LCASE(sbu_kode) = '" . strtolower ( $kode ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function sbu_data_viewlist($id) {
		$sql = "select sbu_id, sbu_kode, sbu_name, sbu_sort, sbu_status FROM par_sbu where sbu_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function sbu_add($kode, $nama, $sort, $status) {
		$sql = "insert into par_sbu (sbu_id, sbu_kode, sbu_name, sbu_sort, sbu_status, sbu_del_st) values ('" . $this->uniq_id () . "','" . $kode . "','" . $nama . "','" . $sort . "','" . $status . "','1')";
		$aksinyo = "Menambah Parameter SBM " . $kode;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function sbu_edit($id, $kode, $nama, $sort, $status) {
		$sql = "update par_sbu set sbu_kode = '" . $kode . "', sbu_name = '" . $nama . "', sbu_sort = '" . $sort . "', sbu_status = '" . $status . "' where sbu_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter SBM dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function sbu_delete($id) {
		$sql = "update par_sbu set sbu_del_st = '0' where sbu_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter SBM ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_sbu_del($id, $nama, $sort, $status) {
		$sql = "update par_sbu set sbu_del_st = '1', sbu_name = '" . $nama . "', sbu_sort = '" . $sort . "', sbu_status = '" . $status . "' where sbu_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter SBM ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end SBM

	// SBM Rinci
	function sbu_rinci_count($key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM par_sbu_rinci
				left join par_propinsi on sbu_rinci_prov_id = propinsi_id
				left join par_sbu on sbu_rinci_sbu_id = sbu_id
				where sbu_rinci_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function sbu_rinci_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select sbu_rinci_id, propinsi_name, sbu_name, sbu_rinci_gol, sbu_rinci_amount, sbu_kode
				from par_sbu_rinci
				left join par_propinsi on sbu_rinci_prov_id = propinsi_id
				left join par_sbu on sbu_rinci_sbu_id = sbu_id
				where sbu_rinci_del_st = 1 ".$condition." order by propinsi_name, sbu_sort, sbu_rinci_gol LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_sbu_rinci($prov, $sbu, $gol, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and sbu_rinci_id != '" . $id . "' ";
		$sql = "select sbu_rinci_id, sbu_rinci_del_st
				from par_sbu_rinci
				where sbu_rinci_prov_id = '" . $prov . "' and sbu_rinci_sbu_id = '" . $sbu . "' and sbu_rinci_gol = '" . $gol . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function sbu_rinci_data_viewlist($id) {
		$sql = "select sbu_rinci_id, sbu_rinci_prov_id, sbu_rinci_sbu_id, sbu_rinci_gol, sbu_rinci_amount FROM par_sbu_rinci where sbu_rinci_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function sbu_rinci_add($prov, $sbu, $gol, $amount) {
		$sql = "insert into par_sbu_rinci (sbu_rinci_id, sbu_rinci_prov_id, sbu_rinci_sbu_id, sbu_rinci_gol, sbu_rinci_amount, sbu_rinci_del_st)
				values
				('" . $this->uniq_id () . "','" . $prov . "','" . $sbu . "','" . $gol . "','" . $amount . "','1')";
		$aksinyo = "Menambah Parameter SBM Rinci " . $prov . "-" . $sbu . "-" . $gol;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function sbu_rinci_edit($id, $prov, $sbu, $gol, $amount) {
		$sql = "update par_sbu_rinci set sbu_rinci_prov_id = '" . $prov . "', sbu_rinci_sbu_id = '" . $sbu . "', sbu_rinci_gol = '" . $gol . "', sbu_rinci_amount = '" . $amount . "'
				where sbu_rinci_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter SBM Rinci dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function sbu_rinci_delete($id) {
		$sql = "update par_sbu_rinci set sbu_rinci_del_st = '0' where sbu_rinci_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter SBM Rinci dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_sbu_rinci_del($id, $amount) {
		$sql = "update par_sbu_rinci set sbu_rinci_del_st = '1', sbu_rinci_amount = '" . $amount . "' where sbu_rinci_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter SBM Rinci dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function get_sbu_rinci($id, $golongan) {
		$sql = "select DISTINCT sbu_rinci_id, sbu_kode, sbu_rinci_amount, sbu_status
				from par_sbu_rinci
				left join par_sbu on sbu_rinci_sbu_id = sbu_id
				left join auditee on sbu_rinci_prov_id = auditee_propinsi_id
				where auditee_id = '" . $id . "' and (sbu_rinci_gol = '' or sbu_rinci_gol = '" . $golongan . "') and sbu_rinci_del_st = 1"; // echo $sql;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	// end SBM Rinci

	// Menu
	function menu_count($parrent, $key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM par_menu
				where menu_parrent = '" . $parrent . "' and menu_del_st = '1'";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function menu_grid($parrent, $key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select a.menu_id, a.menu_name, a.menu_link, a.menu_method, a.menu_file, a.menu_sort, case a.menu_show when '1' then 'Show' else 'Hide' end as status,
				(select count(*) from par_menu where menu_parrent = a.menu_id and menu_del_st=1) as jml_sub
				FROM par_menu as a
				where a.menu_parrent = '" . $parrent . "' and a.menu_del_st = '1' order by a.menu_sort LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function menu_data_viewlist($id) {
		$sql = "select menu_id, menu_name, menu_link, menu_method, menu_file, menu_sort, menu_show, menu_del_st
				FROM par_menu where menu_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function menu_add($parrent_id, $name, $link, $method, $file, $sort, $status) {
		$sql = "insert into par_menu
				(menu_parrent, menu_name, menu_link, menu_method, menu_file, menu_sort, menu_show, menu_del_st)
				values
				('" . $parrent_id . "','" . $name . "','" . $link . "','" . $method . "','" . $file . "','" . $sort . "','" . $status . "','1')";
		$aksinyo = "Menambah Menu " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function menu_edit($id, $name, $link, $method, $file, $sort, $status) {
		$sql = "update par_menu set menu_name = '" . $name . "', menu_link = '" . $link . "', menu_method = '" . $method . "', menu_file = '" . $file . "', menu_sort = '" . $sort . "', menu_show = '" . $status . "'
				where menu_id = '" . $id . "' ";
		$aksinyo = "Mengubah Menu dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function menu_delete($id) {
		$sql = "update par_menu set menu_del_st = '0' where menu_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Menu ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Menu

	// Pangkat Auditor
	function pangkat_count($key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM par_pangkat_auditor where pangkat_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function pangkat_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select pangkat_id, pangkat_name, pangkat_desc
				FROM par_pangkat_auditor where pangkat_del_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_pangkat($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and pangkat_id != '" . $id . "' ";
		$sql = "select pangkat_id, pangkat_del_st FROM par_pangkat_auditor where LCASE(pangkat_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function pangkat_data_viewlist($id) {
		$sql = "select pangkat_id, pangkat_name, pangkat_desc FROM par_pangkat_auditor where pangkat_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function pangkat_add($name, $desc) {
		$sql = "insert into par_pangkat_auditor (pangkat_id, pangkat_name, pangkat_desc, pangkat_del_st) values ('" . $this->uniq_id () . "','" . $name . "','" . $desc . "','1')";
		$aksinyo = "Menambah Parameter Pangkat Auditor " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function pangkat_edit($id, $nama, $desc) {
		$sql = "update par_pangkat_auditor set pangkat_name = '" . $nama . "', pangkat_desc = '" . $desc . "' where pangkat_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Pangkat Auditor dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function pangkat_delete($id) {
		$sql = "update par_pangkat_auditor set pangkat_del_st = '0' where pangkat_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Pangkat Auditor ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_pangkat_del($id, $nama, $desc) {
		$sql = "update par_pangkat_auditor set pangkat_del_st = '1', pangkat_name = '" . $nama . "', pangkat_desc = '" . $desc . "' where pangkat_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Pangkat Auditor ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Pangkat Auditor

	// jabatan auditor
	function jabatan_auditor_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}

		$sql = "select count(*) FROM par_jenis_jabatan where jenis_jabatan_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function jabatan_auditor_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}

		$sql = "select jenis_jabatan_id, jenis_jabatan, jenis_jabatan_sub, jenis_jabatan_sort
				FROM par_jenis_jabatan where jenis_jabatan_del_st = 1 ".$condition." order by jenis_jabatan, jenis_jabatan_sort LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_jabatan_auditor($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and jenis_jabatan_id != '" . $id . "' ";
		$sql = "select jenis_jabatan_id, jenis_jabatan_del_st FROM par_jenis_jabatan where LCASE(jenis_jabatan_sub) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function jabatan_auditor_data_viewlist($id) {
		$sql = "select jenis_jabatan_id, jenis_jabatan, jenis_jabatan_sub, jenis_jabatan_sort FROM par_jenis_jabatan where jenis_jabatan_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function jabatan_auditor_add($tipe, $name, $sort) {
		$sql = "insert into par_jenis_jabatan (jenis_jabatan_id, jenis_jabatan, jenis_jabatan_sub, jenis_jabatan_sort, jenis_jabatan_del_st) values ('" . $this->uniq_id () . "','" . $tipe . "','" . $name . "','" . $sort . "','1')";
		$aksinyo = "Menambah Parameter Jabatan Auditor " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function jabatan_auditor_edit($id, $tipe, $nama, $sort) {
		$sql = "update par_jenis_jabatan set jenis_jabatan = '" . $tipe . "', jenis_jabatan_sub = '" . $nama . "', jenis_jabatan_sort = '" . $sort . "' where jenis_jabatan_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Jabatan Auditor dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function jabatan_auditor_delete($id) {
		$sql = "update par_jenis_jabatan set jenis_jabatan_del_st = '0' where jenis_jabatan_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Jabatan Auditor ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_jabatan_auditor_del($id, $tipe, $nama, $sort) {
		$sql = "update par_jenis_jabatan set jenis_jabatan_del_st = '1', jenis_jabatan = '" . $tipe . "', jenis_jabatan_sub = '" . $nama . "', jenis_jabatan_sort = '" . $sort . "' where jenis_jabatan_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Jabatan Auditor ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Jabatan Auditor

	// Kabupaten
	function kabupaten_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_kabupaten
				left join par_propinsi on kabupaten_id_prov = propinsi_id
				where kabupaten_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function kabupaten_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select kabupaten_id, kabupaten_name, propinsi_name, active_st
				FROM par_kabupaten
				left join par_propinsi on kabupaten_id_prov = propinsi_id
				where kabupaten_del_st = 1 ".$condition." order by propinsi_name, kabupaten_name LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_kabupaten($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and kabupaten_id != '" . $id . "' ";
		$sql = "select kabupaten_id, kabupaten_del_st FROM par_kabupaten where LCASE(kabupaten_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function kabupaten_data_viewlist($id) {
		if(isset($id)){
			$sql = "select kabupaten_id, kabupaten_id_prov, kabupaten_name, active_st FROM par_kabupaten where kabupaten_id = '" . $id . "' ";
		}else{
			$sql = "select kabupaten_id, kabupaten_id_prov, kabupaten_name, active_st FROM par_kabupaten ";
		}
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function kabupaten_data_viewlist_service($condition) {
		$sql = "select kabupaten_id, kabupaten_id_prov, kabupaten_name, active_st FROM par_kabupaten where active_st = 1 ".$condition."";

		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function kabupaten_add($propinsi_id, $name) {
		$sql = "insert into par_kabupaten (kabupaten_id, kabupaten_id_prov, kabupaten_name, kabupaten_del_st) values ('" . $this->uniq_id () . "','" . $propinsi_id . "','" . $name . "','1')";
		$aksinyo = "Menambah Parameter Kabupaten " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function kabupaten_edit($id, $propinsi_id, $nama, $active) {
		$sql = "update par_kabupaten set kabupaten_id_prov = '" . $propinsi_id . "', kabupaten_name = '" . $nama . "', active_st = ". $active ." where kabupaten_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Kabupaten dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function kabupaten_delete($id) {
		$sql = "update par_kabupaten set kabupaten_del_st = '0' where kabupaten_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Kabupaten ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_kabupaten_del($id, $propinsi_id, $nama) {
		$sql = "update par_kabupaten set kabupaten_del_st = '1', kabupaten_id_prov = '" . $propinsi_id . "', kabupaten_name = '" . $nama . "' where kabupaten_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Kabupaten ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function propinsi_kabupaten($propinsi_id) {
		$sql = "select kabupaten_id, kabupaten_name FROM par_kabupaten where kabupaten_id_prov = '" . $propinsi_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	// end Kabupaten

	// Sub Kelompok Temuan
	function sub_kel_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_finding_sub_type
				left join par_finding_type on sub_type_id_type = finding_type_id
				where sub_type_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function sub_kel_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select sub_type_id, sub_type_code, sub_type_name, finding_type_name
		FROM par_finding_sub_type
		left join par_finding_type on sub_type_id_type = finding_type_id
		where sub_type_del_st = 1 ".$condition." order by finding_type_code, sub_type_code LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_kode_sub_kel($kode, $id_type, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and sub_type_id != '" . $id . "' ";
		$sql = "select sub_type_id, sub_type_del_st FROM par_finding_sub_type where LCASE(sub_type_code) = '" . strtolower ( $kode ) . "' and sub_type_id_type = '".$id_type."' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function sub_kel_data_viewlist($id) {
		$sql = "select sub_type_id, sub_type_id_type, sub_type_code, sub_type_name FROM par_finding_sub_type where sub_type_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function sub_kel_add($type_id, $code, $name) {
		$sql = "insert into par_finding_sub_type (sub_type_id, sub_type_id_type, sub_type_code, sub_type_name, sub_type_del_st) values ('" . $this->uniq_id () . "','" . $type_id . "','" . $code . "','" . $name . "','1')";
		$aksinyo = "Menambah Parameter Sub Kelompok Temuan " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function sub_kel_edit($id, $type_id, $code, $name) {
		$sql = "update par_finding_sub_type set sub_type_id_type = '" . $type_id . "', sub_type_code = '" . $code . "', sub_type_name = '" . $name . "' where sub_type_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Sub Kelompok Temuan dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function sub_kel_delete($id) {
		$sql = "update par_finding_sub_type set sub_type_del_st = '0' where sub_type_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Sub Kelompok Temuan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_sub_kel_del($id, $type_id, $code, $name) {
		$sql = "update par_finding_sub_type set sub_type_del_st = '1', sub_type_id_type = '" . $type_id . "', sub_type_code = '" . $code . "', sub_type_name = '" . $name . "' where sub_type_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Sub Kelompok Temuan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function kel_sub_kel($type_id="") {
		$condition = "";
		if($type_id!="") $condition = " and sub_type_id_type = '" . $type_id . "'";
		$sql = "select sub_type_id, sub_type_name FROM par_finding_sub_type where sub_type_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	// end Sub Kelompok Temuan

	// Jenis Temuan
	function jenis_temuan_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_finding_jenis
				left join par_finding_sub_type on jenis_temuan_id_sub_type = sub_type_id
				left join par_finding_type on sub_type_id_type = finding_type_id
				where jenis_temuan_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function jenis_temuan_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select jenis_temuan_id, jenis_temuan_code, jenis_temuan_name, sub_type_name, finding_type_name
				FROM par_finding_jenis
				left join par_finding_sub_type on jenis_temuan_id_sub_type = sub_type_id
				left join par_finding_type on sub_type_id_type = finding_type_id
				where jenis_temuan_del_st = 1 ".$condition." order by sub_type_code, jenis_temuan_code LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_kode_jenis_temuan($kode, $fid_type, $fsub_id, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and jenis_temuan_id != '" . $id . "' ";
		$sql = "select jenis_temuan_id, jenis_temuan_del_st FROM par_finding_jenis
				left join par_finding_sub_type on jenis_temuan_id_sub_type = sub_type_id
				where LCASE(jenis_temuan_code) = '" . strtolower ( $kode ) . "' and jenis_temuan_id_sub_type = '".$fsub_id."'  and sub_type_id_type = '".$fid_type."'  " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function jenis_temuan_data_viewlist($id) {
		$sql = "select jenis_temuan_id, jenis_temuan_id_sub_type, jenis_temuan_code, jenis_temuan_name FROM par_finding_jenis where jenis_temuan_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function jenis_temuan_add($sub_id, $code, $name) {
		$sql = "insert into par_finding_jenis (jenis_temuan_id, jenis_temuan_id_sub_type, jenis_temuan_code, jenis_temuan_name, jenis_temuan_del_st) values ('" . $this->uniq_id () . "','" . $sub_id . "','" . $code . "','" . $name . "','1')";
		$aksinyo = "Menambah Parameter Jenis Temuan " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function jenis_temuan_edit($id, $sub_id, $code, $name) {
		$sql = "update par_finding_jenis set jenis_temuan_id_sub_type = '" . $sub_id . "', jenis_temuan_code = '" . $code . "', jenis_temuan_name = '" . $name . "' where jenis_temuan_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Jenis Temuan dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function jenis_temuan_delete($id) {
		$sql = "update par_finding_jenis set jenis_temuan_del_st = '0' where jenis_temuan_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Jenis Temuan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_jenis_temuan_del($id, $sub_id, $code, $name) {
		$sql = "update par_finding_jenis set jenis_temuan_del_st = '1', jenis_temuan_id_sub_type = '" . $sub_id . "', jenis_temuan_code = '" . $code . "', jenis_temuan_name = '" . $name . "' where jenis_temuan_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Jenis Temuan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function jenis_temuan_kel($type_id) {
		$sql = "select jenis_temuan_id, jenis_temuan_name, concat(jenis_temuan_code,' - ',jenis_temuan_name) as lengkap FROM par_finding_jenis where jenis_temuan_id_sub_type = '" . $type_id . "' and jenis_temuan_del_st ='1' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	// end Jenis Temuan

	// Kode Rekomendasi
	function kode_rek_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_kode_rekomendasi where kode_rek_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function kode_rek_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select kode_rek_id, kode_rek_code, kode_rek_desc
				FROM par_kode_rekomendasi where kode_rek_del_st = 1 ".$condition." order by kode_rek_code LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_kode_rek($code, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and kode_rek_id != '" . $id . "' ";
		$sql = "select kode_rek_id, kode_rek_del_st FROM par_kode_rekomendasi where LCASE(kode_rek_code) = '" . strtolower ( $code ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function kode_rek_data_viewlist($id) {
		$sql = "select kode_rek_id, kode_rek_code, kode_rek_desc FROM par_kode_rekomendasi where kode_rek_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function kode_rek_add($code, $desc) {
		$sql = "insert into par_kode_rekomendasi (kode_rek_id, kode_rek_code, kode_rek_desc, kode_rek_del_st) values ('" . $this->uniq_id () . "','" . $code . "','" . $desc . "','1')";
		$aksinyo = "Menambah Parameter Kode Rekomendasi " . $code;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function kode_rek_edit($id, $code, $desc) {
		$sql = "update par_kode_rekomendasi set kode_rek_code = '" . $code . "', kode_rek_desc = '" . $desc . "' where kode_rek_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Kode Rekomendasi dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function kode_rek_delete($id) {
		$sql = "update par_kode_rekomendasi set kode_rek_del_st = '0' where kode_rek_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Kode Rekomendasi ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_kode_rek_del($id, $code, $desc) {
		$sql = "update par_kode_rekomendasi set kode_rek_del_st = '1', kode_rek_code = '" . $code . "', kode_rek_desc = '" . $desc . "' where kode_rek_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Kode Rekomendasi ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Kode Rekomendasi


	// Bidang Subtansi
	function bidang_sub_count($key_search, $val_search, $all_field) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select count(*) FROM par_bidang_subtansi where bidang_subtansi_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function bidang_sub_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($key_search!="") $condition = " and ".$key_search." like '%".$val_search."%' ";
		else {
			for($i=0;$i<count($all_field);$i++){
				$or = " or ";
				if($i==0) $or = "";
				$condition .= $or.$all_field[$i]." like '%".$val_search."%' ";
			}
			$condition = " and (".$condition.")";
		}
		$sql = "select bidang_subtansi_id, bidang_subtansi_name
				FROM par_bidang_subtansi where bidang_subtansi_del_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_bidang_sub($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and bidang_subtansi_id != '" . $id . "' ";
		$sql = "select bidang_subtansi_id, bidang_subtansi_del_st FROM par_bidang_subtansi where LCASE(bidang_subtansi_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function bidang_sub_data_viewlist($id) {
		$sql = "select bidang_subtansi_id, bidang_subtansi_name FROM par_bidang_subtansi where bidang_subtansi_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function bidang_sub_add($name) {
		$sql = "insert into par_bidang_subtansi (bidang_subtansi_id, bidang_subtansi_name, bidang_subtansi_del_st) values ('" . $this->uniq_id () . "','" . $name . "','1')";
		$aksinyo = "Menambah Parameter Bidang Subtansi " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function bidang_sub_edit($id, $nama) {
		$sql = "update par_bidang_subtansi set bidang_subtansi_name = '" . $nama . "' where bidang_subtansi_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Bidang Subtansi dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function bidang_sub_delete($id) {
		$sql = "update par_bidang_subtansi set bidang_subtansi_del_st = '0' where bidang_subtansi_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Bidang Subtansi ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_bidang_sub_del($id, $nama) {
		$sql = "update par_bidang_subtansi set bidang_subtansi_del_st = '1', bidang_subtansi_name = '" . $nama . "' where bidang_subtansi_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Bidang Subtansi ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Bidang Subtansi

	// Status TL
	function status_tl_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM par_status_tl where status_tl_del_st = 1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function status_tl_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select status_tl_id, status_tl_name
				FROM par_status_tl where status_tl_del_st = 1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_status_tl($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and status_tl_id != '" . $id . "' ";
		$sql = "select status_tl_id, status_tl_del_st FROM par_status_tl where LCASE(status_tl_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function status_tl_data_viewlist($id) {
		$sql = "select status_tl_id, status_tl_name FROM par_status_tl where status_tl_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function status_tl_add($name) {
		$sql = "insert into par_status_tl (status_tl_id, status_tl_name, status_tl_del_st) values ('" . $this->uniq_id () . "','" . $name . "','1')";
		$aksinyo = "Menambah Parameter Status TL " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function status_tl_edit($id, $nama) {
		$sql = "update par_status_tl set status_tl_name = '" . $nama . "' where status_tl_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Status TL dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function status_tl_delete($id) {
		$sql = "update par_status_tl set status_tl_del_st = '0' where status_tl_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Status TL ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_status_tl_del($id, $nama) {
		$sql = "update par_status_tl set status_tl_del_st = '1', status_tl_name = '" . $nama . "' where status_tl_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Status TL ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Status TL

	// Ref Kategori
	function ref_kat_count() {
		$sql = "select count(*) FROM par_kategori_ref where kategori_ref_del_st = 1 ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function ref_kat_viewlist($offset, $num_row) {
		$sql = "select kategori_ref_id, kategori_ref_name
				FROM par_kategori_ref where kategori_ref_del_st = 1 LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_nama_ref_kat($nama, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and kategori_ref_id != '" . $id . "' ";
		$sql = "select kategori_ref_id, kategori_ref_del_st FROM par_kategori_ref where LCASE(kategori_ref_name) = '" . strtolower ( $nama ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function ref_kat_data_viewlist($id) {
		$sql = "select kategori_ref_id, kategori_ref_name FROM par_kategori_ref where kategori_ref_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function ref_kat_add($name) {
		$sql = "insert into par_kategori_ref (kategori_ref_id, kategori_ref_name, kategori_ref_del_st) values ('" . $this->uniq_id () . "','" . $name . "', '1')";
		$aksinyo = "Menambah Parameter Ref Kategori " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function ref_kat_edit($id, $nama) {
		$sql = "update par_kategori_ref set kategori_ref_name = '" . $nama . "' where kategori_ref_id = '" . $id . "' ";
		$aksinyo = "Mengubah Parameter Ref Kategori dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function ref_kat_delete($id) {
		$sql = "update par_kategori_ref set kategori_ref_del_st = '0' where kategori_ref_id = '" . $id . "' ";
		$aksinyo = "Menghapus Parameter Ref Kategori ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_ref_kat_del($id) {
		$sql = "update par_kategori_ref set kategori_ref_del_st = '1' where kategori_ref_id = '" . $id . "' ";
		$aksinyo = "Menampilkan Kembali Parameter Ref Kategori ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	// end Ref Kategori
}
?>
