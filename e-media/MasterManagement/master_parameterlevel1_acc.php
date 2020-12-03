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
		                <label for="nf-value">Parameter Key</label>
		                <input type="text" name="parameter_key" id="parameter_key" class="form-control" value=<?=@$val_search?> >
		            	<small class="text-muted">Key of Parameter</small>
		            </div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Parameter Value</label>
                    <input type="text" name="parameter_value" id="parameter_value" class="form-control" value=<?=@$val_search?> >
                    <small class="text-muted">Value Parameter</small>
		            </div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Status Active</label>
		                <select name="status_active" id="status_active" class="form-control">
							<option value="0">Inactive</option>
							<option value="1">Active </option>
						</select>
						<small class="text-muted">Status Active of Parameter</small>

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
                    <label for="nf-value">Parameter Key</label>
                    <input type="text" name="parameter_key" id="parameter_key" value="<?=$arr['parameter_key']?>" class="form-control" readonly="true" >
                  <small class="text-muted">Key of Parameter</small>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                    <label for="nf-value">Parameter Value</label>
                    <input type="text" name="parameter_value" id="parameter_value" value="<?=$arr['parameter_value']?>" class="form-control" value=<?=@$val_search?> >
                  <small class="text-muted">Value of Parameter</small>
                </div>
            </div>
          </div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Status Active</label>
		                <select name="status_active" id="status_active" class="form-control">
							<option value="0" <?=$arr['status_active'] == '0' ? ' selected="selected"' : '';?>>Inactive</option>
							<option value="1" <?=$arr['status_active'] == '1' ? ' selected="selected"' : '';?>>Active</option>
						</select>
						<small class="text-muted">Status Active of Parameter</small>

		            </div>
        		</div>
        	</div>

        	<input type="hidden" name="data_id" value="<?=$arr['parameter_id']?>">

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
			parameter_key: "required",
			parameter_value: "required"
		},
		messages: {
			parameter_key: "Please input Parameter Key first",
			parameter_value: "Please input Parameter Value first"
		},
		submitHandler: function(form) {
			form.submit();
		}
	});

});
</script>
