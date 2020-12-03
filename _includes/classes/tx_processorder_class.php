<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class txprocessorder {
	var $_db;
	var $userId;
	function txprocessorder($userId = "") {
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

		$sql = "select count(*) FROM tx_order where order_id is not null and order_status = 'WAITING' ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}

	function tx_order_view_data($order_id) {
		$sql = "select order_id,order_number,unit_modem,deliverymethod_id,citydeliver_id,citydeliver_description,
		orderdeliver_date,orderdeliver_time,citypickup_id,citypickup_description,orderpickup_date,orderpickup_time,
		order_status,created_on, created_by,updated_on,updated_by from tx_order
				where order_id = '" . $order_id . "' ";
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

		$sql = "select tx_order.order_id, tx_order.order_number, tx_order.unit_modem, par_kabupaten.kabupaten_name,
		tx_order.orderdeliver_date, tx_order.order_status
		from tx_order left join par_kabupaten
		on tx_order.citydeliver_id = par_kabupaten.kabupaten_id
		where order_status = 'WAITING' ".$condition." LIMIT $offset, $num_row";

		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_processorder_add($order_id, $processed_by) {

		$id = $this->uniq_id ();
		$sql = "insert into tx_processorder
				(processed_id,order_id,processed_by)
				values
				('" . $id . "', '" . $order_id . "', '" . $processed_by . "')";

		$aksinyo = "Menambah process order ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );

		$sql = "";
		$sql = "update tx_order set order_status = 'READY TO DELIVER', updated_on = CURRENT_TIMESTAMP, updated_by = '". $processed_by ."'
		    where order_id ='" . $order_id . "'";

		$aksinyo = "Set status order ID " . $order_id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
		return $id;
	}

	function tx_processorder_detail_add($processed_id, $assembly_id, $processed_by) {

		$sql = "insert into tx_processorder_detail
				(processed_id,assembly_id)
				values
				('" . $processed_id . "', '" . $assembly_id . "')";

		$aksinyo = "Menambah process order detail ID " . $processed_id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );

		$sql = "update ps_assembly set status_ready = 1, updated_on = CURRENT_TIMESTAMP, updated_by = '". $processed_by ."'
						where assembly_id = '" . $assembly_id . "'";

		$aksinyo = "Update assembly ID " . $assembly_id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );

	}

}
?>
