<script src="js/libs/jquery-1.9.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
var jQuery = $.noConflict(true);
</script>

<script src="js/libs/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/libs/jquery.mask.min.js"></script>
<script src="js/libs/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">

<form name="f" action="#" method="post" id="validation-form" novalidate="novalidate" enctype="multipart/form-data"> 
<div class="card">
    <div class="card-header">
        <strong>DATA MEDIA</strong>
    </div>
    <div class="card-block">
			<?
			switch ($_action) {
				case "getadd" :
			?>

			<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Tipe Media</label>
		                <select name="media_type" id="media_type" class="form-control">
							<option value="1">Media Cetak - Surat Kabar Harian</option>
							<option value="2">Media Cetak - Surat Kabar Mingguan</option>
							<option value="3">Media Online - Website Online</option>
							<option value="4">Media Online - Website Streaming</option>
							<option value="5">Media Online - Televisi</option>
						</select>

		            </div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Nama Media</label>
		                <input type="text" name="media_name" id="media_name" class="form-control" value=<?=@$val_search?> >
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Perusahaan Media</label>
		                <input type="text" name="media_company" id="media_company" class="form-control" value=<?=@$val_search?> >
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Email Media</label>
		                <input type="text" name="media_email" id="media_email" class="form-control" value=<?=@$val_search?> >
		            </div>
        		</div>
        	</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Nomor Telepon Media</label>
						<input type="text" name="media_telp" id="media_telp" class="form-control" value=<?=@$val_search?> >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Whatsapp Media</label>
						<input type="text" name="media_whatsapp" id="media_whatsapp" class="form-control" value=<?=@$val_search?> >
					</div>
				</div>
			</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Alamat Media</label>
                    <textarea name="media_address" id="media_address" class="form-control" rows="4" cols="50"></textarea>
		            </div>
        		</div>
        	</div>


			<?
				break;
				case "getedit" :

			?>

			<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Tipe Media</label>
		                <select name="media_type" id="media_type" class="form-control">
							<option value="1" <?=$arr['media_type'] == '1' ? ' selected="selected"' : '';?>>Media Cetak - Surat Kabar Harian</option>
							<option value="2" <?=$arr['media_type'] == '2' ? ' selected="selected"' : '';?>>Media Cetak - Surat Kabar Mingguan</option>
							<option value="3" <?=$arr['media_type'] == '3' ? ' selected="selected"' : '';?>>Media Online - Website Online</option>
							<option value="4" <?=$arr['media_type'] == '4' ? ' selected="selected"' : '';?>>Media Online - Website Streaming</option>
							<option value="5" <?=$arr['media_type'] == '5' ? ' selected="selected"' : '';?>>Media Online - Televisi</option>
						</select>
		            </div>
        		</div>
        	</div>

			<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Nama Media</label>
		                <input type="text" name="media_name" id="media_name" class="form-control" value="<?=$arr['media_name']?>" >
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Perusahaan Media</label>
		                <input type="text" name="media_company" id="media_company" class="form-control" value="<?=$arr['media_company']?>" >
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Email Media</label>
		                <input type="text" name="media_email" id="media_email" class="form-control" value="<?=$arr['media_email']?>" >
		            </div>
        		</div>
        	</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Nomor Telepon Media</label>
						<input type="text" name="media_telp" id="media_telp" class="form-control" value="<?=$arr['media_telp']?>" >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Whatsapp Media</label>
						<input type="text" name="media_whatsapp" id="media_whatsapp" class="form-control" value="<?=$arr['media_whatsapp']?>" >
					</div>
				</div>
			</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Alamat Media</label>
                    <textarea name="media_address" id="media_address" class="form-control" rows="4" cols="50"><?=$arr['media_address']?></textarea>
                    </div>
        		</div>
        	</div>

        	<?
				break;
			}
			?>

			
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>PENANGGUNG JAWAB WILAYAH</strong>
    </div>
    <div class="card-block">
			<?
			switch ($_action) {
				case "getadd" :
			?>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Nama Penanggung Jawab</label>
		                <input type="text" name="media_picname" id="media_picname" class="form-control" value=<?=@$val_search?> >
		            	
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">NIK Penanggung Jawab</label>
		                <input type="text" name="media_picnik" id="media_picnik" class="form-control" value=<?=@$val_search?> >
		            </div>
        		</div>
        	</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Alamat Penanggung Jawab</label>
					<textarea name="media_picaddress" id="media_picaddress" class="form-control" rows="4" cols="50"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">KTP</label>
						<input type="file" name="media_picktp" id="media_picktp" class="form-control"    >
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Foto</label>
						<input type="file" name="media_picphoto" id="media_picphoto" class="form-control"    >
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Dokumen Perusahaan</label>
						<input type="file" name="media_piccorporatedoc" id="media_piccorporatedoc" class="form-control"   >
					</div>
				</div>
			</div>

			<?
				break;
				case "getedit" :

			?>

			<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Nama Penanggung Jawab</label>
		                <input type="text" name="media_picname" id="media_picname" class="form-control" value="<?=$arr['media_picname']?>"  >
		            </div>
        		</div>
        	</div>

          	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">NIK Penanggung Jawab</label>
		                <input type="text" name="media_picnik" id="media_picnik" class="form-control" value="<?=$arr['media_picnik']?>" >
		            </div>
        		</div>
        	</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Alamat Penanggung Jawab</label>
					<textarea name="media_picaddress" id="media_picaddress" class="form-control" rows="4" cols="50"><?=$arr['media_picaddress']?></textarea>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">KTP</label>
						<input type="file" name="media_picktp" id="media_picktp" class="form-control" value="<?=$arr['media_picktp']?>"   >
						
		            	<small class="text-muted"><a href="<?=$arr["media_picktp"]?>" target="_blank">Unduh</a></small>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Foto</label>
						<input type="file" name="media_picphoto" id="media_picphoto" class="form-control" value="<?=$arr['media_picphoto']?>"   >
						<small class="text-muted"><a href="<?=$arr["media_picphoto"]?>"  target="_blank">Unduh</a></small>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Dokumen Perusahaan</label>
						<input type="file" name="media_piccorporatedoc" id="media_piccorporatedoc" class="form-control" value="<?=$arr['media_piccorporatedoc']?>"   >
						<small class="text-muted"><a href="<?=$arr["media_piccorporatedoc"]?>" target="_blank">Unduh</a></small>
					</div>
				</div>
			</div>

        	<input type="hidden" name="data_id" value="<?=$arr['media_id']?>">

        	<?
				break;
			}
			?>

			<input type="hidden" name="data_action" id="data_action" value="<?=$_nextaction?>">
    </div>
    <div class="card-footer">
        <button type="reset" class="btn btn-sm btn-primary" onclick="location='<?=$def_page_request?>'"><i class="fa fa-dot-circle-o"></i> Kembali</button>
       	<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Simpan</button>
    </div>
</div>
</form>


<script>
jQuery(function($) {
	$("#validation-form").validate({
		rules: {
			media_name: "required",
			media_address: "required",
      kabupaten_id: "required"
		},
		messages: {
			media_name: "Please input Nama Media first",
			media_address: "Please input Media Address first"
		},
		submitHandler: function(form) {
			form.submit();
		}
	});


});

</script>
