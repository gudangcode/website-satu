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
        <strong>DATA PRODUK</strong>
    </div>
    <div class="card-block">
			<?
			switch ($_action) {
				case "getadd" :
			?>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Nama Produk</label>
		                <input type="text" name="product_name" id="product_name" class="form-control" value=<?=@$val_search?> >
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Satuan</label>
		                <?=$comfunc->dbCombo("product_uom", "master_parameterlevel1", "parameter_value", "parameter_value", "and parameter_key = 'SYSTEM.PARAMETER.UOM' and status_active = 1 ", "", "form-control", 1)?>
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Harga Produk</label>
		                <input type="text" name="product_price" id="product_price" class="form-control" value=<?=@$val_search?> >
		            </div>
        		</div>
        	</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Media</label>
						<?=$comfunc->dbCombo("media_id", "master_media", "media_id", "media_name", "  ", "", "form-control", 1)?>
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
		                <label for="nf-value">Nama Produk</label>
		                <input type="text" name="product_name" id="product_name" class="form-control" value="<?=$arr['product_name']?>" >
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Satuan</label>
		                <?=$comfunc->dbCombo("product_uom", "master_parameterlevel1", "parameter_value", "parameter_value", "and parameter_key = 'SYSTEM.PARAMETER.UOM' and status_active = 1 ", $arr["product_uom"], "form-control", 1)?>
		            </div>
        		</div>
        	</div>

          <div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Harga Produk</label>
		                <input type="text" name="product_price" id="product_price" class="form-control" value="<?=$arr['product_price']?>" >
		            </div>
        		</div>
        	</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Media</label>
						<?=$comfunc->dbCombo("media_id", "master_media", "media_id", "media_name", " ", $arr["media_id"], "form-control", 1)?>
					</div>
				</div>
			</div>

			<input type="hidden" name="data_id" value="<?=$arr['product_id']?>">


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
	$('#product_price').mask('000.000.000.000.000', {reverse: true});

});
</script>
