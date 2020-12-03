<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class  mastermedia{
	var $_db;
	var $userId;
	function mastermedia($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_media_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM master_media
				where media_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_media_view_data($media_id) {
		$sql = "select media_id, media_name, media_company, media_address, media_email,
				media_telp, media_whatsapp, media_type, media_picname, 
				media_picnik, media_picaddress, media_picktp, media_picphoto, media_piccorporatedoc from master_media
				where media_id = '" . $media_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_media_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select media_id, media_name, media_company, media_address, media_email,
		media_telp, media_whatsapp, media_type, media_picname, 
		media_picnik, media_picaddress, media_picktp, media_picphoto, media_piccorporatedoc,
		created_on, created_by, updated_on,updated_by 
		where media_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_media_viewlist($key_search, $val_search, $all_field, $offset, $num_row, $additionalcondition) {
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

		$sql = "select media_id, media_name, media_company, media_address, media_email,
				media_telp, media_whatsapp, media_type,  media_picname, 
				media_picnik, media_picaddress, media_picktp, media_picphoto, media_piccorporatedoc,
				created_on, created_by, updated_on, updated_by
				FROM master_media  where 1=1 ".$condition." ORDER BY media_name ASC LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_media_add($media_id, $media_name, $media_company,  $media_address, $media_email,
		$media_telp, $media_whatsapp, $media_type, $media_picname, $media_picnik, $media_picaddress, $media_picktp,
		$media_picphoto, $media_piccorporatedoc, $user) {
		
		$sql = "insert into master_media
				(media_id, media_name, media_company, media_address, media_email,
				media_telp, media_whatsapp, media_type, media_picname, media_picnik, media_picaddress, media_picktp,
				media_picphoto, media_piccorporatedoc, created_by, updated_by)
				values
				('" . $media_id . "', '" . $media_name . "','".$media_company."','".$media_address.
					"','".$media_email."','".$media_telp."','".$media_whatsapp."',
					'".$media_type."','".$media_picname."','".$media_picnik."','".$media_picaddress."',
					'".$media_picktp."','".$media_picphoto."','".$media_piccorporatedoc."',
					'".$user."','".$user."')";
		$aksinyo = "Menambah media ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function master_media_edit($id, $media_name, $media_company,  $media_address, $media_email,
		$media_telp, $media_whatsapp, $media_type, $media_picname, $media_picnik, $media_picaddress, $media_picktp,
		$media_picphoto, $media_piccorporatedoc, $user) {
		$sql = "update master_media set media_name = '" . $media_name . "', media_company = '" . $media_company . "',media_address = '".$media_address."',
				media_email = '" . $media_email . "',media_telp = '" . $media_telp . "',
				media_whatsapp = '" . $media_whatsapp . "',  
				media_type = '" . $media_type . "',  
				media_picname = '" . $media_picname . "',  
				media_picnik = '" . $media_picnik . "',  
				media_picaddress = '" . $media_picaddress . "',  
				media_picktp = '" . $media_picktp . "',  
				media_picphoto = '" . $media_picphoto . "',  
				media_piccorporatedoc = '" . $media_piccorporatedoc . "',  
				updated_by = '".$user."'";

		$sql = $sql." where media_id = '" . $id . "' ";

		$aksinyo = "Mengubah media dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_media_delete($id) {
		$sql = "delete from master_media where media_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus media dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function master_media_count_service($media_type) {
		$sql = "select count(*) FROM master_media where media_id is not null and media_type =".$media_type;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}

}
?>
