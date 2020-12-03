<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class auditee {
	var $_db;
	var $userId;
	function auditee($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function auditee_count($base_on_id_eks="", $key_search, $val_search, $all_field) {
		$condition = "";
		if($base_on_id_eks!="") $condition = " and auditee_id = '".$base_on_id_eks."' ";
		
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
		
		$sql = "select count(*) FROM auditee
				left join par_inspektorat on auditee_inspektorat_id = inspektorat_id
				left join par_esselon on auditee_esselon_id = esselon_id
				where auditee_del_st != 0 ".$condition.$condition2;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function auditee_viewlist($base_on_id_eks="", $key_search, $val_search, $all_field, $offset, $num_row) {
		$condition = "";
		if($base_on_id_eks!="") $condition = " and auditee_id = '".$base_on_id_eks."' ";
		
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
		$sql = "select auditee_id, auditee_kode, auditee_name, esselon_name, inspektorat_name
				from auditee
				left join par_inspektorat on auditee_inspektorat_id = inspektorat_id
				left join par_esselon on auditee_esselon_id = esselon_id
				where auditee_del_st != 0 ".$condition.$condition2." order by auditee_name LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function auidtee_cek_name($kode, $id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and auditee_id != '" . $id . "' ";
		$sql = "select auditee_id, auditee_del_st FROM auditee where LCASE(auditee_kode) = '" . strtolower ( $kode ) . "' " . $condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function auditee_data_viewlist($id = "") {
		$condition = "";
		if ($id != "")
			$condition = "and auditee_id = '" . $id . "' ";
		$sql = "select auditee_id, auditee_kode, auditee_name, auditee_esselon_id, auditee_inspektorat_id, auditee_propinsi_id, auditee_alamat, auditee_telp, auditee_fax, esselon_name, inspektorat_name, propinsi_name, kabupaten_name, auditee_kabupaten_id
				FROM auditee
				left join par_esselon on auditee_esselon_id = esselon_id
				left join par_inspektorat on auditee_inspektorat_id = inspektorat_id
				left join par_propinsi on auditee_propinsi_id = propinsi_id
				left join par_kabupaten on auditee_kabupaten_id = kabupaten_id
				where auditee_del_st = 1 " . $condition." order by auditee_name "; //echo $sql;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function auditee_add($kode, $name, $parrent_id, $inspektorat_id, $propinsi_id, $kabupaten_id, $alamat, $telp, $fax) {
		$sql = "insert into auditee (auditee_id, auditee_kode, auditee_name, auditee_esselon_id, auditee_inspektorat_id, auditee_propinsi_id, auditee_kabupaten_id, auditee_alamat, auditee_telp, auditee_fax, auditee_del_st) values ('" . $this->uniq_id () . "','" . $kode . "','" . $name . "','" . $parrent_id . "','" . $inspektorat_id . "','" . $propinsi_id . "','" . $kabupaten_id . "','" . $alamat . "','" . $telp . "','" . $fax . "','1')";
		$aksinyo = "Menambah Auditee " . $kode . " - " . $name;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function auditee_edit($id, $kode, $name, $parrent_id, $inspektorat_id, $propinsi_id, $kabupaten_id, $alamat, $telp, $fax) {
		$sql = "update auditee set auditee_kode = '" . $kode . "', auditee_name = '" . $name . "', auditee_esselon_id = '" . $parrent_id . "', auditee_inspektorat_id = '" . $inspektorat_id . "', auditee_propinsi_id = '" . $propinsi_id . "', auditee_kabupaten_id = '" . $kabupaten_id . "', auditee_alamat = '" . $alamat . "', auditee_telp = '" . $telp . "', auditee_fax = '" . $fax . "' where auditee_id = '" . $id . "' ";
		$aksinyo = "Mengubah Data Auditee dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function auditee_delete($id) {
		$sql = "update auditee set auditee_del_st = '0' where auditee_id = '" . $id . "' ";
		$aksinyo = "Menghapus Auditee ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function auditee_update_del_to_add($id, $kode, $name, $parrent_id, $inspektorat_id, $propinsi_id, $kabupaten_id, $alamat, $telp, $fax) {
		$sql = "update auditee set auditee_kode = '" . $kode . "', auditee_name = '" . $name . "', auditee_esselon_id = '" . $parrent_id . "', auditee_inspektorat_id = '" . $inspektorat_id . "', auditee_propinsi_id = '" . $propinsi_id . "', auditee_kabupaten_id = '" . $kabupaten_id . "', auditee_alamat = '" . $alamat . "', auditee_telp = '" . $telp . "', auditee_fax = '" . $fax . "', auditee_del_st = '1' where auditee_id = '" . $id . "' ";
		$aksinyo = "Menampilakan Kembali Auditee dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
