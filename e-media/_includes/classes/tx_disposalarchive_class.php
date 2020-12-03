<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class txdisposalarchive {
	var $_db;
	var $userId;

	function txdisposalarchive($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}

	function uniq_id() {
		return $this->_db->uniqid ();
	}

	function tx_disposalarchive_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM tx_disposalarchive where disposalarchive_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}

	function tx_disposalarchive_view_data($disposalarchive_id) {
		$sql = "select disposalarchive_id, disposalarchive_type, disposalarchive_boxnumber, disposalarchive_customername,
            disposalarchive_date, disposalarchive_kind, disposalarchive_condition, disposalarchive_period,
            disposalarchive_status, disposalarchive_remark, created_on, created_by,updated_on,updated_by from tx_disposalarchive
				    where disposalarchive_id = '" . $disposalarchive_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function tx_disposalarchive_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select disposalarchive_id, disposalarchive_type, disposalarchive_boxnumber, disposalarchive_customername,
            disposalarchive_date, disposalarchive_kind, disposalarchive_condition, disposalarchive_period,
            disposalarchive_status, disposalarchive_remark, created_on, created_by,updated_on,updated_by from tx_disposalarchive where disposalarchive_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_disposalarchive_viewlist($key_search, $val_search, $all_field, $offset, $num_row) {
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

		$sql = "select disposalarchive_id, disposalarchive_type, disposalarchive_boxnumber, disposalarchive_customername,
            disposalarchive_date, disposalarchive_kind, disposalarchive_condition, disposalarchive_period,
            disposalarchive_status, disposalarchive_remark, created_on, created_by,updated_on,updated_by from tx_disposalarchive
		where 1=1 ".$condition." LIMIT $offset, $num_row";

		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_disposalarchive_add($disposalarchive_type, $disposalarchive_boxnumber, $disposalarchive_customername,
          $disposalarchive_date, $disposalarchive_kind, $disposalarchive_condition, $disposalarchive_period,
          $disposalarchive_status, $disposalarchive_remark, $user) {

		$id = $this->uniq_id ();
		$sql = "insert into tx_disposalarchive
				(disposalarchive_id,disposalarchive_type,disposalarchive_boxnumber, disposalarchive_customername,
        disposalarchive_date, disposalarchive_kind, disposalarchive_condition, disposalarchive_period, disposalarchive_status,
        disposalarchive_remark ,created_by,updated_by)
				values
				('" . $id . "', '" . $disposalarchive_type . "', '" . $disposalarchive_boxnumber . "', '" . $disposalarchive_customername . "', '" . $disposalarchive_date .
				 "', '" . $disposalarchive_kind . "', '" . $disposalarchive_condition . "',
				'" . $disposalarchive_period . "', '" . $disposalarchive_status . "','".$disposalarchive_remark."',
			  '" . $user .
				"', '" . $user . "' )";

		$aksinyo = "Menambah order ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function tx_disposalarchive_edit($disposalarchive_id, $disposalarchive_type, $disposalarchive_boxnumber, $disposalarchive_customername,
          $disposalarchive_date, $disposalarchive_kind, $disposalarchive_condition, $disposalarchive_period,
          $disposalarchive_status, $disposalarchive_remark, $user) {

		$sql = "update tx_disposalarchive set disposalarchive_type = '" . $disposalarchive_type . "'
        ,disposalarchive_boxnumber = '".$disposalarchive_boxnumber."'
				,disposalarchive_customername = '".$disposalarchive_customername."'
        ,disposalarchive_date = '".$disposalarchive_date."'
				,disposalarchive_kind = '" . $disposalarchive_kind . "'
        ,disposalarchive_condition = '". $disposalarchive_condition ."'
				,disposalarchive_period = '". $disposalarchive_period ."'
        ,disposalarchive_status = '".$disposalarchive_status."'
				,disposalarchive_remark = '". $disposalarchive_remark ."'
				 where disposalarchive_id = '" . $disposalarchive_id . "' ";

		$aksinyo = "Mengubah order dengan ID " . $disposalarchive_id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function tx_disposalarchive_delete($id) {
		$sql = "delete from tx_disposalarchive where disposalarchive_id = '" . $id . "' ";
		$aksinyo = "Menghapus order dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

}
?>
