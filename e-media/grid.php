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
	                            <?
								$jmlHeader = count ( $gridHeader );
								echo ("<th width='3%'>No</th>");
								for($j = 0; $j < $jmlHeader; $j ++) {
									echo ("<th width='" . $gridWidth [$j] . "%'>" . $gridHeader [$j] . "</th>");
								}
								if ($widthAksi != "0") {
									echo ("<th width='" . $widthAksi . "%'>Aksi</th>");
								}
								?>
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
											if ($gridHeader [$j] == "Tanggal") {
												?>
									<td>
								<?
												if($method=='log_aktifitas')
												echo $comfunc->dateTimeIndo ( $arr [$gridDetail [$j]] );
												else
												echo $comfunc->dateIndo ( $arr [$gridDetail [$j]] );
												?>
									</td>
								<?
											} else if ($gridHeader [$j] == "Status Online") {
												?>
									<td>
								<?
												if($arr [$gridDetail [$j]]==0){
												?>
												<button type="button" class="btn btn-danger"><i class="fa fa-heart-o"></i>&nbsp; Offline</button>
												<?
												}else{
											?>
											<button type="button" class="btn btn-success"><i class="fa fa-heart" Onclick="return set_action('getKill', '<?=$arr[0]?>', '<?=$arr[1]?>')"></i>&nbsp; Online</button>
								<?
												}
								?>
									</td>
								<?
											} else if ($gridHeader [$j] == "Tanggal Backup") {
												?>
									<td>
								<?
												echo $comfunc->dateTimeIndo ( $arr [$gridDetail [$j]] );
												?>
									</td>
								<?
											} else if ($gridHeader [$j] == "Warna") {
												?>
									<td bgcolor="<?=$arr[$gridDetail[$j]]?>"><?=$arr[$gridDetail[$j]]?></td>
								<?
											} else if ($gridHeader [$j] == "Lampiran") {
												?>
									<td><a href="#" Onclick="window.open('<?=$comfunc->baseurl("Upload_Ref").$arr[$gridDetail[$j]]?>','_blank')"><?=$arr[$gridDetail[$j]]?></a></td>
								<?
											} else if ($gridHeader [$j] == "Tipe Media") {
												?>
									<td>
										<?php
										
										switch($arr[$gridDetail[$j]]){
											case 1 : echo "Media Cetak - Surat Kabar Harian"; break;
											case 2 : echo "Media Cetak - Surat Kabar Mingguan"; break;
											case 3 : echo "Media Online - Website Online"; break;
											case 4 : echo "Media Online - Website Streaming"; break;
											case 5 : echo "Media Online - Televisi"; break;
											default : echo "test"; break;
										} 
										?>
									</td>
								<?
											} else if ($gridHeader [$j] == "Jumlah") {
												?>
									<td align="right">
								<?
												echo $comfunc->format_uang ( $arr [$gridDetail [$j]] );
												?>
									</td>
								<?
											} else if ($gridHeader [$j] == "Status") {
												?>
									<td>
								<?
												if($arr [$gridDetail [$j]]==0){
												?>
													<span style="background-color: RED; color: WHITE; padding: 2px; display: inline-block;">Not Active</span>
								<?
												}else{
											?>
													<span style="background-color: GREEN; color: WHITE; padding: 2px;">Active</span>
								<?
												}
								?>
									</td>


								<?
							} else if ($gridHeader [$j] == "Residential Status") {
												?>
									<td>
								<?
												if($arr [$gridDetail [$j]]==0){
												?>
													<span style="background-color: YELLOW; color: BLACK; padding: 2px; display: inline-block;">Temporary Residence</span>
								<?
												}else{
											?>
													<span style="background-color: GREEN; color: WHITE; padding: 2px;">Permanent Residence</span>
								<?
												}
								?>
									</td>


								<?
											} else if ($gridHeader [$j] == "Kondisi") {
												?>
									<td>
								<?
												if($arr [$gridDetail [$j]]==0){
												?>
													<span class="tag tag-danger">Rusak</span>
								<?
												}else{
											?>		<span class="tag tag-success">Baik</span>
								<?
												}
								?>
									</td>
								<?
											} else if ($gridHeader [$j] == "Status Assembly") {
												?>
									<td>
								<?
												if($arr [$gridDetail [$j]]==0){
												?>
													<span class="tag tag-success">Available</span>
								<?
												}else{
											?>		<span class="tag tag-danger">Not Available</span>

								<?
												}
								?>
									</td>
								<?
											} else if ($gridHeader [$j] == "Status Available") {
												?>

									<td>
								<?
												if($arr [$gridDetail [$j]]==0){
												?>
															<span style="background-color: GREEN; color: WHITE; padding: 2px;">Available</span>

								<?
												}else{
											?>
													<span style="background-color: RED; color: WHITE; padding: 2px; display: inline-block;">On Processed</span>
								<?
												}
								?>
									</td>
									<?
								} else if ($gridHeader [$j] == "Status Active") {
													?>

										<td>
									<?
													if($arr [$gridDetail [$j]]==1){
													?>
																<center><span style="background-color: GREEN; color: WHITE; padding: 2px;">Active</span></center>

									<?
													}else{
												?>
														<center><span style="background-color: RED; color: WHITE; padding: 2px; display: inline-block;">Inactive</span></center>
									<?
													}
									?>
										</td>
										<?
									} else if ($gridHeader [$j] == "Archive Type") {
														?>

											<td>
										<?
														if($arr [$gridDetail [$j]]==0){
														?>
																	<center><span>Import</span></center>

										<?
														}else{
													?>
															<center><span>Export</span></center>
										<?
														}
										?>
											</td>
											<?
										}  else {
												?>
									<td><?=$arr[$gridDetail[$j]]?></td>
								<?
											}
										}
										if ($widthAksi != "0") {
										?>
									<td> 
										<div class="btn-group" >
											<button class="btn btn-primary dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Pilih Salah Satu
											</button>
											<div class="dropdown-menu" >
												<?
												if(isset($iconHistory)){
													if($iconHistory){
														echo "<a class=\"dropdown-item\" href=\"javascript:set_action('gethistory', '$arr[0]')\">View History</a>";
													}
												}
												if(isset($iconDetail)){
													if($iconDetail){
														echo "<a class=\"dropdown-item\" href=\"javascript:set_action('getdetail', '$arr[0]')\">View Detail</a>";
													}
												}
												if(isset($iconAddDetail)){
													if($iconAddDetail){
														echo "<a class=\"dropdown-item\" href=\"javascript:set_action('adddetail', '$arr[0]')\">Add Detail</a>";
													}
												}
												if(isset($iconEdit)){
													if($iconEdit){
														echo "<a class=\"dropdown-item\" href=\"javascript:set_action('getedit', '$arr[0]')\">Ubah Data</a>";
													}
												}
												if(isset($iconDel)){
													if($iconDel){
														echo "<a class=\"dropdown-item\" href=\"javascript:set_action('getdelete', '$arr[0]')\">Hapus</a>";
													}
												}
												if(isset($iconAddProduct)){
													if($iconAddProduct){
														echo "<a class=\"dropdown-item\" href=\"javascript:set_action('getaddproduct', '$arr[0]')\">Tambah Produk</a>";
													}
												}
												?>
											</div>
										</div>
								<?
							}
										?>
									</td>
								</tr>
								<?
									}
								} else {
									?>
									<td colspan="<?=$jmlHeader+2?>">Tidak ada Data</td>
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
