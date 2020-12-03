<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class masterkepalakeluarga {
	var $_db;
	var $userId;
	function masterkepalakeluarga($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_kepalakeluarga_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM master_kepalakeluarga
				where kepalakeluarga_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_kepalakeluarga_view_data($kepalakeluarga_id) {
		$sql = "select kepalakeluarga_id, nomor_rumah, kepalakeluarga_nama, kepalakeluarga_pekerjaan, kepalakeluarga_tempatkerja,
				kepalakeluarga_jabatan, kepalakeluarga_nomorhandphone, nomor_ktp, kepalakeluarga_tempatlahir, kepalakeluarga_tanggallahir,
				kepalakeluarga_nomorhandphone2, kepalakeluarga_foto, status_permanen
				from master_kepalakeluarga
				where kepalakeluarga_id = '" . $kepalakeluarga_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_kepalakeluarga_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select kepalakeluarga_id, nomor_rumah, kepalakeluarga_nama, kepalakeluarga_pekerjaan, kepalakeluarga_tempatkerja,
				kepalakeluarga_jabatan, kepalakeluarga_nomorhandphone, nomor_ktp, kepalakeluarga_tempatlahir, kepalakeluarga_tanggallahir,
				kepalakeluarga_nomorhandphone2, kepalakeluarga_foto,
				created_on, created_by,updated_on,updated_by, status_permanen
		where kepalakeluarga_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_kepalakeluarga_viewlist($key_search, $val_search, $all_field, $offset, $num_row, $additionalcondition) {
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

		$sql = "select a.kepalakeluarga_id, b.rumah_nomor, a.kepalakeluarga_nama, a.status_permanen
		FROM master_kepalakeluarga a left join master_rumah b
		on a.nomor_rumah = b.rumah_id
		where 1=1 ".$condition." ORDER BY nomor_rumah ASC LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_kepalakeluarga_add($id, $nomor_rumah, $kepalakeluarga_nama, $kepalakeluarga_pekerjaan, $kepalakeluarga_tempatkerja,
		$kepalakeluarga_jabatan, $kepalakeluarga_nomorhandphone, $user, $nomor_ktp, $kepalakeluarga_tempatlahir,
		$kepalakeluarga_tanggallahir, $kepalakeluarga_nomorhandphone2, $kepalakeluarga_foto, $status_permanen,
		$kepalakeluarga_ktp1, $kepalakeluarga_ktp2, $kepalakeluarga_kk) {
		$sql = "insert into master_kepalakeluarga
				(kepalakeluarga_id, nomor_rumah, kepalakeluarga_nama, kepalakeluarga_pekerjaan, kepalakeluarga_tempatkerja,
				 kepalakeluarga_jabatan, kepalakeluarga_nomorhandphone, nomor_ktp, kepalakeluarga_tempatlahir, kepalakeluarga_tanggallahir,
				 kepalakeluarga_nomorhandphone2, kepalakeluarga_foto,
				 created_by, updated_by, status_permanen, kepalakeluarga_ktp1, kepalakeluarga_ktp2, kepalakeluarga_kk)
				values
				('" . $id . "', '" . $nomor_rumah . "','".$kepalakeluarga_nama."','".$kepalakeluarga_pekerjaan.
					"','".$kepalakeluarga_tempatkerja."','".$kepalakeluarga_jabatan."','".$kepalakeluarga_nomorhandphone."',
					'".$nomor_ktp."', '".$kepalakeluarga_tempatlahir."', '".$kepalakeluarga_tanggallahir."',
					'".$kepalakeluarga_nomorhandphone2."', '".$kepalakeluarga_foto."',
					'".$user."','".$user."', '".$status_permanen."', '".$kepalakeluarga_ktp1."', '".$kepalakeluarga_ktp2."', '".$kepalakeluarga_kk."')";
		$aksinyo = "Menambah kepalakeluarga ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function master_kepalakeluarga_edit($id, $nomor_rumah, $kepalakeluarga_nama, $kepalakeluarga_pekerjaan, $kepalakeluarga_tempatkerja,
		$kepalakeluarga_jabatan, $kepalakeluarga_nomorhandphone, $user, $nomor_ktp, $kepalakeluarga_tempatlahir,
		$kepalakeluarga_tanggallahir, $kepalakeluarga_nomorhandphone2, $kepalakeluarga_foto, $status_permanen,
		$kepalakeluarga_ktp1, $kepalakeluarga_ktp2, $kepalakeluarga_kk) {

		$sql = "update master_kepalakeluarga set nomor_rumah = '" . $nomor_rumah . "',kepalakeluarga_nama = '".$kepalakeluarga_nama."',
				kepalakeluarga_pekerjaan = '".$kepalakeluarga_pekerjaan."',  kepalakeluarga_tempatkerja = '" . $kepalakeluarga_tempatkerja . "',
				kepalakeluarga_jabatan = '".$kepalakeluarga_jabatan."' , kepalakeluarga_nomorhandphone = '".$kepalakeluarga_nomorhandphone."',
				updated_by = '".$user."', nomor_ktp = '".$nomor_ktp."', kepalakeluarga_tempatlahir = '".$kepalakeluarga_tempatlahir."',
				kepalakeluarga_tanggallahir = '".$kepalakeluarga_tanggallahir."', kepalakeluarga_nomorhandphone2 = '".$kepalakeluarga_nomorhandphone2."',
				status_permanen = '". $status_permanen ."'";

		if(isset($kepalakeluarga_foto)){
			$sql = $sql." , kepalakeluarga_foto = '".$kepalakeluarga_foto."'";
		}

		if(isset($fkepalakeluargaktp1)){
			$sql = $sql." , kepalakeluarga_ktp1 = '".$kepalakeluarga_ktp1."'";
		}

		if(isset($fkepalakeluargaktp2)){
			$sql = $sql." , kepalakeluarga_ktp2 = '".$kepalakeluarga_ktp2."'";
		}

		if(isset($fkepalakeluargakk)){
			$sql = $sql." , kepalakeluarga_kk = '".$kepalakeluarga_kk."'";
		}

		$sql = $sql." where kepalakeluarga_id = '" . $id . "' ";

		$aksinyo = "Mengubah kepalakeluarga dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_kepalakeluarga_delete($id) {
		$sql = "delete from master_kepalakeluarga where kepalakeluarga_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus kepalakeluarga dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

}
?>
