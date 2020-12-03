<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class txoutbonddelivery {
	var $_db;
	var $userId;

	function txoutbonddelivery($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}

	function uniq_id() {
		return $this->_db->uniqid ();
	}

	function tx_outbonddelivery_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM tx_outbonddelivery where outbond_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}

	function tx_outbonddelivery_view_data($outbond_id) {
		$sql = "select outbond_id,outbond_number,outbond_date,outbond_etd,outbond_eta,outbond_servicemode,
        outbond_servicepackage,outbond_origin, outbond_destination, outbond_shippingname, outbond_shipname,
        outbond_containernumber,outbond_agentid, outbond_shippingvendorid,outbond_truckingvendorid,
        outbond_truckingvehiclenumber,outbond_truckingdrivername,outbond_truckingdriverphonenumber,
        created_on, created_by,updated_on,updated_by from tx_outbonddelivery
				where outbond_id = '" . $outbond_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_outbonddelivery_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "outbond_id,outbond_number,outbond_date,outbond_etd,outbond_eta,outbond_servicemode,
        outbond_servicepackage,outbond_origin, outbond_destination, outbond_shippingname, outbond_shipname,
        outbond_containernumber,outbond_agentid, outbond_shippingvendorid,outbond_truckingvendorid,
        outbond_truckingvehiclenumber,outbond_truckingdrivername,outbond_truckingdriverphonenumber,
        created_on, created_by,updated_on,updated_by from tx_outbonddelivery where outbond_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_outbonddelivery_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select outbond_id,outbond_number,outbond_date,outbond_etd,outbond_eta,outbond_servicemode,
        outbond_servicepackage,outbond_origin, outbond_destination, outbond_shippingname, outbond_shipname,
        outbond_containernumber,outbond_agentid, outbond_shippingvendorid,outbond_truckingvendorid,
        outbond_truckingvehiclenumber,outbond_truckingdrivername,outbond_truckingdriverphonenumber,
        created_on, created_by,updated_on,updated_by from tx_outbonddelivery
		    where 1=1 ".$condition." LIMIT $offset, $num_row";

		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_outbonddelivery_add($outbond_number,$outbond_date,$outbond_etd,$outbond_eta,$outbond_servicemode,
      $outbond_servicepackage,$outbond_origin, $outbond_destination, $outbond_shippingname, $outbond_shipname,
      $outbond_containernumber,$outbond_agentid, $outbond_shippingvendorid, $outbond_truckingvendorid,
      $outbond_truckingvehiclenumber, $outbond_truckingdrivername, $outbond_truckingdriverphonenumber, $user) {

		$id = $this->uniq_id ();
		$sql = "insert into tx_outbonddelivery
				(outbond_id,outbond_number,outbond_date,outbond_etd,outbond_eta,outbond_servicemode,
        outbond_servicepackage,outbond_origin, outbond_destination, outbond_shippingname, outbond_shipname,
        outbond_containernumber,outbond_agentid, outbond_shippingvendorid,outbond_truckingvendorid,
        outbond_truckingvehiclenumber,outbond_truckingdrivername,outbond_truckingdriverphonenumber,
        created_by,updated_by)
				values
				('" . $outbond_id . "', '" . $outbond_number . "', '" . $outbond_date . "', '" . $outbond_etd . "', '" . $outbond_eta .
				 "', '" . $outbond_servicemode . "', '" . $outbond_servicepackage . "',
				'" . $outbond_origin . "', '" . $outbond_destination . "','".$outbond_shippingname."',
				'" . $outbond_shipname . "', '" . $outbond_containernumber ."', '". $outbond_agentid ."'
				, '" . $outbond_shippingvendorid . "' , '" . $outbond_truckingvendorid . "' , '" . $outbond_truckingvehiclenumber . "'
        , '" . $outbond_truckingdrivername . "', '" . $outbond_truckingdriverphonenumber . "', '" . $user . "', '" . $user . "' )";

		$aksinyo = "Menambah outbond delivery ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function tx_outbonddelivery_edit($outbond_id,$outbond_number,$outbond_date,$outbond_etd,$outbond_eta,$outbond_servicemode,
      $outbond_servicepackage,$outbond_origin, $outbond_destination, $outbond_shippingname, $outbond_shipname,
      $outbond_containernumber,$outbond_agentid, $outbond_shippingvendorid, $outbond_truckingvendorid,
      $outbond_truckingvehiclenumber, $outbond_truckingdrivername, $outbond_truckingdriverphonenumber, $user) {

		$sql = "update tx_outbonddelivery set outbond_date = '" . $outbond_date . "',outbond_etd = '".$outbond_etd."'
				,outbond_eta = '".$outbond_eta."',outbond_servicemode = '".$outbond_servicemode."'
				,outbond_servicepackage = '" . $outbond_servicepackage . "', outbond_origin = '". $outbond_origin ."'
				,outbond_destination = '". $outbond_destination ."', outbond_shippingname = '".$outbond_shippingname."'
				,outbond_shipname = '". $outbond_shipname ."'
        ,outbond_containernumber = '". $outbond_containernumber ."'
        ,outbond_agentid = '". $outbond_agentid ."'
        ,outbond_shippingvendorid = '". $outbond_shippingvendorid ."'
        ,outbond_truckingvehiclenumber = '". $outbond_truckingvehiclenumber ."'
        ,outbond_truckingdrivername = '". $outbond_truckingdrivername ."'
        ,outbond_truckingdriverphonenumber = '". $outbond_truckingdriverphonenumber ."'
        ,updated_on = CURRENT_TIMESTAMP
        ,updated_by = '". $user ."'
				 where outbond_id = '" . $outbond_id . "' ";

		$aksinyo = "Mengubah outbond delivery dengan ID " . $outbonddelivery_id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function tx_outbonddelivery_delete($id) {
		$sql = "delete from tx_outbonddelivery where outbonddelivery_id = '" . $id . "' ";
		$aksinyo = "Menghapus outbonddelivery dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function get_last_outbonddelivery_number() {
		$sql = "select outbond_number from tx_outbonddelivery outbonddelivery by created_on desc limit 0,1 ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
}
?>
