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
        <strong>DATA BERITA POSITIF</strong>
    </div>
    <div class="card-block">
			<?
			switch ($_action) {
				case "getadd" :
			?>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Media</label>
						<?=$comfunc->dbCombo("media_id", "master_media", "media_id", "media_name", "  ", "", "form-control", 1)?>
					</div>
				</div>
			</div>
			

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Judul Berita</label>
		                <input type="text" name="news_title" id="news_title" class="form-control" value=<?=@$val_search?> >
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Tanggal Terbit/Tayang</label>
		                <input type="text" name="news_broadcastdate" id="news_broadcastdate" readonly="true"  class="form-control" value=<?=@$val_search?> >
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Halaman</label>
		                <input type="text" name="news_page" id="news_page" class="form-control" value=<?=@$val_search?> >
		            </div>
        		</div>
        	</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Ukuran</label>
						<input type="text" name="news_size" id="news_size" class="form-control" value=<?=@$val_search?> >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Penulis</label>
						<input type="text" name="news_writer" id="news_writer" class="form-control" value=<?=@$val_search?> >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Gambar (Media Cetak)</label>
						<input type="file" name="news_image" id="news_image" class="form-control"    >
						
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">URL/Link Berita (Media Online)</label>
						<input type="text" name="news_url" id="news_url" class="form-control" value=<?=@$val_search?> >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Poin</label>
						<input type="text" name="news_point" id="news_point" class="form-control" value=<?=@$val_search?> >
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
						<label for="nf-value">Media</label>
						<?=$comfunc->dbCombo("media_id", "master_media", "media_id", "media_name", " ", $arr["media_id"], "form-control", 1)?>
					</div>
				</div>
			</div>
			

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Judul Berita</label>
		                <input type="text" name="news_title" id="news_title" class="form-control" value="<?=$arr['news_title']?>" >
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Tanggal Terbit/Tayang</label>
		                <input type="text" name="news_broadcastdate" id="news_broadcastdate" readonly="true"  class="form-control" value="<?=$arr['news_broadcastdate']?>" >
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Halaman</label>
		                <input type="text" name="news_page" id="news_page" class="form-control" value="<?=$arr['news_page']?>" >
		            </div>
        		</div>
        	</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Ukuran</label>
						<input type="text" name="news_size" id="news_size" class="form-control" value="<?=$arr['news_size']?>" >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Penulis</label>
						<input type="text" name="news_writer" id="news_writer" class="form-control" value="<?=$arr['news_writer']?>" >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Gambar (Media Cetak)</label>
						<input type="file" name="news_image" id="news_image" class="form-control"  value="<?=$arr['news_image']?>">
						
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">URL/Link Berita (Media Online)</label>
						<input type="text" name="news_url" id="news_url" class="form-control" value="<?=$arr["news_url"]?>" >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Poin</label>
						<input type="text" name="news_point" id="news_point" class="form-control" value="<?=$arr['news_point']?>" >
					</div>
				</div>
			</div>


        	<input type="hidden" name="data_id" value="<?=$arr['news_id']?>">


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

	$("#news_broadcastdate").datepicker({
		 changeMonth: true,
		 changeYear: true,
		 dateFormat: "yy-mm-dd" 
	});

});
</script>
