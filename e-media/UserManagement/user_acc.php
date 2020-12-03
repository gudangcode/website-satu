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
		                <label for="nf-value">Username</label>
		                <input type="text" name="name" id="name" class="form-control" >
		            	<small class="text-muted">Username of User</small>
		            </div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Password</label>
		                <input type="password" name="password" id="password" class="form-control" >
		            	<small class="text-muted">Password of User</small>
		            </div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Confirm Password</label>
		                <input type="password" name="password_confirm" id="password_confirm" class="form-control" >
		            	<small class="text-muted">Password Confirmation of User</small>
		            </div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Group</label>
		                <?=$comfunc->dbCombo("nama_group", "par_group", "group_id", "group_name", "and group_del_st = 1 ", "", "form-control", 1)?>
		            	<small class="text-muted">Group of User</small>
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
		                <label for="nf-value">Username</label>
		                <input type="text" name="name" id="name" class="form-control" value="<?=$arr['user_username']?>">
		            	<small class="text-muted">Username of User</small>
		            </div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Password</label>
		                <input type="password" name="password" id="password" class="form-control" >
		            	<small class="text-muted">Password of User</small>
		            </div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Confirm Password</label>
		                <input type="password" name="password_confirm" id="password_confirm" class="form-control" >
		            	<small class="text-muted">Password Confirmation of User</small>
		            </div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Group</label>
		                <?=$comfunc->dbCombo("nama_group", "par_group", "group_id", "group_name", "and group_del_st = 1 ", $arr['user_id_group'], "form-control", 1)?>
		            	<small class="text-muted">Group of User</small>
		            </div>
        		</div>
        	</div>

        	<input type="hidden" name="data_id" value="<?=$arr['user_id']?>">

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
			name: "required",
			password: {
                required: true,
                minlength: 8
            },
			password_confirm : {
				minlength : 8,
				equalTo : "#password"
			},
			nama_group : "required"
		},
		messages: {
			name: "Silahkan masukan User Name",
            password: {
                required: "Silahkan masukan Password",
                minlength: "Min 8 karakter"
            },
			password_confirm: {
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
