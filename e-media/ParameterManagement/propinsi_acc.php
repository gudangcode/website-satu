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
		                <label for="nf-value">Province Name</label>
		                <input type="text" name="name" id="name" class="form-control" value=<?=@$val_search?> >
		            	<small class="text-muted">Province Name</small>
		            </div>
        		</div>
        	</div>

			<?
				break;
				case "getedit" :
					$arr = $rs->FetchRow();
			?>

					<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Province Name</label>
		                <input type="text" name="name" id="name" class="form-control" value="<?=$arr['propinsi_name']?>" >
		            	<small class="text-muted">Province Name</small>
		            </div>
        		</div>
        	</div>


        	<input type="hidden" name="data_id" value="<?=$arr['propinsi_id']?>">

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
			name: "required"
		},
		messages: {
			name: "Please input name first"
		},
		submitHandler: function(form) {
			form.submit();
		}
	});
});
</script>
