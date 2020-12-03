<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class txorder {
	var $_db;
	var $userId;

	function txorder($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}

	function uniq_id() {
		return $this->_db->uniqid ();
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

		$sql = "select count(*) FROM tx_order where order_id is not null ".$condition;
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
		where 1=1 ".$condition." LIMIT $offset, $num_row";

		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_order_add($order_number, $shipper_id,  $total_capacity, $total_uom, $consignee_id,
		$order_service, $order_vehicletype, $order_vehiclebacktype, $order_remarks, $order_time, $order_status, $user) {

		$id = $this->uniq_id ();
		$sql = "insert into tx_order
				(order_id,order_number,shipper_id,total_uom,total_capacity,
				consignee_id,order_service, order_vehicletype,order_vehiclebacktype, order_remarks,order_time,created_by,updated_by)
				values
				('" . $id . "', '" . $order_number . "', '" . $shipper_id . "', '" . $total_uom . "', '" . $total_capacity .
				 "', '" . $consignee_id . "', '" . $order_service . "',
				'" . $order_vehicletype . "', '" . $order_vehiclebacktype . "','".$order_remarks."',
				'" . $order_time . "', '" . $user .
				"', '" . $user . "' )";

		$aksinyo = "Menambah order ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function tx_order_edit($order_id, $shipper_id,  $total_capacity, $total_uom, $consignee_id,
		$order_service, $order_vehicletype, $order_vehiclebacktype, $order_remarks, $order_time, $user) {

		$sql = "update tx_order set shipper_id = '" . $shipper_id . "',total_capacity = '".$total_capacity."'
				,total_uom = '".$total_uom."',consignee_id = '".$consignee_id."'
				,order_service = '" . $order_service . "', order_vehicletype = '". $order_vehicletype ."'
				,order_vehiclebacktype = '". $order_vehiclebacktype ."', order_remarks = '".$order_remarks."'
				,order_time = '". $order_time ."'
				 where order_id = '" . $order_id . "' ";

		$aksinyo = "Mengubah order dengan ID " . $order_id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function tx_order_delete($id) {
		$sql = "delete from tx_order where order_id = '" . $id . "' ";
		$aksinyo = "Menghapus order dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function get_last_order_number() {
		$sql = "select order_number from tx_order order by created_on desc limit 0,1 ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
}
?>
