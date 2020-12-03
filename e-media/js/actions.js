function set_action(acc, id, name){
	if(acc!=""){
		if(acc=="getdelete"){
			if (confirm("Are you sure want to delete data "+name+" ?")==false){
				return false;
			}
		} else if(acc=="getKill"){
			if (confirm("Are you sure want to kill Session User "+name+" ?")==false){
				return false;
			}
		} else if(acc=="getInActive"){
			if (confirm("Are you sure want to inactive user "+name+" ?")==false){
				return false;
			}
		} else if(acc=="getajukan"){
			if(name==1) {
				if (confirm("Anda Yakin Untuk Mengajukan Perencanaan Audit?")==false){
					return false;
				}
			}
			document.getElementById('status_plan').value=name;
		} else if(acc=="getapprove"){
			if(name==3) var text = "Anda Yakin Menolak Perencanaan Audit?";
			if(name==2) var text = "Anda Yakin Untuk Menyetujui Perencanaan Audit?";
			if (confirm(text)==false){
				return false;
			}
			document.getElementById('status_plan').value=name;
		} else if(acc=="getajukan_penugasan"){
			if(name==1) {
				if (confirm("Anda Yakin Untuk Mengajukan Penugasan?")==false){
					return false;
				}
			}
			document.getElementById('status_penugasan').value=name;
		} else if(acc=="getapprove_penugasan"){
			if(name==4) var text = "Anda Yakin Menolak Penugasan?";
			if(name==2) var text = "Anda Yakin Untuk Menyetujui Penugasan?";
			if (confirm(text)==false){
				return false;
			}
			document.getElementById('status_penugasan').value=name;
		} else if(acc=="getajukan_kka"){
			if(name==1) {
				if (confirm("Anda Yakin Untuk Mengajukan KKA?")==false){
					return false;
				}
			}
			document.getElementById('status_kka').value=name;
		} else if(acc=="getapprove_kka"){
			if(name==2) var text = "Anda Yakin Untuk Menyetujui KKA?";
			if(name==3) var text = "Anda Yakin Untuk Menyetujui KKA?";
			if(name==4) var text = "Anda Yakin Untuk Menyetujui KKA?";
			if(name==5) var text = "Anda Yakin Menolak KKA?";
			if(name==6) var text = "Anda Yakin Menolak KKA?";
			if(name==7) var text = "Anda Yakin Menolak KKA?";
			if (confirm(text)==false){
				return false;
			}
			document.getElementById('status_kka').value=name;
		} else if(acc=="getajukan_temuan"){
			if(name==1) {
				if (confirm("Anda Yakin Untuk Mengajukan Temuan?")==false){
					return false;
				}
			}
			document.getElementById('status_temuan').value=name;
		} else if(acc=="getapprove_temuan"){
			if(name==2) var text = "Anda Yakin Untuk Menyetujui Temuan?";
			if(name==3) var text = "Anda Yakin Untuk Menyetujui Temuan?";
			if(name==4) var text = "Anda Yakin Untuk Menyetujui Temuan?";
			if(name==5) var text = "Anda Yakin Menolak Temuan?";
			if(name==6) var text = "Anda Yakin Menolak Temuan?";
			if(name==7) var text = "Anda Yakin Menolak Temuan?";
			if (confirm(text)==false){
				return false;
			}
			document.getElementById('status_temuan').value=name;
		} else if(acc=="getajukan_tl"){
			if(name==1) {
				if (confirm("Anda Yakin Untuk Mengajukan Tindak Lanjut?")==false){
					return false;
				}
			}
			document.getElementById('status_tl').value=name;
		} else if(acc=="getapprove_tl"){
			if(name==2) var text = "Anda Yakin Untuk Menyetujui Tindak Lanjut Satuan Kerja?";
			if(name==3) var text = "Anda Yakin Menolak Tindak Lanjut Satuan Kerja?";
			if (confirm(text)==false){
				return false;
			}
			document.getElementById('status_tl').value=name;
		} else if(acc=="restore_database"){
			if (confirm("Anda Yakin Untuk Restore Database per "+name+"?")==false){
				return false;
			}
		}
		document.getElementById('data_action').value=acc;
		document.getElementById('data_id').value=id;

		document.f.submit();
	}else{

		document.getElementById('data_action').value=acc;
		document.getElementById('data_id').value=id;



		document.f.submit();
	}
}


function setfinishprocess(val){
  $("#finishprocess").val(val);
  $("#validation-form").submit();
}
