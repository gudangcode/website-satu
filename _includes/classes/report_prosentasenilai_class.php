<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class  reportprosentasenilai{
	var $_db;
	var $userId;
	function reportprosentasenilai($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}

	function report_prosentasenilai_count($date1, $date2, $media) {
		$sql = "";
		if($date1!="" && $date2!=""){
			$sql .= "select count(*) from (
				select media_id, media_name, media_picname, 
				ifnull((select sum(news_point) from tx_positivenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."'), 0) as media_nilaipositif,
				ifnull((select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."') , 0) as media_nilainegatif,
				ifnull((select sum(news_point) from tx_advertorialnews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."'), 0) as media_nilaiadvertorial,
				ifnull(ROUND((100-(select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."')/(select sum(news_point) 
				from tx_positivenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."')*100), 2), 0) as media_prosentase  from master_media
				) prosentase_nilai";
			if($media != ""){
				$sql .= " where media_id ='".$media."'";
			}
		}else{
			$sql .= "select count(*) from (
				select media_id, media_name, media_picname, 
				ifnull((select sum(news_point) from tx_positivenews where media_id = master_media.media_id and news_broadcastdate ), 0) as media_nilaipositif,
				ifnull((select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate ) , 0) as media_nilainegatif,
				ifnull((select sum(news_point) from tx_advertorialnews where media_id = master_media.media_id and news_broadcastdate ), 0) as media_nilaiadvertorial,
				ifnull(ROUND((100-(select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate )/(select sum(news_point) from tx_positivenews 
				where media_id = master_media.media_id and news_broadcastdate )*100), 2), 0) as media_prosentase  from master_media 
				) prosentase_nilai ";
			if($media != ""){
				$sql .= " where media_id ='".$media."'";
			}
		}
		
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}

	function report_prosentasenilai_viewlist($date1, $date2, $media, $offset, $num_row, $additionalcondition) {
		$sql = "";

		if($date1!="" && $date2!=""){
			$sql .= "select media_id, media_name, media_picname, 
			ifnull((select sum(news_point) from tx_positivenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."'), 0) as media_nilaipositif,
			ifnull((select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."') , 0) as media_nilainegatif,
			ifnull((select sum(news_point) from tx_advertorialnews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."'), 0) as media_nilaiadvertorial,
			ifnull(ROUND((100-(select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."')/(select sum(news_point) 
			from tx_positivenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."')*100), 2), 0) as media_prosentase  from master_media";
			if($media != ""){
				$sql .= " where media_id ='".$media."'";
			}
			$sql .= "  order by media_prosentase desc LIMIT $offset, $num_row";
		}else{
			$sql .= "select media_id, media_name, media_picname, 
			ifnull((select sum(news_point) from tx_positivenews where media_id = master_media.media_id and news_broadcastdate ), 0) as media_nilaipositif,
			ifnull((select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate ) , 0) as media_nilainegatif,
			ifnull((select sum(news_point) from tx_advertorialnews where media_id = master_media.media_id and news_broadcastdate ), 0) as media_nilaiadvertorial,
			ifnull(ROUND((100-(select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate )/(select sum(news_point) from tx_positivenews 
			where media_id = master_media.media_id and news_broadcastdate )*100), 2), 0) as media_prosentase  from master_media ";
			if($media != ""){
				$sql .= " where media_id ='".$media."'";
			}
			$sql .= "  order by media_prosentase desc LIMIT $offset, $num_row";
		}

		$data = $this->_db->_dbquery ( $sql );
		
		return $data;
	}

	function report_prosentasenilai_viewlist_allpage($date1, $date2, $media) {
		$sql = "";

		if($date1!="" && $date2!=""){
			$sql .= "select media_id, media_name, media_picname, 
			ifnull((select sum(news_point) from tx_positivenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."'), 0) as media_nilaipositif,
			ifnull((select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."') , 0) as media_nilainegatif,
			ifnull((select sum(news_point) from tx_advertorialnews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."'), 0) as media_nilaiadvertorial,
			ifnull(ROUND((100-(select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."')/(select sum(news_point) 
			from tx_positivenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."')*100), 2), 0) as media_prosentase  from master_media";
			if($media != ""){
				$sql .= " where media_id ='".$media."'";
			}
			$sql .= "  order by media_prosentase desc ";
		}else{
			$sql .= "select media_id, media_name, media_picname, 
			ifnull((select sum(news_point) from tx_positivenews where media_id = master_media.media_id and news_broadcastdate ), 0) as media_nilaipositif,
			ifnull((select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate ) , 0) as media_nilainegatif,
			ifnull((select sum(news_point) from tx_advertorialnews where media_id = master_media.media_id and news_broadcastdate ), 0) as media_nilaiadvertorial,
			ifnull(ROUND((100-(select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate )/(select sum(news_point) from tx_positivenews 
			where media_id = master_media.media_id and news_broadcastdate )*100), 2), 0) as media_prosentase  from master_media ";
			if($media != ""){
				$sql .= " where media_id ='".$media."'";
			}
			$sql .= "  order by media_prosentase desc ";
		}

		$data = $this->_db->_dbquery ( $sql );
		
		return $data;
	}

	function report_prosentasenilai_viewlist_service($date1, $date2, $media) {
		$sql = "";

		if($date1!="" && $date2!=""){
			$sql .= "select media_id, media_name, media_picname, 
			ifnull((select sum(news_point) from tx_positivenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."'), 0) as media_nilaipositif,
			ifnull((select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."') , 0) as media_nilainegatif,
			ifnull((select sum(news_point) from tx_advertorialnews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."'), 0) as media_nilaiadvertorial,
			ifnull(ROUND((100-(select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."')/(select sum(news_point) 
			from tx_positivenews where media_id = master_media.media_id and news_broadcastdate between '".$date1."' and '".$date2."')*100), 2), 0) as media_prosentase  from master_media";
			if($media != ""){
				$sql .= " where media_id ='".$media."'";
			}
			$sql .= "  order by media_prosentase desc";
		}else{
			$sql .= "select media_id, media_name, media_picname, 
			ifnull((select sum(news_point) from tx_positivenews where media_id = master_media.media_id and news_broadcastdate ), 0) as media_nilaipositif,
			ifnull((select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate ) , 0) as media_nilainegatif,
			ifnull((select sum(news_point) from tx_advertorialnews where media_id = master_media.media_id and news_broadcastdate ), 0) as media_nilaiadvertorial,
			ifnull(ROUND((100-(select sum(news_point) from tx_negativenews where media_id = master_media.media_id and news_broadcastdate )/(select sum(news_point) from tx_positivenews 
			where media_id = master_media.media_id and news_broadcastdate )*100), 2), 0) as media_prosentase  from master_media ";
			if($media != ""){
				$sql .= " where media_id ='".$media."'";
			}
			$sql .= "  order by media_prosentase desc";
		}

		$data = $this->_db->_dbquery ( $sql );
		
		return $data;
	}
}
?>

