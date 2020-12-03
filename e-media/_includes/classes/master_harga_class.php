<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class masterharga {
	var $_db;
	var $userId;
	function masterharga($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_harga_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM master_harga
				where harga_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_harga_view_data($harga_id) {
		$sql = "select harga_id, customer_id, service_mode, service_package from master_harga
				where harga_id = '" . $harga_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_harga_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select harga_id, customer_id, service_mode, service_type, created_on, created_by,updated_on,updated_by
		where harga_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_harga_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select harga_id, customer_id, service_mode, service_uom, service_package, divider, created_on, created_by,updated_on,updated_by  FROM master_harga where 1=1 ".$condition." LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_harga_checkexist($customer_id, $service_mode, $service_uom, $service_package) {
		$condition = "";
		if(isset($customer_id) && isset($service_mode) && isset($service_uom) && isset($service_package)){
			$condition = " and customer_id = '".$customer_id."' and service_mode = '".$service_mode."'
										 and service_uom = '".$service_uom."' and service_package ='".$service_package."' ";
		}
		$sql = "select count(*) FROM master_harga
				where harga_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}

	function master_harga_gethargaid($customer_id, $service_mode, $service_uom, $service_package) {
		$condition = "";
		if(isset($customer_id) && isset($service_mode) && isset($service_uom) && isset($service_package)){
			$condition = " and customer_id = '".$customer_id."' and service_mode = '".$service_mode."'
										 and service_uom = '".$service_uom."' and service_package ='".$service_package."' ";
		}
		$sql = "select harga_id FROM master_harga
				where harga_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}

	function master_harga_add($customer_id, $service_mode, $service_uom, $service_package, $divider, $user) {
		$id = $this->uniq_id ();
		$sql = "insert into master_harga
				(harga_id, customer_id, service_mode, service_uom, service_package, divider, created_by, updated_by)
				values
				('" . $id . "', '" . $customer_id . "','".$service_mode."','".$service_uom.
					"', '".$service_package."', '".$divider."','".$user."','".$user."')";
		$aksinyo = "Menambah harga ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
		return $id;
	}

	function master_harga_edit($customer_id, $service_mode, $service_uom, $service_package, $divider, $user) {
		$id = $this->master_harga_gethargaid($customer_id, $service_mode, $service_uom, $service_package);
		$sql = "update master_harga set divider = '" . $divider . "', updated_by = '".$user."'";
		$sql = $sql." where harga_id = '" . $id . "' ";

		$aksinyo = "Mengubah harga dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
		return $id;
	}

	function master_hargadetail_count($condition) {

		$sql = "select count(*) FROM master_hargadetail
				where detailharga_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}

	function master_hargadetail_viewlist($condition) {

		$sql = "select b.kabupaten_name,c.kabupaten_name,a.price,a.lead_time
		 FROM master_hargadetail as a
		 LEFT JOIN par_kabupaten as b ON a.origin = b.kabupaten_id
		 LEFT JOIN par_kabupaten as c ON a.destination = c.kabupaten_id
		 where 1=1 ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_hargadetail_add($harga_id, $origin, $destination, $price, $lead_time, $user) {
		$id = $this->uniq_id ();
		$sql = "insert into master_hargadetail
				(detailharga_id, harga_id, origin, destination, price, lead_time, created_by, updated_by)
				values
				('" . $id . "', '" . $harga_id . "','".$origin."','".$destination.
					"', '".$price."', '".$lead_time."','".$user."','".$user."')";
		$aksinyo = "Menambah harga ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
}
?>
