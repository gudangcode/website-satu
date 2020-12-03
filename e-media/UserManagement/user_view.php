<div class="card card-outline-primary">
    <div class="card-header">
        <strong><?=$page_title?></strong>
    </div>
    <div class="card-block">
        <form name="f" action="#" method="post">
        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-key">Key Search</label>
		                <select name="key_search" class="form-control">
							<?
							if(count($key_by)!=1)
							?>
							<option value="">Choose All</option>
							<?php 
							for($i=0;$i<count($key_by);$i++){
							?>
								<option value="<?=$key_field[$i]?>" <? if(@$key_search==$key_field[$i]) echo "selected";?>><?=$key_by[$i]?></option>
							<?php
							}
							?>
						</select>
                        <span class="help-block">Please enter field for search</span>
		            </div>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-sm-12">
        			<div class="form-group">
		                <label for="nf-value">Value Search</label>
		                <input type="text" name="val_search" id="val_search" class="form-control" value=<?=@$val_search?> >
                        <span class="help-block">Please enter value for search</span>
		            </div>
        		</div>
        	</div>
            
            
			<input type="hidden" value="" name="data_action" id="data_action">
			<input type="hidden" value="" name="data_id" id="data_id">
        </form>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-sm btn-primary" onclick="set_action('');"><i class="fa fa-dot-circle-o"></i> Search</button>
        <button type="reset" class="btn btn-sm btn-success" onclick="set_action('getadd');"><i class="fa fa-plus"></i> Add New</button>
    </div>
</div>

 	
<?
include_once $grid;
?>   
	