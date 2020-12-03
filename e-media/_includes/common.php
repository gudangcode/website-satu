<?
include_once "DB.class.php";
class comfunction {
	var $_db;
	var $baseurl = "https://e-media.tulangbawangbaratkab.go.id/";
	function comfunction($userId = "") {
		$this->_db = new db ();
	}
	function generate_sequence_number($num, $length){
		if($num === NULL){
			$num = 0;
		}
		$number=$num+1;
		while (strlen($number)<$length) {
				$number = "0".$number;
		}
		return $number."";
	}
	function generate_sequence_number_tlc($num, $length, $tlc){
		if($num === NULL){
			$num = 0;
		}else{
			$num = substr($num, 3, 5);
		}
		$number=$num+1;
		while (strlen($number)<$length) {
				$number = "0".$number;
		}
		return $tlc."".$number."";
	}
	function generate_order_number($lastnumber, $length){
		$x = date("Ymd");
		if($lastnumber === NULL){
			$lastnumber = 0;
		}
		$number=$lastnumber+1;
		while (strlen($number)<$length) {
				$number = "0".$number;
		}
		return $number."".$x;
	}
	function get_base_url(){
		return $this->baseurl;
	}
	function microtime_float() {
		list ( $usec, $sec ) = explode ( " ", microtime () );
		return (( float ) $usec + ( float ) $sec);
	}
	function basepath($folder_modul) {
		return $this->_db->basepath . "Upload/" . $folder_modul . "/";
	}
	function baseurl($folder_modul) {
		return $this->_db->baseurl . "Upload/" . $folder_modul . "/";
	}
	function print_menu_recursive($parent_id) {
		$ret = "<ul>";
		$rs_menu = $this->menu_list_all ( $parent_id );
		while ( $arr_menu = $rs_menu->FetchRow () ) {
			$ret .= "<li><input type=\"checkbox\" value=\"" . $arr_menu ['menu_id'] . "\" name=\"child_" . $arr_menu ['menu_id'] . "\">" . $arr_menu ['menu_name'] . "</li>";
			$cek_sub = $this->cek_sub_menu ( $arr_menu ['menu_id'] );
			// if($cek_sub!=0)
			$ret .= "<li>" . $this->print_menu_recursive ( $arr_menu ['menu_id'] ) . "</li>";
		}
		return $ret .= "</ul>";
	}
	function notif_user_all_bygroup($group_id) {
		$sql = "select user_id from user_apps
				join role_group_menu on user_id_group = role_menu_group_id
				where role_menu_menu_id = '".$group_id."' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function insert_notif($notif_data_id, $notif_from_user_id, $notif_to_user_id, $notif_method, $notif_desc, $notif_date) {
		$sql = "insert into notification (notif_id, notif_data_id, notif_from_user_id, notif_to_user_id, notif_method, notif_desc)
					values
				('".$this->_db->uniqid()."', '".$notif_data_id."', '".$notif_from_user_id."', '".$notif_to_user_id."', '".$notif_method."', '".$notif_desc."')";
		$this->_db->_dbquery ( $sql );
	}
	function hapus_notif($notif_data_id) {
		$sql = "delete from notification where notif_data_id = '".$notif_data_id."' ";
		$this->_db->_dbquery ( $sql );
	}
	function list_notif($user_id) {
		$sql = "select notif_id, notif_data_id, user_username as from_auditor, notif_to_user_id, notif_method, notif_desc, notif_date
				from notification
				join user_apps on notif_from_user_id = user_id
				where notif_to_user_id = '".$user_id."' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_sub_menu($parrent) {
		$sql = "select count(*) from par_menu where menu_parrent = '" . $parrent . "' ";
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr [0];
	}
	function menu_akses($parrent = "") {
		$condition1 = "";
		$condition2 = "";
		if ($parrent != "") {
			$condition1 = ", akses_name, akses_id";
			$condition2 = "and akses_menu = '" . $parrent . "' ";
		}
		$sql = "select DISTINCT akses_menu" . $condition1 . " from par_audit_akses where 1=1 " . $condition2 . " order by akses_sort";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function menu_list($parrent, $group_id = "") {
		$condition = "";
		if ($group_id != "")
			$condition = " and role_menu_group_id = '" . $group_id . "' ";
		$sql = "select DISTINCT menu_id, menu_name, menu_link, menu_parrent, menu_sort, menu_file, menu_icon from par_menu
				left join role_group_menu on menu_id = role_menu_menu_id
				where menu_del_st = 1 and menu_show = 1 and menu_parrent = '" . $parrent . "' " . $condition . "  order by menu_sort";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function menu_list_all($parrent) {
		$sql = "select DISTINCT menu_id, menu_name, menu_link, menu_parrent, menu_sort from par_menu
				left join role_group_menu on menu_id = role_menu_menu_id
				where menu_del_st = 1 and menu_parrent = '" . $parrent . "' order by menu_sort";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function menu_list_view() {
		$sql = "select menu_id, menu_parrent from par_menu
				where menu_del_st = 1 ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function menu_list_parrent($id = "") {
		$condition = "";
		if ($id != "")
			$condition = " and menu_id = '" . $id . "' ";
		$sql = "select menu_id, menu_name
				from par_menu
				where menu_del_st = 1 and menu_parrent = '0' " . $condition . " order by menu_sort";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_akses($group, $method, $action) {
		$sql = "SELECT count(child.menu_id) as count_menu_id FROM role_group_menu
				join par_menu as child on role_menu_menu_id = child.menu_id
				join par_menu as parrent on child.menu_parrent = parrent.menu_id
				WHERE role_menu_group_id = '" . $group . "' and child.menu_method = '" . $action . "' and parrent.menu_method = '" . $method . "' "; // echo $sql;
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return ($arr [0] == 0) ? false : true;
	}
	function cek_akses_data($group, $method) {
		$sql = "SELECT role_data_status FROM role_group_data
				WHERE role_data_method LIKE '%" . $method . "%' and role_data_id_group = '" . $group . "' ";
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr ['role_data_status'];
	}
	function statusCombo($def, $name) {
		$selNo = "";
		$selYes = "";
		if ($def == "0")
			$selNo = "selected";
		if ($def == "1")
			$selYes = "selected";
		$cb = "<select name=\"" . $name . "\">" . "<option value=\"0\" " . $selNo . " style=\"color:#FF0000\">No</option>" . "<option value=\"1\" " . $selYes . ">Yes</option>" . "</select>";
		return $cb;
	}
	function dbCombo($nama, $table, $id, $show, $where, $def, $other, $lit = false, $orderby = "", $parrent = false) {
		$combo = "";
		if ($lit)
			$combo .= "<option value=\"\"> Choose One </option>\n";
		if ($parrent)
			$combo .= "<option value=\"\">=== Parrent ===</option>\n";

		$html = "";
		$query = "select " . $id . ", " . $show . " from " . $table . " where 1=1 " . $where . " order by ". $show ." asc ";
		$data = $this->_db->_dbquery ( $query );
		$html .= "<select name=\"" . $nama . "\" id=\"" . $id . "\" class=\"" . $other . "\">";
		$html .= $combo;
		$rs_count = $data->RecordCount ();
		if ($rs_count != 0) {
			while ( $rs = $data->FetchRow () ) {
				if ($rs [0] == $def) {
					$selected = " selected ";
				} else {
					$selected = "";
				}
				$html .= "<option value=\"" . $rs [0] . "\" " . $selected . ">" . $rs [1] . "</option>";
			}
		} else {
			$html .= "<option value=\"\" >No Record</option>";
		}
		$html .= "</select>";
		return $html;
	}


	function dbRadio($nama, $table, $id, $show, $where, $def, $other, $lit = false, $orderby = "", $parrent = false) {

		$html = "<br/>";
		$query = "select " . $id . ", " . $show . " from " . $table . " where 1=1 " . $where . $orderby;
		$data = $this->_db->_dbquery ( $query );
		$rs_count = $data->RecordCount ();
		if ($rs_count != 0) {
			while ( $rs = $data->FetchRow () ) {
				if ($rs [0] == $def) {
					$selected = " selected ";
				} else {
					$selected = "";
				}
				$html .= "<input type=\"radio\" name=\"". $nama . "\" id=\"" . $id . "\" value=\"" . $rs [0] . "\" > ". $rs [0] ."&nbsp";
			}
		} else {
			$html .= "";
		}
		return "".$html;
	}

	function dbComboDisabled($nama, $table, $id, $show, $where, $def, $other, $lit = false, $orderby = "", $parrent = false) {
		$combo = "";



		if ($lit)
			$combo .= "<option value=\"\"> Choose One </option>\n";
		if ($parrent)
			$combo .= "<option value=\"\">=== Parrent ===</option>\n";

		$html = "";
		$query = "select " . $id . ", " . $show . " from " . $table . " where 1=1 " . $where . $orderby;
		$data = $this->_db->_dbquery ( $query );
		$html .= "<select name=\"" . $nama . "\" id=\"" . $nama . "\" class=\"" . $other . "\" disabled=\"true\">";
		$html .= $combo;
		$rs_count = $data->RecordCount ();
		if ($rs_count != 0) {
			while ( $rs = $data->FetchRow () ) {
				if ($rs [0] == $def) {
					$selected = " selected ";
				} else {
					$selected = "";
				}
				$html .= "<option value=\"" . $rs [0] . "\" " . $selected . ">" . $rs [1] . "</option>";
			}
		} else {
			$html .= "<option value=\"\" >No Record</option>";
		}
		$html .= "</select>";
		return $html;
	}
	function dbComboParameterizedId($nama, $table, $id, $show, $where, $def, $other, $idjs) {
		$combo = "";



		$combo .= "<option value=\"\"> Choose One </option>\n";

		$html = "";
		$query = "select " . $id . ", " . $show . " from " . $table . " where 1=1 " . $where ;
		$data = $this->_db->_dbquery ( $query );
		$html .= "<select name=\"" . $nama . "\" id=\"" . $idjs . "\" class=\"" . $other . "\">";
		$html .= $combo;
		$rs_count = $data->RecordCount ();
		if ($rs_count != 0) {
			while ( $rs = $data->FetchRow () ) {
				//echo $rs[0]." - ".$def;
				if ($rs [0] == $def) {
					$selected = " selected ";
				} else {
					$selected = "";
				}
				$html .= "<option value=\"" . $rs [0] . "\" " . $selected . ">" . $rs [1] . "</option>";
			}
		} else {
			$html .= "<option value=\"\" >No Record</option>";
		}
		$html .= "</select>";
		return $html;
	}
	function buildCombo($objname, $data, $col_id, $col_show, $selected_id = "", $action_onchange = "", $style = "", $use_none = false, $use_head = false, $use_all = false, $other = "") {
		$combo = "";
		$combo .= "<select name=\"$objname\" id=\"$objname\" style=\"$style\" class=\"" . $other . "\" onchange = \"return " . $action_onchange . "\">\n";
		if ($use_none)
			$combo .= "<option value=\"\">==== Parent</option>\n";
		if ($use_head)
			$combo .= "<option value=\"\">==== Choose One</option>\n";
		if ($use_all)
			$combo .= "<option value=\"\">==== All ====</option>\n";
		foreach ( $data as $row ) {
			if ($row [$col_id] == $selected_id) {
				$combo .= "<option value=\"$row[$col_id]\" selected>$row[$col_show]</option>\n";
			} else {
				$combo .= "<option value=\"$row[$col_id]\">$row[$col_show]</option>\n";
			}
		}
		$combo .= "</select>\n";
		return $combo;
	}
	function buildCombo_risk($objname, $data, $col_id, $col_show, $selected_id = "", $style = "", $use_none = false, $use_head = false, $use_all = false, $other = "") {
		$combo = "";
		$combo .= "<select name=\"$objname\" id=\"$objname\" style=\"$style\" class=\"" . $other . "\">\n";
		if ($use_none)
			$combo .= "<option value=\"\">==== Parent</option>\n";
		if ($use_head)
			$combo .= "<option value=\"\">==== Choose One</option>\n";
		if ($use_all)
			$combo .= "<option value=\"\">==== All ====</option>\n";
		foreach ( $data as $row ) {
			if ($row [$col_id] == $selected_id) {
				$combo .= "<option value=\"$row[$col_id]\" selected>$row[$col_show]</option>\n";
			} else {
				$combo .= "<option value=\"$row[$col_id]\">$row[$col_show]</option>\n";
			}
		}
		$combo .= "</select>\n";
		return $combo;
	}
	function buildMultipleCombo($objname, $data, $col_id, $col_show, $selected_id = "", $id_field = "") {
		$combo = "";
		$combo .= "<select name=\"$objname\" id=\"$id_field\" multiple=\"multiple\">\n";
		foreach ( $data as $row ) {
			$selected = "";
			if ($selected_id != "") {
				foreach ( $selected_id as $row_select_id ) {
					if ($row [$col_id] == $row_select_id [1]) {
						$selected = "selected";
					}
				}
			}
			$combo .= "<option value=\"$row[$col_id]\" $selected>$row[$col_show]</option>\n";
		}
		$combo .= "</select>\n";
		return $combo;
	}
	function cek_holiday($start, $end) {
		$sql = "select count(*) FROM par_holiday where '" . $start . "' >= holiday_date and holiday_date <= '" . $end . "'"; //echo $sql;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function dateSql($tgl) {
		if ($tgl != "") {
			$exp = explode("-",$tgl);
			$xxx = date("Y-m-d", mktime(0,0,0,$exp[1],$exp[0],$exp[2]));
			return $xxx;
		} else {
			return "";
		}
	}
	function dateIndo($tgl) {
		if ($tgl > "0") {
			$xxx = date ( "d-m-Y", $tgl );
			return $xxx;
		} else {
			return "";
		}
	}
	function combo_hari_indo($hari, $name) {
		$senin = "";
		$selasa = "";
		$rabu = "";
		$kamis = "";
		$jumat = "";
		$sabtu = "";
		$minggu = "";
		if ($hari == "1")
			$senin = "selected";
		if ($hari == "2")
			$selasa = "selected";
		if ($hari == "3")
			$rabu = "selected";
		if ($hari == "4")
			$kamis = "selected";
		if ($hari == "5")
			$jumat = "selected";
		if ($hari == "6")
			$sabtu = "selected";
		if ($hari == "7")
			$minggu = "selected";
		$cb = "<select name=\"" . $name . "\">" . "<option value=\"1\" " . $senin . ">Senin</option>" . "<option value=\"2\" " . $selasa . ">Selasa</option>" . "<option value=\"3\" " . $rabu . ">Rabu</option>" . "<option value=\"4\" " . $kamis . ">Kamis</option>" . "<option value=\"5\" " . $jumat . ">Jum'at</option>" . "<option value=\"6\" " . $sabtu . ">Sabtu</option>" . "<option value=\"7\" " . $minggu . ">Minggu</option>" . "</select>";
		return $cb;
	}
	function dateIndoLengkap($tgl) {
		if ($tgl != "") {
			$tgl = $this->dateSql ( $tgl );
			$thn = substr ( $tgl, 0, 4 );
			$bln = substr ( $tgl, 5, 2 );
			if ($bln == 1) {
				$bln = "Januari";
			}
			if ($bln == 2) {
				$bln = "Februari";
			}
			if ($bln == 3) {
				$bln = "Maret";
			}
			if ($bln == 4) {
				$bln = "April";
			}
			if ($bln == 5) {
				$bln = "Mei";
			}
			if ($bln == 6) {
				$bln = "Juni";
			}
			if ($bln == 7) {
				$bln = "Juli";
			}
			if ($bln == 8) {
				$bln = "Agustus";
			}
			if ($bln == 9) {
				$bln = "September";
			}
			if ($bln == 10) {
				$bln = "Oktober";
			}
			if ($bln == 11) {
				$bln = "November";
			}
			if ($bln == 12) {
				$bln = "Desember";
			}
			$tgl = substr ( $tgl, 8, 2 );
			$xxx = "$tgl $bln $thn";
			return $xxx;
		}
	}
	function dateTimeIndo($tgl) {
		if ($tgl != "") {
			$xxx = date ( "d-m-Y H:i:s", $tgl );
			return $xxx;
		} else {
			return "";
		}
	}
	function date_db($tgl) {
		if ($tgl != "") {
			$xxx = strtotime ( $tgl );
			return $xxx;
		} else {
			return "";
		}
	}
	function nama_hari_indo($hari) {
		if ($hari == 1) {
			$hari = "Senin";
		}
		if ($hari == 2) {
			$hari = "Selasa";
		}
		if ($hari == 3) {
			$hari = "Rabu";
		}
		if ($hari == 4) {
			$hari = "Kamis";
		}
		if ($hari == 5) {
			$hari = "Jum'at";
		}
		if ($hari == 6) {
			$hari = "Sabtu";
		}
		if ($hari == 7) {
			$hari = "Minggu";
		}
		return $hari;
	}
	function weekNumberOfMonth($date) {
		$tgl = date_parse ( $date );
		$tanggal = $tgl ['day'];
		$bulan = $tgl ['month'];
		$tahun = $tgl ['year'];
		// tanggal 1 tiap bulan
		$tanggalAwalBulan = mktime ( 0, 0, 0, $bulan, 1, $tahun );
		$mingguAwalBulan = ( int ) date ( 'W', $tanggalAwalBulan );
		// tanggal sekarang
		$tanggalYangDicari = mktime ( 0, 0, 0, $bulan, $tanggal, $tahun );
		$mingguTanggalYangDicari = ( int ) date ( 'W', $tanggalYangDicari );
		$mingguKe = $mingguTanggalYangDicari - $mingguAwalBulan + 1;
		return $mingguKe;
	}
	function time_diff($dtSys, $dtfile) {
		$folder = "06082015";
		$y1 = substr ( $dtfile, 4, 4 );
		$m1 = substr ( $dtfile, 2, 2 );
		$d1 = substr ( $dtfile, 0, 2 );
		$convert_datefile = $d1 . "-" . $m1 . "-" . $y1;
		$DateDiff = floor ( strtotime ( $dtSys ) - strtotime ( $convert_datefile ) ) / 86400;
		return $DateDiff;
	}
	function cek_week($date, $jadwal, $SyatemDate) {
		$cek_exp = date ( 'd-m-Y', strtotime ( "-" . $jadwal . " week" ) );
		$y_exp = substr ( $cek_exp, 6, 4 );
		$m_exp = substr ( $cek_exp, 3, 2 );
		$w_exp = $this->weekNumberOfMonth ( $cek_exp );
		$y = substr ( $date, 3, 4 );
		$m = substr ( $date, 1, 2 );
		$w = substr ( $date, 0, 1 );
		if ($y_exp <= $y) {
			if ($m_exp <= $m) {
				if ($w_exp <= $w) {
					return "aktif";
				} else {
					return "Hapus";
				}
			} else {
				return "Hapus";
			}
		} else {
			return "Hapus";
		}
	}
	function cek_month($date, $jadwal) {
		$cek_exp = date ( '01-m-Y', strtotime ( "-" . $jadwal . " month" ) );
		$y_exp = substr ( $cek_exp, 6, 4 );
		$m_exp = substr ( $cek_exp, 3, 2 );
		$y = substr ( $date, 2, 4 );
		$m = substr ( $date, 0, 2 );
		$date_file = strtotime ( "01-" . $m . "-" . $y );
		if ($date_file < strtotime ( $cek_exp )) {
			return "Hapus";
		} else {
			return "Aktif";
		}
	}
	function js_alert_act($act_type, $nama = "") {
		if ($act_type == 1)
			$str_alert = "Data has been saved";
		else if ($act_type == 2)
			$str_alert = "Data has been deleted";
		else if ($act_type == 3)
			$str_alert = "Data has been saved";
		else if ($act_type == 4)
			$str_alert = "Data " . $nama . " is already in database";
		else if ($act_type == 5)
			$str_alert = "Please fill Mandatory Field";
		else if ($act_type == 6)
			$str_alert = "Password not valid";
		else if ($act_type == 7)
			$str_alert = "Data Telah Diajukan";
		else if ($act_type == 8)
			$str_alert = "Data Telah Disetujui";
		else if ($act_type == 9)
			$str_alert = "Data Telah Ditolak";
		else if ($act_type == 10)
			$str_alert = "Data Gagal Disimpan";
		else if ($act_type == 11)
			$str_alert = "Database Berhasil Dibackup";
		else if ($act_type == 12)
			$str_alert = "Database Berhasil Direstore, Silahkan Logout dan Login Kembali";
		else if ($act_type == 13)
		  $str_alert = $nama;
		?>
<script>alert('<?=$str_alert?>');</script>
<?
	}
	function replacetext($text) {
		$replaceText = trim ( $text );
		$replaceText = str_replace ( "'", "\'", $replaceText );
		return $replaceText;
	}
	function replaceformattedmoney($text){
		$replaceText = trim ( $text );
		$replaceText = str_replace ( ".", "", $replaceText );
		return $replaceText;
	}
	function text_show($text) {
		$text = str_replace ( "<p>", "", $text );
		$text = str_replace ( "</p>", "<br>", $text );
		return $text;
	}
	function xss_clean($data) {
		// Fix &entity\n;
		$data = str_replace ( array (
				'&amp;',
				'&lt;',
				'&gt;'
		), array (
				'&amp;amp;',
				'&amp;lt;',
				'&amp;gt;'
		), $data );
		$data = preg_replace ( '/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data );
		$data = preg_replace ( '/(&#x*[0-9A-F]+);*/iu', '$1;', $data );
		$data = html_entity_decode ( $data, ENT_COMPAT, 'UTF-8' );

		// Remove any attribute starting with "on" or xmlns
		$data = preg_replace ( '#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data );

		// Remove javascript: and vbscript: protocols
		$data = preg_replace ( '#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data );
		$data = preg_replace ( '#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data );
		$data = preg_replace ( '#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data );

		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace ( '#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data );
		$data = preg_replace ( '#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data );
		$data = preg_replace ( '#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data );

		// Remove namespaced elements (we do not need them)
		$data = preg_replace ( '#</*\w+:\w[^>]*+>#i', '', $data );

		do {
			// Remove really unwanted tags
			$old_data = $data;
			$data = preg_replace ( '#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data );
		} while ( $old_data !== $data );

		// we are done...
		return $data;
	}
	function format_uang($test = "", $mu = "") {
		if ($mu == "")
			$mu = 0;
		if ($test != "") {
			$x = "";
			$y = "";
			$jml = strlen ( $test );
			$sisa = $jml % 3;
			$bagi = ($jml - $sisa) / 3;
			$titik = $bagi - 1;
			$pos = array (
					3,
					6,
					9,
					12,
					15,
					18,
					21,
					24,
					27,
					30,
					33,
					36,
					39,
					42,
					45,
					48,
					51,
					54,
					57,
					60
			);
			$mata = array (
					"",
					"$",
					"¥",
					"£",
					""
			);
			for($i = 0; $i < $jml; $i ++) {
				if ($i == $sisa && $i != 0) {
					$x .= ".";
				} elseif ($i > $sisa) {
					$y += 1;
				}
				for($j = 0; $j < $titik; $j ++) {
					if ($y == $pos [$j]) {
						$x .= ".";
					}
				}
				$x .= substr ( $test, $i, 1 );
			}
			return $mata [$mu] . "  " . $x;
		}
	}
	function UploadFile($folder, $nama_file, $nama_file_old) {
		$_UPLOAD_DIR = $this->basepath ( $folder );
		if ($nama_file_old != "") {
			$x = $_UPLOAD_DIR . $nama_file_old;
			if (file_exists ( $x ))
				unlink ( $x );
		}

		$uploadfile = $_UPLOAD_DIR . basename ( $_FILES [$nama_file] ['name'] );
		if (move_uploaded_file ( $_FILES [$nama_file] ['tmp_name'], $uploadfile )) {
			return true;
		} else {
			return false;
		}
	}
	function HapusFile($folder, $nama_file) {
		$_UPLOAD_DIR = $this->basepath ( $folder );
		if ($nama_file != "") {
			$x = $_UPLOAD_DIR . $nama_file;
			if (file_exists ( $x ))
				unlink ( $x );
		}
	}

	function UploadFileMulti($folder, $nama_file){
		$_UPLOAD_DIR = $this->basepath ( $folder );
		if(isset($_FILES[$nama_file]['tmp_name'])) {
			$num_files = count($_FILES[$nama_file]['tmp_name']);
			for($i=0; $i < $num_files;$i++){
				if(is_uploaded_file($_FILES[$nama_file]['tmp_name'][$i])){
					@copy($_FILES[$nama_file]['tmp_name'][$i],$_UPLOAD_DIR.$_FILES[$nama_file]['name'][$i]);
				}
			}
		}
	}

	function UploadImageFromBase64($folder, $namafile, $base64str){

		$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64str));
		$filepath = $folder."".$namafile;
		file_put_contents($filepath,$data);
		return $filepath;

	}

	function UploadFiles($folder, $filetype, $files){
		$target_dir = $folder;
		$newfilename = "";
		$target_file = "";
		if($filetype == "ktp"){
			$temp = explode(".", $files["media_picktp"]["name"]);
			$newfilename = round(microtime(true)) . '-ktp.' . end($temp);
			$target_file = $target_dir ."/". $newfilename;
		}else if($filetype == "photo"){
			$temp = explode(".", $files["media_picphoto"]["name"]);
			$newfilename = round(microtime(true)) . '-photo.' . end($temp);
			$target_file = $target_dir ."/". $newfilename;
		}else if($filetype == "corporatedoc"){
			$temp = explode(".", $files["media_piccorporatedoc"]["name"]);
			$newfilename = round(microtime(true)) . '-corporatedoc.' . end($temp);
			$target_file = $target_dir ."/". $newfilename;
		}else if($filetype == "beritapositif"){
			$temp = explode(".", $files["news_image"]["name"]);
			$newfilename = round(microtime(true)) . '-beritapositif.' . end($temp);
			$target_file = $target_dir ."/". $newfilename;
		}else if($filetype == "beritanegatif"){
			$temp = explode(".", $files["news_image"]["name"]);
			$newfilename = round(microtime(true)) . '-beritanegatif.' . end($temp);
			$target_file = $target_dir ."/". $newfilename;
		}else if($filetype == "beritaadvertorial"){
			$temp = explode(".", $files["newsimage"]["name"]);
			$newfilename = round(microtime(true)) . '-beritaadvertorial.' . end($temp);
			$target_file = $target_dir ."/". $newfilename;
		}
		
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$data;

		if (!file_exists($folder)) {
		    mkdir($folder, 0777, true);
		}

		// Check if file already exists
		//if (file_exists($target_file)) {
		    //echo "Sorry, file already exists.";
		//    $uploadOk = 0;
		//}
		// Check file size
		/*if ($files["media_picktp"]["size"] > 500000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}*/

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    //echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if($filetype == "ktp"){
				if (move_uploaded_file($files["media_picktp"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $files["media_picktp"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}else if($filetype == "photo"){
				if (move_uploaded_file($files["media_picphoto"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $files["media_picphoto"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}else if($filetype == "corporatedoc"){
				if (move_uploaded_file($files["media_piccorporatedoc"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $files["media_piccorporatedoc"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}else if($filetype == "beritapositif"){
				if (move_uploaded_file($files["news_image"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $files["news_image"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}else if($filetype == "beritanegatif"){
				if (move_uploaded_file($files["news_image"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $files["news_image"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}else if($filetype == "beritaadvertorial"){
				if (move_uploaded_file($files["news_image"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $files["news_image"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
		    
		}

		return $target_file;



	}
}
?>
