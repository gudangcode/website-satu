<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class risk {
	var $_db;
	var $userId;
	function risk($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	function uniq_id() {
		return $this->_db->uniqid ();
	}
	
	// penetapan tujuan
	function penetapan_count($from = "", $base_on_id_eks="", $key_search, $val_search, $all_field) {
		$condition = "";
		$condition2 = "";
		if ($base_on_id_eks == '0') $base_on_id_eks = "";

		if ($from == 'Audit') $condition .= " and penetapan_status = '2' ";
		if ($base_on_id_eks != '') $condition .= " and auditee_id = '".$base_on_id_eks."' ";
		
		if($val_search!=""){
			if($key_search!="") $condition2 .= " and ".$key_search." like '%".$val_search."%' ";
			else {
				for($i=0;$i<count($all_field);$i++){
					$or = " or ";
					if($i==0) $or = "";
					$condition2 .= $or.$all_field[$i]." like '%".$val_search."%' ";
				}
				$condition2 = " and (".$condition2.")";
			}
		}
		
		$sql = "select count(*) FROM risk_penetapan
				left join auditee on penetapan_auditee_id = auditee_id
				where 1=1 " . $condition.$condition2;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function penetapan_view_grid($from = "", $offset, $num_row, $base_on_id_eks="", $key_search, $val_search, $all_field) {
		$condition = "";
		$condition2 = "";
		if ($base_on_id_eks == '0') $base_on_id_eks = "";

		if ($from == 'Audit') $condition .= " and penetapan_status = '2' ";
		if ($base_on_id_eks != '') $condition .= " and auditee_id = '".$base_on_id_eks."' ";
		
		if($val_search!=""){
			if($key_search!="") $condition2 .= " and ".$key_search." like '%".$val_search."%' ";
			else {
				for($i=0;$i<count($all_field);$i++){
					$or = " or ";
					if($i==0) $or = "";
					$condition2 .= $or.$all_field[$i]." like '%".$val_search."%' ";
				}
				$condition2 = " and (".$condition2.")";
			}
		}
		
		$sql = "select penetapan_id, auditee_name, penetapan_tahun, penetapan_nama, penetapan_tujuan, penetapan_profil_risk, penetapan_profil_risk_residu, penetapan_status
				from risk_penetapan
				left join auditee on penetapan_auditee_id = auditee_id
				where 1=1 " . $condition . $condition2. "
				LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function penetapan_data_viewlist($id) {
		$sql = "select penetapan_id, penetapan_auditee_id, penetapan_tahun, penetapan_nama, penetapan_tujuan, auditee_kode, 
				auditee_name, penetapan_profil_risk, penetapan_profil_risk_residu, case penetapan_status when '1' then 'Sedang Di Reviu' when '2' then 'Di Setujui' when '3' then 'Di Tolak' else 'Belum Diajukan' end as penetapan_status_name, penetapan_status
				FROM risk_penetapan 
				left join auditee on penetapan_auditee_id = auditee_id
				where penetapan_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function penetapan_add($auditee, $tahun, $nama, $tujuan) {
		$sql = "insert into risk_penetapan (penetapan_id, penetapan_auditee_id, penetapan_tahun, penetapan_nama, penetapan_tujuan) 
				values 
				('" . $this->uniq_id () . "','" . $auditee . "','" . $tahun . "','" . $nama . "','" . $tujuan . "')";
		$aksinyo = "Menambah Penetapan Risiko " . $nama;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function penetapan_edit($id, $auditee, $tahun, $nama, $tujuan) {
		$sql = "update risk_penetapan set 
				penetapan_auditee_id = '" . $auditee . "', penetapan_tahun = '" . $tahun . "', penetapan_nama = '" . $nama . "', penetapan_tujuan = '" . $tujuan . "'  
				where penetapan_id = '" . $id . "' ";
		$aksinyo = "Mengubah Penetapan Risiko ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function penetapan_delete($id) {
		$sql = "delete from risk_penetapan where penetapan_id = '" . $id . "' ";
		$aksinyo = "Menghapus Penetapan Risiko ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function update_status_risiko($id, $status) {
		$sql = "update risk_penetapan set 
				penetapan_status = '" . $status . "'  
				where penetapan_id = '" . $id . "' ";
		$aksinyo = "Mengupdate status penetapan Risiko ID " . $id . "menjadi" . $status;
		$this->_db->_dbquery ( $sql, $this->userId, $aksinyo );
	}
	function cek_satker_tahun($id_satker, $tahun, $id="") {
		$condition = "";
		if ($id != "") $condition = " and penetapan_id != '".$id."' ";
		$sql = "select count(*) FROM risk_penetapan where penetapan_auditee_id = '".$id_satker."' and penetapan_tahun = '".$tahun."' ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function risk_add_komentar($id, $komentar, $tanggal) {
		$sql = "insert into risk_penetapan_comment 
				(penetapan_comment_id, penetapan_comment_penetapan_id, penetapan_comment_user_id, penetapan_comment_desc, penetapan_comment_date) 
				values
				('" . $this->uniq_id () . "','" . $id . "','" . $this->userId . "','" . $komentar . "','" . $tanggal . "')";
		$aksinyo = "Mengomentari Penetapan dengan ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function risk_komentar_viewlist($id) {
		$sql = "select pic_name, penetapan_comment_desc, penetapan_comment_date
				FROM risk_penetapan_comment
				left join user_apps on penetapan_comment_user_id = user_id
				left join auditee_pic on user_id_ekternal = pic_id
				where penetapan_comment_penetapan_id = '" . $id . "' order by penetapan_comment_date ASC";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	// end penetapan tujuan
	
	// identifikasi
	function identifikasi_count($penetapan_id, $key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM risk_identifikasi
				left join risk_penetapan on identifikasi_penetapan_id = penetapan_id
				left join par_risk_kategori on identifikasi_kategori_id = risk_kategori_id
				where identifikasi_penetapan_id = '" . $penetapan_id . "' ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function identifikasi_view_grid($penetapan_id, $key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select identifikasi_id, identifikasi_no_risiko, identifikasi_nama_risiko, risk_kategori, identifikasi_penyebab, identifikasi_selera, penetapan_status
				from risk_identifikasi
				left join risk_penetapan on identifikasi_penetapan_id = penetapan_id
				left join par_risk_kategori on identifikasi_kategori_id = risk_kategori_id
				where identifikasi_penetapan_id = '" . $penetapan_id . "' ".$condition."
				LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function identifikasi_data_viewlist($id) {
		$sql = "select identifikasi_id, identifikasi_no_risiko, identifikasi_nama_risiko, identifikasi_kategori_id, identifikasi_penyebab, identifikasi_selera,
				monitoring_action, monitoring_date, monitoring_plan_action, monitoring_tenggat_waktu
				FROM risk_identifikasi where identifikasi_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function identifikasi_add($penetapan_id, $nomor, $nama, $kategori, $penyebab, $selera) {
		$id = $this->uniq_id ();
		$sql = "insert into risk_identifikasi (identifikasi_id, identifikasi_penetapan_id, identifikasi_no_risiko, identifikasi_nama_risiko, identifikasi_kategori_id, identifikasi_penyebab, identifikasi_selera)
				values
				('" . $id . "','" . $penetapan_id . "','" . $nomor . "','" . $nama . "','" . $kategori . "','" . $penyebab . "','" . $selera . "')";
		$aksinyo = "Menambah Identifikasi Risiko id " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function identifikasi_edit($id, $nama, $kategori, $penyebab, $selera) {
		$sql = "update risk_identifikasi set
				identifikasi_nama_risiko = '" . $nama . "', identifikasi_kategori_id = '" . $kategori . "', identifikasi_penyebab = '" . $penyebab . "', identifikasi_selera = '" . $selera . "'
				where identifikasi_id = '" . $id . "' ";
		$aksinyo = "Mengubah Identifikasi Risiko ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function identifikasi_delete($id) {
		$sql = "delete from risk_identifikasi where identifikasi_id = '" . $id . "' ";
		$aksinyo = "Menghapus Identifikasi Risiko ID " . $id;
		$this->_db->_dbexecquery ( $sql, $this->userId, $aksinyo );
	}
	function get_count_identifikasi($penetapan_id) {
		$sql = "select max(right(identifikasi_no_risiko,3)) as count_no_risiko FROM risk_identifikasi 
				where identifikasi_penetapan_id = '" . $penetapan_id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0] + 1;
	}
	function reset_data_risk($ipenetapan) {
		$sql = "update risk_penetapan set
				penetapan_profil_risk = '', penetapan_profil_risk_residu = ''
				where penetapan_id = '" . $ipenetapan . "' ";
		$this->_db->_dbquery ( $sql );
	}
	// end identifikasi
	
	// analisa
	function list_identifikasi($id_kategori, $id_Penetapan, $monitoring="") {
		$condition = "";
		if($monitoring!="") $condition = " and risk_penanganan_status = '1' ";
		$sql = "select identifikasi_id, risk_kategori, identifikasi_no_risiko, identifikasi_nama_risiko, identifikasi_penyebab, identifikasi_selera, 
				analisa_bobot_kat_risk, analisa_ri, analisa_bobot_risk, analisa_kemungkinan, analisa_kemungkinan_name, analisa_dampak, analisa_dampak_name, analisa_nilai_ri,
				evaluasi_risiko_residu, evaluasi_komponen, evaluasi_efektifitas, evaluasi_risiko_residu, evaluasi_efektifitas_name, evaluasi_risiko_residu_name,
				penanganan_risiko_id, penanganan_plan, penanganan_date, penanganan_pic_id, risk_penanganan_jenis, pic_name,
				penetapan_auditee_id,
				monitoring_action, monitoring_date, monitoring_plan_action, monitoring_tenggat_waktu
				FROM risk_identifikasi
				left join risk_penetapan on identifikasi_penetapan_id = penetapan_id
				left join par_risk_kategori on identifikasi_kategori_id = risk_kategori_id
				left join par_risk_penanganan on penanganan_risiko_id = risk_penanganan_id
				left join auditee_pic on penanganan_pic_id = pic_id
				where identifikasi_penetapan_id = '" . $id_Penetapan . "' and identifikasi_kategori_id = '" . $id_kategori . "' ".$condition."  order by risk_kategori, identifikasi_selera";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function list_identifikasi_by_kat($id_Penetapan) {
		$sql = "select identifikasi_kategori_id
				FROM risk_identifikasi
				where identifikasi_penetapan_id = '" . $id_Penetapan . "' group by identifikasi_kategori_id";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function sum_nilai_ri_by_kat($id_kategori, $id_Penetapan) {
		$sql = "select sum(analisa_nilai_ri) as sum_nilai_ri, sum(analisa_bobot_kat_risk) as sum_bobot_kat
				FROM risk_identifikasi
				where identifikasi_penetapan_id = '" . $id_Penetapan . "' and identifikasi_kategori_id = '" . $id_kategori . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function cek_range_ri($value) {
		$sql = "select ri_name, ri_value FROM par_risk_ri where ri_atas >= '" . $value . "' and  ri_bawah <= '" . $value . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function update_analisa($id, $tk, $td, $ri, $tk_name, $td_name, $ri_name, $bobot_ri, $nilai_ri, $bobot_kat_ri) {
		$sql = "update risk_identifikasi set
				analisa_kemungkinan = '" . $tk . "', analisa_dampak = '" . $td . "', analisa_ri = '" . $ri . "', 
				analisa_kemungkinan_name = '" . $tk_name . "', analisa_dampak_name = '" . $td_name . "', analisa_ri_name = '" . $ri_name . "', 
				analisa_bobot_risk  = '" . $bobot_ri . "', analisa_nilai_ri  = '" . $nilai_ri . "', analisa_bobot_kat_risk   = '" . $bobot_kat_ri . "'
				where identifikasi_id = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function update_profil($id, $value) {
		$sql = "update risk_penetapan set
				penetapan_profil_risk = (select ri_name FROM par_risk_ri where ri_atas >= '" . $value . "' and  ri_bawah <= '" . $value . "' )
				where penetapan_id = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function get_nama_risk($nama_table, $field_value, $field_name, $nilai) {
		$sql = "select $field_name FROM $nama_table where $field_value = '" . $nilai . "' "; // echo $sql;
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr [$field_name];
	}
	// end analisa
	
	// evaluasi
	function get_val_rr($value_ri, $value_pi) {
		$sql = "select a.ri_value as nilai_ri
				FROM par_risk_matrix_residu
				left join par_risk_ri as a on matrix_residu_value = a.ri_id
				left join par_risk_ri as b on matrix_residu_ri_id = b.ri_id
				left join par_risk_pi on  matrix_residu_pi_id = pi_id
				where b.ri_value = '" . $value_ri . "' and pi_value = '" . $value_pi . "' ";
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr ['nilai_ri'];
	}
	function sum_kategori_rr($id_kategori, $id_Penetapan) {
		$sql = "select sum(analisa_bobot_risk * evaluasi_risiko_residu / 100 ) * sum(analisa_bobot_kat_risk) / 100 as profil_rr_kat
				from risk_identifikasi
				where identifikasi_penetapan_id = '" . $id_Penetapan . "' and identifikasi_kategori_id = '" . $id_kategori . "' "; 
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr ['profil_rr_kat'];
	}
	function update_evaluasi($id, $komponen, $pi, $pi_name, $rr, $rr_name) {
		$sql = "update risk_identifikasi set
				evaluasi_komponen = '" . $komponen . "', evaluasi_efektifitas = '" . $pi . "', evaluasi_efektifitas_name = '" . $pi_name . "', evaluasi_risiko_residu = '" . $rr . "', evaluasi_risiko_residu_name = '" . $rr_name . "'
				where identifikasi_id = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function cek_range_rr($value) {
		$sql = "select rr_value FROM par_risk_rr where rr_atas >= '" . $value . "' and  rr_bawah < '" . $value . "' ";
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow ();
		return $arr ['rr_value'];
	}
	function update_profil_rr($id, $profil_rr) {
		$sql = "update risk_penetapan set
				penetapan_profil_risk_residu = (select rr_name from par_risk_rr where rr_value = '" . $profil_rr . "')
				where penetapan_id = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	// end evaluasi
	
	// penanganan
	function update_penanganan($id, $pil_penanganan, $penanganan, $date, $pic_id) {
		$sql = "update risk_identifikasi set
				penanganan_risiko_id = '" . $pil_penanganan . "', penanganan_plan = '" . $penanganan . "', penanganan_date = '" . $date . "', penanganan_pic_id = '" . $pic_id . "'
				where identifikasi_id = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function list_penanganan($id_penanganan, $id_penetapan) {
		$sql = "select count(penanganan_risiko_id)
				from risk_identifikasi
				where penanganan_risiko_id = '" . $id_penanganan . "' and identifikasi_penetapan_id = '" . $id_penetapan . "'";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function cek_status_penanganan($id_penanganan) {
		$sql = "select risk_penanganan_status
				from par_risk_penanganan
				where risk_penanganan_id = '" . $id_penanganan . "' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr ['risk_penanganan_status'];
	}
	function cek_penanganan($id_penetapan) {
		$sql = "select count(identifikasi_id)
				from risk_identifikasi
				where identifikasi_penetapan_id = '" . $id_penetapan . "' and penanganan_risiko_id !='' ";
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	
	// end penanganan
	
	// monitoring
	function monitoring_count($penetapan_id, $key_search, $val_search, $all_field) {
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
		$sql = "select count(*) FROM risk_identifikasi
				left join par_risk_kategori on identifikasi_kategori_id = risk_kategori_id
				left join auditee_pic on penanganan_pic_id = pic_id
				left join par_risk_penanganan on penanganan_risiko_id = risk_penanganan_id
				where identifikasi_penetapan_id = '" . $penetapan_id . "' and  	risk_penanganan_status = '1' ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		$arr = $data->FetchRow ();
		return $arr [0];
	}
	function monitoring_view_grid($penetapan_id, $key_search, $val_search, $all_field, $offset, $num_row) {
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
		$sql = "select identifikasi_id, risk_kategori, identifikasi_no_risiko, identifikasi_nama_risiko, evaluasi_risiko_residu_name, penanganan_plan, penanganan_date, pic_name, penetapan_status
				from risk_identifikasi
				left join risk_penetapan on identifikasi_penetapan_id = penetapan_id
				left join par_risk_kategori on identifikasi_kategori_id = risk_kategori_id
				left join auditee_pic on penanganan_pic_id = pic_id
				left join par_risk_penanganan on penanganan_risiko_id = risk_penanganan_id
				where identifikasi_penetapan_id = '" . $penetapan_id . "' and risk_penanganan_status = '1' ".$condition."
				LIMIT $offset, $num_row";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function monitoring_data_viewlist($id) {
		$sql = "select identifikasi_id, identifikasi_no_risiko, identifikasi_nama_risiko, identifikasi_kategori_id, identifikasi_penyebab, identifikasi_selera,
				monitoring_action, monitoring_date, monitoring_plan_action, monitoring_tenggat_waktu, risk_kategori, evaluasi_risiko_residu, penanganan_plan, penanganan_date, pic_name
				FROM risk_identifikasi 
				left join risk_penetapan on identifikasi_penetapan_id = penetapan_id
				left join par_risk_kategori on identifikasi_kategori_id = risk_kategori_id
				left join auditee_pic on penanganan_pic_id = pic_id
				left join par_risk_penanganan on penanganan_risiko_id = risk_penanganan_id
				where identifikasi_id = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function update_monitoring($id, $penanganan_action, $pelaksanaan_date, $penanganan_plan, $tenggat_date) {
		$sql = "update risk_identifikasi set
				monitoring_action = '" . $penanganan_action . "', monitoring_date = '" . $pelaksanaan_date . "', monitoring_plan_action = '" . $penanganan_plan . "', monitoring_tenggat_waktu = '" . $tenggat_date . "'
				where identifikasi_id = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	function insert_attach_monitoring($id, $attach_name) {
		$sql = "insert into risk_identifikasi_attach (iden_attach_id_iden, iden_attach_name) values ('" . $id . "', '" . $attach_name . "')";
		$this->_db->_dbquery ( $sql );
	}
	function list_risk_attach($id) {
		$sql = "select iden_attach_name from risk_identifikasi_attach where iden_attach_id_iden = '" . $id . "' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	// end monitoring
	
	//laporan
	function risk_tahun_viewlist(){
		$sql = "select distinct(penetapan_tahun) from risk_penetapan where penetapan_status = '2' ";
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	function risk_auditee_viewlist($auditee_id=""){
		$condition = "";
		if($auditee_id!="") $condition = "and penetapan_auditee_id = '".$auditee_id."' ";
		$sql = "select distinct penetapan_auditee_id, auditee_name from risk_penetapan
				left join auditee on penetapan_auditee_id = auditee_id
				where penetapan_status = '2' ".$condition;
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	//end laporan
	
	//result
	function update_status_pkat($id) {
		$sql = "update risk_penetapan set
				penetapan_set_pkat = '1'
				where penetapan_id = '" . $id . "' ";
		$this->_db->_dbquery ( $sql );
	}
	//end result
}
?>
