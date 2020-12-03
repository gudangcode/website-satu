<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class  masterproduct{
	var $_db;
	var $userId;
	function masterproduct($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function master_product_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM master_product as a left join master_media as b on a.media_id = b.media_id
				where a.product_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function master_product_view_data($product_id) {
		$sql = "select product_id, product_name, product_uom, product_price, media_id
				from master_product where product_id = '" . $product_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function master_product_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select product_id, product_name, product_uom, product_price, media_id,
		created_on, created_by, updated_on,updated_by 
		where product_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_product_viewlist($key_search, $val_search, $all_field, $offset, $num_row, $additionalcondition) {
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

		$sql = "select a.product_id, a.product_name, a.product_uom, a.product_price, a.media_id, b.media_name,
				a.created_on, a.created_by, a.updated_on, a.updated_by
				FROM master_product as a left join master_media as b on a.media_id = b.media_id  where 1=1 ".$condition." ORDER BY a.product_name ASC LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function master_product_add($product_id, $product_name, $product_uom,  $product_price, $media_id, $user) {
		
		$sql = "insert into master_product
				(product_id, product_name, product_uom, product_price, media_id, created_by, updated_by)
				values
				('" . $product_id . "', '" . $product_name . "','".$product_uom."','".$product_price.
					"','".$media_id."',
					'".$user."','".$user."')";
		$aksinyo = "Menambah product ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function master_product_edit($id, $product_name, $product_uom,  $product_price, $media_id, $user) {
		$sql = "update master_product set product_name = '" . $product_name . "', 
				product_uom = '" . $product_uom . "',
				product_price = '".$product_price."',
				media_id = '" . $media_id . "',  
				updated_by = '".$user."'";

		$sql = $sql." where product_id = '" . $id . "' ";

		$aksinyo = "Mengubah product dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function master_product_delete($id) {
		$sql = "delete from master_product where product_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus product dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

}
?>
