<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class  txadvertorialnews{
	var $_db;
	var $userId;
	function txadvertorialnews($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	function tx_advertorialnews_count($key_search, $val_search, $all_field) {
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

		$sql = "select count(*) FROM tx_advertorialnews as a left join master_media as b on a.media_id = b.media_id
				where a.news_id is not null ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function tx_advertorialnews_view_data($news_id) {
		$sql = "select news_id, news_title, news_broadcastdate, news_page, news_size,
				news_writer, news_image, news_point, news_price, media_id, news_url from tx_advertorialnews
				where news_id = '" . $news_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function tx_advertorialnews_view_grid($key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select news_id, news_title, news_broadcastdate, news_page, news_size,
		news_writer, news_image, news_point, news_price, media_id,
		created_on, created_by, updated_on,updated_by, news_url 
		where news_id is not null ".$condition." LIMIT $offset, $num_row ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_advertorialnews_viewlist($key_search, $val_search, $all_field, $offset, $num_row, $additionalcondition) {
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

		$sql = "select a.news_id, a.news_title, a.news_broadcastdate, a.news_page, a.news_size,
				a.news_writer, a.news_image, a.news_point, a.news_price, a.media_id, b.media_name,
				a.created_on, a.created_by, a.updated_on, a.updated_by, a.news_url
				FROM tx_advertorialnews as a left join master_media as b on a.media_id = b.media_id  where 1=1 ".$condition." ORDER BY a.news_title ASC LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}

	function tx_advertorialnews_add($news_id, $news_title, $news_broadcastdate,  $news_page, $news_size,
		$news_writer, $news_image, $news_point, $news_price, $media_id, $user) {
		
		$sql = "insert into tx_advertorialnews
				(news_id, news_title, news_broadcastdate, news_page, news_size,
				news_writer, news_image, news_point, news_price, media_id, news_url, created_by, updated_by)
				values
				('" . $news_id . "', '" . $news_title . "','".$news_broadcastdate."','".$news_page."',
					'".$news_size."','".$news_writer."','".$news_image."',
					'".$news_point."','".$news_price."','".$media_id."','".$news_url."',
					'".$user."','".$user."')";
		$aksinyo = "Menambah news ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

	function tx_advertorialnews_edit($id, $news_title, $news_broadcastdate,  $news_page, $news_size,
	$news_writer, $news_image, $news_point, $news_price, $media_id, $news_url, $user) {
		$sql = "update tx_advertorialnews set news_title = '" . $news_title . "', 
				news_broadcastdate = '" . $news_broadcastdate . "',
				news_page = '".$news_page."',
				news_size = '" . $news_size . "',
				news_writer = '" . $news_writer . "',
				news_image = '" . $news_image . "',  
				news_point = '" . $news_point . "',  
				news_price = '" . $news_price . "',  
				media_id = '" . $media_id . "',    
				news_url = '" . $news_url . "',  
				updated_by = '".$user."'";

		$sql = $sql." where news_id = '" . $id . "' ";

		$aksinyo = "Mengubah news dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function tx_advertorialnews_delete($id) {
		$sql = "delete from tx_advertorialnews where news_id = '" . $id . "' ";
		echo $sql;
		$aksinyo = "Menghapus news dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}

}
?>
