<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class backuprestore {
	var $_db;
	var $userId;

	function backuprestore($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	
	function backup_count() {
		$sql = "select count(*) FROM backup_restore 
				left join user_apps on backup_restore_id_user = user_id
				where 1=1 ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	
	function backup_view_grid($offset, $num_row) {
		$sql = "select backup_restore_id, user_username, backup_date, backup_restore_st
				from backup_restore 
				left join user_apps on backup_restore_id_user = user_id
				where 1=1  LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function backup_viewlist($id) {
		$sql = "select backup_date from backup_restore where backup_restore_id = '".$id."' ";
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow();
		return $arr[0];
	}
	
	function backup_add_history($nama_file) {
		$sql = "insert into backup_restore (backup_restore_id, backup_restore_id_user, backup_date, backup_restore_st) values ('".$this->uniq_id()."', '".$this->userId."', '".$nama_file."', '0') "; 
		$aksinyo = "Backup Database";
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	
	function backup_update_restore($id, $date) {
		$sql = "update backup_restore set backup_restore_st = 1, restore_date = '".$date."' where backup_restore_id = '".$id."' " ;
		$aksinyo = "Restore Database dengan ID ".$id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	
	function backupdatabase($nama_file){
		$whatToWrite = $this->get_data();
		$this->write_to_file($whatToWrite, $nama_file);
	}

	function get_data(){
	
		$getRetrive = "";
	
		$arr_table = $this->list_tables();
		foreach($arr_table as $table){
			$getRetrive .= $this->DumpTable($table);
		}
		return $getRetrive;
	}
	
	function write_to_file($whatToWrite, $nama_file){
		$full_path = $this->_db->basepath."backup_db/".$nama_file.".sql";
		$f_open = fopen($full_path, "w");
		$f_write = fwrite($f_open, $whatToWrite, strlen($whatToWrite));
		fclose($f_open);
	}
	
	function list_tables(){
	
		$nama_tabel = array();
		
		$sql = "SHOW TABLES";
		$data = $this->_db->_dbquery ( $sql );
		
		while($arr = $data->FetchRow()){
			$nama_tabel[] = $arr[0];
		}
		if(!sizeof($nama_tabel)){
			return "No tables found in database". $this->_db->$dbname;
		}elseif(sizeof($nama_tabel)){
			return $nama_tabel;
		}
	}
	
	function DumpTable($table){
	
		$getDumpTable = "";

		$sql_1 = "LOCK TABLES".$table."WRITE";
		$rs_1 = $this->_db->_dbquery ( $sql_1 );
		
		$getDumpTable .= "<query>DROP TABLE IF EXISTS ".$table."\r\n";

		$sql_2 = "SHOW CREATE TABLE ".$table;
		$rs_2 = $this->_db->_dbquery ( $sql_2 );
		
		$arr_2 = $rs_2->FetchRow();
		
		$getDumpTable .= "<query>".str_replace("\n", "\r\n", $arr_2['Create Table'])."\r\n";
		$getDumpTable .= $this->Get_Data_Table($table);
		
		$sql_3 = "UNLOCK TABLES";
		$this->_db->_dbquery ( $sql_3 );
		
		
		return $getDumpTable;
	}
	function Get_Data_Table($table){
	
		$getInsertsTable = "";

		$sql = "SELECT * FROM ".$table;
		$rs = $this->_db->_dbquery ( $sql );
		
		while($arr = $rs->FetchRow()){
			$getInsertsTables = "";
			
			$jml_field = count($arr)/2;
			$jml_array = $jml_field-1;
			for($i=0;$i<$jml_field;$i++){
				$koma = ", ";
				if($i==$jml_array) $koma = "";
				$getInsertsTables .="'".$arr[$i]."'".$koma;
			}
			$getInsertsTable .= "<query>INSERT INTO ".$table." VALUES (".$getInsertsTables.")"."\r\n";
		}
		
		return $getInsertsTable;
		
	}

	function restore_database($file){
		$full_path = $this->_db->basepath."backup_db/".$file.".sql";
		@$this->file_handle = fopen($full_path, "rw");
		@$this->contents = fread($this->file_handle, filesize($full_path));
		$this->contents = str_replace("\\", "", $this->contents);
		$exploe = explode("<query>", $this->contents);
		$nExploe = sizeof($exploe);
		for($n=1;$n<$nExploe;$n++){
			$skip = "0";
			$sql = $exploe[$n];
			if(stripos($sql, 'DROP TABLE IF EXISTS log_activity') !== false ) $skip = "1";
			if(stripos($sql, 'CREATE TABLE `log_activity`') !== false ) $skip = "1";
			if(stripos($sql, 'INSERT INTO log_activity') !== false ) $skip = "1";
			
			if(stripos($sql, 'DROP TABLE IF EXISTS backup_restore') !== false ) $skip = "1";
			if(stripos($sql, 'CREATE TABLE `backup_restore`') !== false ) $skip = "1";
			if(stripos($sql, 'INSERT INTO backup_restore') !== false ) $skip = "1";
			
			if($skip=="0"){
				$this->_db->_dbquery($sql);
			}
		}			
	}
}