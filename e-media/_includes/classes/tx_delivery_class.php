<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class txdelivery {
	var $_db;
	var $userId;

	function txdelivery($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}

	function uniq_id() {
		return $this->_db->uniqid ();
	}

	function tx_delivery_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM tx_delivery where delivery_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}

	function tx_delivery_view_data($delivery_id) {
		$sql = "select delivery_id,delivery_number,order_id,shipper_id,total_capacity,
				total_uom,consignee_id,delivery_servicemode, delivery_servicepackage, delivery_packaging, delivery_remarks,
				delivery_pricegoods,created_on, created_by,updated_on,updated_by from tx_delivery
				where delivery_id = '" . $delivery_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_delivery_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select delivery_id,delivery_number,order_id,shipper_id,total_capacity,
				total_uom,consignee_id,delivery_servicemode, delivery_servicepackage, delivery_packaging, delivery_remarks,
				delivery_pricegoods,created_on, created_by,updated_on,updated_by from tx_delivery
				where delivery_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_delivery_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select tx_delivery.delivery_id, tx_delivery.delivery_number, shipper.customer_name, consignee.customer_name,
						concat(tx_delivery.total_capacity , ' ', tx_delivery.total_uom) as total_capacity,
						tx_delivery.delivery_servicemode, tx_delivery.delivery_servicepackage
						from tx_delivery left join master_customer as shipper on tx_delivery.shipper_id = shipper.customer_id
						left join master_customer as consignee on tx_delivery.shipper_id = consignee.customer_id
						where 1=1 ".$condition." LIMIT $offset, $num_row";

		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_order_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM tx_order where order_id is not null ".$condition." and order_status='PICKUP PROGRESS' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}


	function tx_order_view_data($order_id) {
		$sql = "select order_id,order_number,shipper_id,total_capacity,
				total_uom,consignee_id,order_service, order_vehicletype, order_vehiclebacktype, order_remarks,order_time,
				order_status,created_on, created_by,updated_on,updated_by from tx_order
				where order_id = '" . $order_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function tx_order_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select order_id,order_number,shipper_id,total_capacity,
				total_uom,consignee_id,order_service, order_vehicletype, order_vehiclebacktype, order_remarks,order_time,
				order_status,created_on, created_by,updated_on,updated_by from tx_order where order_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_order_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select tx_order.order_id, tx_order.order_number, shipper.customer_name, consignee.customer_name,
		tx_order.order_time, tx_order.order_status
		from tx_order left join master_customer as shipper
		on tx_order.shipper_id = shipper.customer_id
		left join master_customer as consignee
		on tx_order.shipper_id = consignee.customer_id
		where 1=1 ".$condition." and tx_order.order_status = 'PICKUP PROGRESS' LIMIT $offset, $num_row";

		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}


	function tx_delivery_add($delivery_number, $order_id, $shipper_id,  $total_capacity, $total_uom, $consignee_id,
		$delivery_servicemode, $delivery_servicepackage, $delivery_packaging, $delivery_remarks, $delivery_pricegoods, $user, $finishprocess) {

		$id = $this->uniq_id ();
		$sql = "insert into tx_delivery
				(delivery_id,delivery_number,order_id,shipper_id,total_uom,total_capacity,
				consignee_id,delivery_servicemode, delivery_servicepackage,delivery_packaging, delivery_remarks,delivery_pricegoods,created_by,updated_by)
				values
				('" . $id . "', '" . $delivery_number . "','" . $order_id . "', '" . $shipper_id . "', '" . $total_uom . "', '" . $total_capacity .
				 "', '" . $consignee_id . "', '" . $delivery_servicemode . "',
				'" . $delivery_servicepackage . "', '" . $delivery_packaging . "','".$delivery_remarks."',
				'" . $delivery_pricegoods . "', '" . $user .
				"', '" . $user . "' )";

		$aksinyo = "Menambah order ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );

		if($finishprocess === "1"){
			$sql = "";
			$sql = "update tx_order set order_status = 'READY TO DELIVER', updated_on = CURRENT_TIMESTAMP, updated_by = '". $user ."'
			    where order_id ='" . $order_id . "'";

			$aksinyo = "Set status order ID " . $order_id;
			$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
		}
		return $id;
	}

	function tx_delivery_edit($delivery_id, $shipper_id,  $total_capacity, $total_uom, $consignee_id,
		$delivery_servicemode, $delivery_servicepackage, $delivery_packaging, $delivery_remarks, $delivery_pricegoods, $user) {

		$sql = "update tx_delivery set shipper_id = '" . $shipper_id . "',total_capacity = '".$total_capacity."'
				,total_uom = '".$total_uom."',consignee_id = '".$consignee_id."'
				,delivery_servicemode = '" . $delivery_servicemode . "', delivery_servicepackage = '". $delivery_servicepackage ."'
				,delivery_packaging = '". $delivery_packaging ."', delivery_remarks = '".$delivery_remarks."'
				,delivery_pricegoods = '". $delivery_pricegoods ."'
				 where delivery_id = '" . $delivery_id . "' ";

		$aksinyo = "Mengubah order dengan ID " . $delivery_id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function tx_delivery_delete($id) {
		$sql = "delete from tx_delivery where delivery_id = '" . $id . "' ";
		$aksinyo = "Menghapus order dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function get_last_delivery_number() {
		$sql = "select delivery_number from tx_delivery order by created_on desc limit 0,1 ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
}
?>
