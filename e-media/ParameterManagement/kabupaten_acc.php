<script src="js/libs/jquery-1.9.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
var jQuery = $.noConflict(true);
</script>

<script src="js/libs/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/libs/jquery.mask.min.js"></script>
<script src="js/libs/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">

<form name="f" action="#" method="post" id="validation-form" novalidate="novalidate">
<div class="card">
    <div class="card-header">
        <strong><?=$page_title?></strong>
    </div>
    <div class="card-block">
			<?
			switch ($_action) {
				case "getadd" :
			?>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Province</label>
                    <input type="hidden" name="propinsi" id="propinsi"   >
                    <input type="text" name="propinsi_name" id="propinsi_name"  class="form-control" value=<?=@$val_search?>  >
                    <small class="text-muted">Province Name</small>
		            </div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Kabupaten/Kota</label>
		                <input type="text" name="kabupaten" id="kabupaten"  class="form-control" value=<?=@$val_search?> >
		            	<small class="text-muted">Kabupaten/Kota</small>
		            </div>
        		</div>
        	</div>


			<?
				break;
				case "getedit" :
									$arr = $rs->FetchRow ();
			?>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
										<label for="nf-value">Province</label>
										<?=$comfunc->dbCombo("propinsi", "par_propinsi", "propinsi_id", "propinsi_name", " and propinsi_del_st = '1' ", $arr['kabupaten_id_prov'], "form-control", true)?>
									<small class="text-muted">Province Name</small>
								</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
										<label for="nf-value">Kabupaten/Kota</label>
										<input type="text" name="kabupaten" id="kabupaten" class="form-control" value="<?=$arr['kabupaten_name']?>">
									<small class="text-muted">Kabupaten/Kota</small>
								</div>
						</div>
					</div>

					<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Active Status</label>
		                <select name="active_st" id="active_st" class="form-control">
											<option value="0" <?=$arr['active_st'] == '0' ? ' selected="selected"' : '';?>>Not Active</option>
											<option value="1" <?=$arr['active_st'] == '1' ? ' selected="selected"' : '';?>>Active</option>
										</select>
						<small class="text-muted">Show kabupaten on front end</small>

		            </div>
        		</div>
        	</div>


        	<input type="hidden" name="data_id" value="<?=$arr['kabupaten_id']?>">

        	<?
				break;
			}
			?>

			<input type="hidden" name="data_action" id="data_action" value="<?=$_nextaction?>">
    </div>
    <div class="card-footer">
        <button type="reset" class="btn btn-sm btn-primary" onclick="location='<?=$def_page_request?>'"><i class="fa fa-dot-circle-o"></i> Back</button>
       	<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Save</button>
    </div>
</div>
</form>


<script>
jQuery(function($) {
	$("#validation-form").validate({
		rules: {
			kabupaten: "required"
		},
		messages: {
			kabupaten: "Please input Kabupaten/Kota name first"
		},
		submitHandler: function(form) {
			form.submit();
		}
	});

  var availableTags = <?php $method = "province";include('sharedservice.php'); ?>;
   $("#propinsi_name").autocomplete({
       source: availableTags,
       select: function(event, ui) {
					// prevent autocomplete from updating the textbox
					event.preventDefault();
					// manually update the textbox and hidden field
					$(this).val(ui.item.label);
					$("#propinsi").val(ui.item.value);
				}
   });

});
</script>
