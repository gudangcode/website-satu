<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved"><?=$page_title?></h3>
		</header>
		<form method="post" name="f" action="#" class="form-horizontal" id="validation-form">
			<?
			switch ($_action) {
				case "getedit" :
					?>
			<fieldset class="hr">
				<label class="span2">User Name</label>
				<input type="text" class="span2" name="name" id="name" value="<?=$ses_userName?>" readonly>
			</fieldset>
			<fieldset class="hr">
				<label class="span2">Password Lama</label>
				<input type="password" class="span2" name="password_old" id="password_old">
			</fieldset>
			<fieldset class="hr">
				<label class="span2">Password Baru</label>
				<input type="password" class="span2" name="password_new" id="password_new">
			</fieldset>
			<fieldset class="hr">
				<label class="span2">Konfirmasi Password Baru</label>
				<input type="password" class="span2" name="password_confirm_new" id="password_confirm_new">
			</fieldset>
				<input type="hidden" name="cuser_id" id="cuser_id" value="<?=$ses_userId?>">
			<?
					break;
			}
			?>
			<fieldset>
				<center>
					<input type="button" class="blue_btn" value="Kembali" onclick="location='<?=$def_page_request?>'"> &nbsp;&nbsp;&nbsp; 
					<input type="submit" class="blue_btn" value="Simpan">
				</center>
				<input type="hidden" name="data_action" id="data_action" value="<?=$_nextaction?>">
			</fieldset>
		</form>
	</article>
</section>
<script> 
$("#password_old").on('change', function(){
	var pass_old = $(this).val(),
		username = $("#name").val();

	console.log(username+"=="+pass_old);
	$.ajax({
		url: 'UserManagement/ajax.php?data_action=cek_old_pass',
		type: 'POST',
		dataType: 'text',
		data: {username:username, pass_old:pass_old},
		success: function(data) {
			console.log(data);
		}
	});
	
});
			
$(function() {
	
	$("#validation-form").validate({
		rules: {
			name: "required",
			password_old: {
                required: true,
                minlength: 8
            },
			password_new: {
                required: true,
                minlength: 8
            },
			password_confirm_new : {
				minlength : 8,
				equalTo : "#password_new"
			},
			nama_group : "required"
		},
		messages: {
			name: "Silahkan masukan User Name",
            password_old: {
                required: "Silahkan masukan Password",
                minlength: "Min 8 karakter"
            },
            password_new: {
                required: "Silahkan masukan Password",
                minlength: "Min 8 karakter"
            },
			password_confirm_new: {
                minlength: "Min 8 karakter",
				equalTo : "Password tidak cocok"
            },
			nama_group : "Pilih group"
		},		
		submitHandler: function(form) {
			form.submit();
		}
	});
});
</script>