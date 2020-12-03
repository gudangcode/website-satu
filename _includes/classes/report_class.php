<?php
if (@$position == 1) {
	include_once "_includes/DB.class.php";
} else {
	include_once "../_includes/DB.class.php";
}
class report {
	var $_db;
	var $userId;
	function report($userId = "") {
		$this->_db = new db ();
		$this->userId = $userId;
	}
	
	function report_siklus_risiko($kategori_id, $tahun, $auditee) {
		$condition = "";
		if($auditee!="") $condition = "and penetapan_auditee_id = '" . $auditee . "'";
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
				where penetapan_status = '2' and identifikasi_kategori_id = '".$kategori_id."' and penetapan_tahun = '".$tahun."' ".$condition; 
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function get_assignment_id($auditee_id, $tahun) {
		$sql = "select assign_id
				FROM assignment
				join assignment_auditee on assign_id = assign_auditee_id_assign 
				where assign_auditee_id_auditee = '".$auditee_id."' and assign_tahun = '".$tahun."' "; 
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow();
		return $arr[0];
	}
	
	function get_katim($assign_id, $auditee_id) {
		$sql = "select auditor_name
				FROM assignment_auditor
				join auditor on assign_auditor_id_auditor = auditor_id 
				where assign_auditor_id_assign = '".$assign_id."' and assign_auditor_id_auditee = '".$auditee_id."' "; 
		$rs = $this->_db->_dbquery ( $sql );
		$arr = $rs->FetchRow();
		return $arr[0];
	}
	
	function assign_program_audit_list($assign_id, $auditee_id) {
		$sql = "select program_id, program_day, ref_program_tao, auditor_name, assign_tujuan, ref_program_procedure
				FROM program_audit
				left join assignment on program_id_assign = assign_id
				left join ref_program_audit on program_id_ref = ref_program_id
				left join auditor on program_id_auditor = auditor_id
				where program_id_assign = '".$assign_id."' and program_id_auditee = '".$auditee_id."' "; 
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function program_kka_list($program_id) {
		$sql = "select kertas_kerja_no
				FROM kertas_kerja
				where kertas_kerja_id_program = '".$program_id."' "; 
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function kertas_kerja_list($assign_id, $auditee_id) {
		$sql = "select kertas_kerja_id, kertas_kerja_no, kertas_kerja_desc, kertas_kerja_kesimpulan, auditor_name, ref_program_title
				FROM kertas_kerja
				left join program_audit on kertas_kerja_id_program = program_id
				left join ref_program_audit on program_id_ref  = ref_program_id
				left join auditor on program_id_auditor = auditor_id
				where program_id_assign = '".$assign_id."' and program_id_auditee = '".$auditee_id."' "; 
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function assign_list($assign_id) {
		$sql = "select assign_id, assign_no, assign_no_lha, assign_date_lha, assign_periode, lha_ringkasan, assign_dasar, lha_metodologi, assign_tujuan, lha_sasaran, lha_ruanglingkup, lha_batasan, lha_kegiatan, assign_start_date, assign_end_date, lha_informasi, lha_hasil, lha_status
				FROM assignment
				join assignment_lha on assign_id = lha_id_assign
				where assign_id = '".$assign_id."' "; 
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function temuan_list($assign_id, $auditee_id) {
		$sql = "select finding_id, finding_judul, finding_kondisi, finding_kriteria, finding_sebab, finding_akibat, finding_tanggapan_auditee, finding_tanggapan_auditor
				FROM finding_internal
				where finding_assign_id = '".$assign_id."' and finding_auditee_id = '".$auditee_id."' "; 
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function rekomendasi_list($finding_id) {
		$sql = "select rekomendasi_id, rekomendasi_desc
				FROM rekomendasi_internal
				where rekomendasi_finding_id = '".$finding_id."' "; 
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function tindak_lanjut_list($finding_id) {
		$sql = "select tl_desc
				FROM tindaklanjut_internal
				left join rekomendasi_internal on rekomendasi_id = tl_rek_id
				where rekomendasi_finding_id = '".$finding_id."' "; 
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
	
	function plan_data_viewlist($tahun, $inspektorat) {
		$sql = "select audit_plan_id, audit_plan_start_date, audit_plan_end_date
				FROM audit_plan
				where audit_plan_tahun = '".$tahun."' and audit_plan_pelaksana_id = '".$inspektorat."' "; 
		$data = $this->_db->_dbquery ( $sql );
		return $data;
	}
}
?>
