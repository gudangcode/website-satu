<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved"><?=$page_title?></h3>
		</header>
		<form method="post" name="f" action="#" class="form-horizontal"
			id="validation-form">
		<?
		switch ($_action) {
			case "getadd" :
				?>
			<fieldset class="hr">
				<label class="span1">Nama Menu</label> <input type="text"
					class="span2" name="name" id="name">
			</fieldset>
			<fieldset class="hr">
				<label class="span1">Link</label> <input type="text" class="span5"
					name="link" id="link">
			</fieldset>
			<fieldset class="hr">
				<label class="span1">Method</label> <input type="text" class="span2"
					name="method" id="method">
			</fieldset>
			<fieldset class="hr">
				<label class="span1">Nama File</label> <input type="text"
					class="span3" name="file" id="file">
			</fieldset>
			<fieldset class="hr">
				<label class="span1">Sort</label> <input type="text" class="span0"
					name="sort" id="sort">
			</fieldset>
			<fieldset class="hr">
				<label class="span1">Status</label> <select name="status">
					<option value="">Pilih Satu</option>
					<option value="1">Show</option>
					<option value="0">Hidden</option>
				</select>
			</fieldset>
			<input type="hidden" name="parrent_id" value="<?=$parrent?>">	
		<?
				break;
			case "getedit" :
				$arr = $rs->FetchRow ();
				?>
			<fieldset class="hr">
				<label class="span1">Nama Menu</label> <input type="text"
					class="span2" name="name" id="name" value="<?=$arr['menu_name']?>">
			</fieldset>
			<fieldset class="hr">
				<label class="span1">Link</label> <input type="text" class="span5"
					name="link" id="link" value="<?=$arr['menu_link']?>">
			</fieldset>
			<fieldset class="hr">
				<label class="span1">Method</label> <input type="text" class="span2"
					name="method" id="method" value="<?=$arr['menu_method']?>">
			</fieldset>
			<fieldset class="hr">
				<label class="span1">Nama File</label> <input type="text"
					class="span3" name="file" id="file" value="<?=$arr['menu_file']?>">
			</fieldset>
			<fieldset class="hr">
				<label class="span1">Sort</label> <input type="text" class="span0"
					name="sort" id="sort" value="<?=$arr['menu_sort']?>">
			</fieldset>
			<fieldset class="hr">
				<label class="span1">Status</label> <select name="status">
					<option value="">Pilih Satu</option>
					<option value="1" <?php if($arr['menu_show']==1) echo "selected";?>>Show</option>
					<option value="0" <?php if($arr['menu_show']==0) echo "selected";?>>Hidden</option>
				</select>
			</fieldset>
			<input type="hidden" name="data_id" value="<?=$arr['menu_id']?>">	
		<?
				break;
		}
		?>
			<fieldset>
				<center>
					<input type="button" class="blue_btn" value="Kembali"
						onclick="location='<?=$def_page_request?>'"> &nbsp;&nbsp;&nbsp; <input
						type="submit" class="blue_btn" value="Simpan">
				</center>
				<input type="hidden" name="data_action" id="data_action"
					value="<?=$_nextaction?>">
			</fieldset>
		</form>
	</article>
</section>
<script>  
$(function() {
	$("#validation-form").validate({
		rules: {
			name: "required",
			link: "required",
			method: "required",
			file: "required",
			sort: "required",
			status: "required"
		},
		messages: {
			name: "Masukan Nama Menu",
			link: "Masukan Link Menu",
			method: "Masukan Nama Method",
			file: "Masukan Nama File",
			sort: "Masukan Urutan Menu",
			status: "Pilih Status Menu"
		},		
		submitHandler: function(form) {
			form.submit();
		}
	});
});
</script>