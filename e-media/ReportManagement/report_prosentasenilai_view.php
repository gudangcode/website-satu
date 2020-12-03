<script src="js/libs/jquery-1.9.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
var jQuery = $.noConflict(true);
</script>

<script src="js/libs/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/libs/jquery.mask.min.js"></script>
<script src="js/libs/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">

<div class="card card-outline-primary">
    <div class="card-header">
        <strong><?=$page_title?></strong>
    </div>
    <div class="card-block">
        <form name="f" action="#" method="post">
        	
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="nf-value">Media</label>
						<?=$comfunc->dbCombo("media", "master_media", "media_id", "media_name", "  ", @$media, "form-control", 1)?>
					</div>
				</div>
			</div>

			<div class="row">
        		<div class="col-sm-2">
        			<div class="form-group">
		                <label for="nf-value"> Tanggal</label>
		                <input type="text" name="date1" id="date1" class="form-control" value="<?=@$date1?>" autocomplete="off" >
		            </div>
        		</div>
				<div class="col-sm-1">
					<div class="form-group">
		                <br><br>Hingga
		            </div>
        		</div>
				<div class="col-sm-4">
        			<div class="form-group">
		                <label for="nf-value">Tanggal</label>
		                <input type="text" name="date2" id="date2" class="form-control" value="<?=@$date2?>" autocomplete="off" >
		            </div>
        		</div>
        	</div>

			<?
			if(!isset($_SESSION['date1'])){
			?>
				<div class="row">
					<div class="col-sm-12">
						<strong style="color: red;">Pilih rentang tanggal terlebih dahulu</strong>
					</div>
				</div>
			<?
			}else{
				if($_SESSION['date1'] == "" || $_SESSION['date2'] == ""){
				?>
					<div class="row">
						<div class="col-sm-12">
							<strong style="color: red;">Pilih rentang tanggal terlebih dahulu</strong>
						</div>
					</div>
				<?
				}
			}
			?>
            
            
			<input type="hidden" value="" name="data_action" id="data_action">
			<input type="hidden" value="" name="data_id" id="data_id">
        </form>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-sm btn-primary" onclick="set_action('');"><i class="fa fa-dot-circle-o"></i> Cari</button>
    </div>
</div>

 	

<div class="animated fadeIn">
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-primary">
			<div class="card-header">
				<i class="fa fa-align-justify"></i> <?=$page_title?>
			</div>
			<div class="card-block" style="overflow-x: auto;">
				<table class="table table-bordered table-striped table-condensed">
					<thead>
					<tr>
							<th  rowspan="2" style="vertical-align: middle; text-align:center; background-color: #20a8d8; color: white;">No</th>
							<th  rowspan="2" style="vertical-align: middle; text-align:center; background-color: #20a8d8; color: white;">Nama Media</th>
							<th  rowspan="2" style="vertical-align: middle; text-align:center; background-color: #20a8d8; color: white;">Penanggung Jawab Wilayah</th>
							<th  colspan="3" style="vertical-align: middle; text-align:center; background-color: #20a8d8; color: white;">Publikasi Berita</th>
							<th  rowspan="2" style="vertical-align: middle; text-align:center; background-color: #20a8d8; color: white;">Prosentase</th>
						</tr>
						<tr>
							<th style="vertical-align: middle; text-align:center; background-color: #20a8d8; color: white;">Nilai Positif</th>
							<th style="vertical-align: middle; text-align:center; background-color: #20a8d8; color: white;">Nilai Negatif</th>
							<th style="vertical-align: middle; text-align:center; background-color: #20a8d8; color: white;">Nilai Advertorial</th>
						</tr>
						
					</thead>
					<tbody>
						<tr>
								<?
								if ($recordcount != 0) {
									$i = 0;
									while ( $arr = $rs->FetchRow () ) {
										$i ++;
										?>
								<tr>
									<td><?=$i+$offset?></td>
								<?
										for($j = 0; $j < count ( $gridDetail ); $j ++) {
												if ($gridHeader [$j] == "Nilai Positif") {
												?>
									<td style="vertical-align: middle; text-align:center;"><?=$arr[$gridDetail[$j]]?></td>
								<?
											} else if ($gridHeader [$j] == "Nilai Negatif") {
												?>
									<td style="vertical-align: middle; text-align:center;"><?=$arr[$gridDetail[$j]]?></td>
								<?
											} else if ($gridHeader [$j] == "Nilai Advertorial") {
												?>
									<td style="vertical-align: middle; text-align:center;"><?=$arr[$gridDetail[$j]]?></td>
								<?
											} else if ($gridHeader [$j] == "Prosentase") {
												if($arr[$gridDetail[$j]] > 50){
												?>
													<td style="vertical-align: middle; text-align:center; font-weight: bold; color: green;"><?=$arr[$gridDetail[$j]]?></td>
												<?
												}else if($arr[$gridDetail[$j]] < 50){
												?>
													<td style="vertical-align: middle; text-align:center; font-weight: bold; color: red;"><?=$arr[$gridDetail[$j]]?></td>
												<?
												}else{
												?>
													<td style="vertical-align: middle; text-align:center; font-weight: bold;"><?=$arr[$gridDetail[$j]]?></td>
												<?
												}
												
											} else {?>
							
									<td><?=$arr[$gridDetail[$j]]?></td>
								<?
											}
										}
									}?>
										
									</td>
								</tr>
								<?
								} else {
									?>
									<td colspan="7">Tidak ada Data</td>
								<?
								}
								?>
						</tr>

					</tbody>
				</table>
				<ul class="pagination">
					<?
						$showPage = "";
						$jumPage = ceil ( $recordcount / $num_row );
						if ($noPage > 1)
							echo "<li class=\"page-item\"> <a class=\"page-link\" href='" . $paging_request . "&page=" . ($noPage - 1) . "'> < </a></li>";
						for($page = 1; $page <= $jumPage; $page ++) {
							if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)) {
								if (($showPage == 1) && ($page != 2))
									//echo "<li class=\"page-item\">...</li>";
								if (($showPage != ($jumPage - 1)) && ($page == $jumPage))
									echo "<li class=\"page-item\">...</li>";
								if ($page == $noPage)
									echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">".$page."</a></li>";
								else
									echo "<li class=\"page-item\"> <a class=\"page-link\" href='" . $paging_request . "&page=" . $page . "'>" . $page . "</a></li>";
								$showPage = $page;
							}
						}
						if ($noPage < $jumPage)
							echo "<li class=\"page-item\"> <a class=\"page-link\" href='" . $paging_request . "&page=" . ($noPage + 1)  . "'> > </a></li>";
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
</div>

<script>
jQuery(function($) {

	$("#date1").datepicker({
		 changeMonth: true,
		 changeYear: true,
		 dateFormat: "yy-mm-dd" 
	});
	$("#date2").datepicker({
		 changeMonth: true,
		 changeYear: true,
		 dateFormat: "yy-mm-dd" 
	});

});
</script>