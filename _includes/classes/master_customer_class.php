<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class mastercustomer {
	var $_db;
	var $userId;
	function mastercustomer($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_customer_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM master_customer
				where customer_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_customer_view_data($customer_id) {
		$sql = "select customer_id, customer_number, customer_name, customer_address, customer_remarks, status_active,  kabupaten_id,
				customer_pic, customer_picphonenumber
				from master_customer
				where customer_id = '" . $customer_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_customer_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select customer_id, customer_number, customer_name, customer_address, customer_remarks, kabupaten_id, status_active, created_on, created_by,updated_on,updated_by,customer_pic, customer_picphonenumber
		where customer_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_customer_viewlist($key_search, $val_search, $all_field, $offset, $num_row, $additionalcondition) {
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

		$sql = "select a.customer_id, a.customer_number, a.customer_name, a.customer_address, a.customer_remarks, a.status_active, a.created_on, a.created_by,a.updated_on,a.updated_by,b.kabupaten_name,a.customer_pic, a.customer_picphonenumber
						FROM master_customer a left join par_kabupaten b on a.kabupaten_id = b.kabupaten_id where 1=1 ".$condition." ORDER BY a.customer_number ASC LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_customer_viewlist_service($condition) {

		$sql = "select a.customer_id, a.customer_number, a.customer_name, a.customer_address, a.customer_remarks, a.status_active, a.created_on, a.created_by,a.updated_on,a.updated_by,b.kabupaten_name,a.customer_pic, a.customer_picphonenumber
						FROM master_customer a left join par_kabupaten b on a.kabupaten_id = b.kabupaten_id where 1=1 ".$condition." ORDER BY a.customer_number ASC";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_customer_add($customer_number, $customer_name, $customer_address, $customer_remarks,
		$user, $kabupaten_id, $customer_pic, $customer_picphonenumber) {
		$id = $this->uniq_id ();
		$status_active = 1;
		$sql = "insert into master_customer
				(customer_id, customer_number, customer_name, customer_address, customer_remarks, status_active, created_by, updated_by,kabupaten_id,customer_pic, customer_picphonenumber)
				values
				('" . $id . "', '" . $customer_number . "','".$customer_name."','".$customer_address.
					"','".$customer_remarks."','".$status_active."','".$user."','".$user."', '".$kabupaten_id."', '".$customer_pic."','".$customer_picphonenumber."')";
		$aksinyo = "Menambah customer ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_customer_edit($id, $customer_name, $customer_address, $customer_remarks, $status_active, $user, $kabupaten_id, $customer_pic, $customer_picphonenumber) {
		$sql = "update master_customer set customer_name = '" . $customer_name . "',customer_address = '".$customer_address."',
				customer_remarks = '".$customer_remarks."',  status_active = '" . $status_active . "', updated_by = '".$user."',
				kabupaten_id = '".$kabupaten_id."' , customer_pic = '".$customer_pic."', customer_picphonenumber = '".$customer_picphonenumber."'";

		$sql = $sql." where customer_id = '" . $id . "' ";

		$aksinyo = "Mengubah customer dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_customer_delete($id) {
		$sql = "delete from master_customer where customer_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus customer dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function get_last_customer_number() {
		$sql = "select customer_number from master_customer order by created_on desc limit 0,1 ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
}
?>
