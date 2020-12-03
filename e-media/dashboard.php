<div class="animated fadeIn">

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse card-primary">
                <div class="card-block pb-0">
                    <h4 class="mb-0"><?php $method = "totalmedia"; $submethod="1"; include('sharedservice.php'); ?></h4>
                    <p>Surat Kabar Harian</p>
                </div>
                <div class="chart-wrapper px-1" style="height:70px;">
                    <canvas id="card-chart1" class="chart" height="70"></canvas>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse card-info">
                <div class="card-block pb-0">
                    <h4 class="mb-0"><?php $method = "totalmedia"; $submethod="2"; include('sharedservice.php'); ?></h4>
                    <p>Surat Kabar Mingguan</p>
                </div>
                <div class="chart-wrapper px-1" style="height:70px;">
                    <canvas id="card-chart2" class="chart" height="70"></canvas>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse card-warning">
                <div class="card-block pb-0">
                    <h4 class="mb-0"><?php $method = "totalmedia"; $submethod="3"; include('sharedservice.php'); ?></h4>
                    <p>Website Online</p>
                </div>
                <div class="chart-wrapper" style="height:70px;">
                    <canvas id="card-chart3" class="chart" height="70"></canvas>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse card-danger">
                <div class="card-block pb-0">
                    <h4 class="mb-0"><?php $method = "totalmedia"; $submethod="4"; include('sharedservice.php'); ?></h4>
                    <p>Website Streaming</p>
                </div>
                <div class="chart-wrapper px-1" style="height:70px;">
                    <canvas id="card-chart4" class="chart" height="70"></canvas>
                </div>
            </div>
        </div>
        <!--/col-->

    </div>
    <!--/row-->

    <div class="card">
        <div class="card-block">
            <div class="row">
                <div class="col-xs-5">
                    <h4 class="card-title">Data Prosentase Nilai</h4> 
                </div>
               
            </div>
            <div class="chart-wrapper" style="margin-top:40px;">
                <canvas id="mediaProsentaseCanvas" height="75"></canvas>
            </div>
        </div>
        <div class="card-footer">
            
        </div>
    </div>

    <div class="card">
        <div class="card-block">
            <div class="row">
                <div class="col-xs-5">
                    <h4 class="card-title">Detail Prosentase Nilai</h4> 
                </div>
               
            </div>
            <div class="chart-wrapper" style="margin-top:40px;">
            <?
                include_once "_includes/classes/report_prosentasenilai_class.php";
                $report_prosentasenilaims = new reportprosentasenilai ( $ses_userId );

                @$_action = $comfunc->replacetext ( $_REQUEST ["data_action"] );

                if(isset($_POST["date1"]) && isset($_POST["date2"])){
                    @session_start();
                    $_SESSION['date1'] = $comfunc->replacetext($_POST["date1"]);
                    $_SESSION['date2'] = $comfunc->replacetext($_POST["date2"]);
                    $_SESSION['media'] = $comfunc->replacetext($_POST["media"]);
                }

                $date1 = @$_SESSION['date1'];
                $date2 = @$_SESSION['date2'];
                $media = @$_SESSION['media'];


                $gridHeader = array ("Nama Media", "Penanggung Jawab Wilayah", "Nilai Positif", "Nilai Negatif","Nilai Advertorial","Prosentase");
                $gridDetail = array ("1","2", "3","4","5","6");
                $gridWidth = array ( "7","7","7","7");


                $paging_request = "main_page.php?method=mstrproduct";
                $acc_page_request = "report_prosentasenilai_acc.php";
                $list_page_request = "report_prosentasenilai_view.php";

                // ==== buat grid ===//
                $num_row = 10;
                @$str_page = $comfunc->replacetext ( $_GET ['page'] );
                if (isset ( $str_page )) {
                    if (is_numeric ( $str_page ) && $str_page != 0) {
                        $noPage = $str_page;
                    } else {
                        $noPage = 1;
                    }
                } else {
                    $noPage = 1;
                }
                $offset = ($noPage - 1) * $num_row;

                $def_page_request = $paging_request . "&page=$noPage";

                $recordcount = $report_prosentasenilaims->report_prosentasenilai_count ($date1, $date2, $media);
                $rs = $report_prosentasenilaims->report_prosentasenilai_viewlist ( $date1, $date2, $media, $offset, $num_row, "");
                $page_title = "Laporan Prosentase Nilai";
                $page_request = $list_page_request;

                ?>
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
            </div>
        </div>
        <div class="card-footer">
            
        </div>
    </div>


</div>	
<script src="js/libs/jquery.min.js"></script>
<script src="js/libs/Chart.min.js"></script>
<script src="js/views/shared.js"></script>
<script src="js/views/main.js"></script>
<script>
jQuery(function($) {

    Chart.defaults.global.defaultFontFamily = "Lato";

    var barChartData = {
        labels: <?php $method = "reportprosentasenilai"; $submethod="media"; include('sharedservice.php'); ?>,
        datasets: [
            {
                label: "Berita Positif",
                backgroundColor: "#50a6d3",
                type: "bar",
                borderWidth: 0,
                data: <?php $method = "reportprosentasenilai"; $submethod="beritapositif"; include('sharedservice.php'); ?>
            },
            {
                label: "Berita Negatif",
                backgroundColor: "#e87470",
                type: "bar",
                borderWidth: 0,
                data: <?php $method = "reportprosentasenilai"; $submethod="beritanegatif"; include('sharedservice.php'); ?>
            },
            {
                label: "Berita Advertorial",
                backgroundColor: "#f2cc45",
                type: "bar",
                borderWidth: 0,
                data: <?php $method = "reportprosentasenilai"; $submethod="beritaadvertorial"; include('sharedservice.php'); ?>
            }
           
        ]
    };

    var chartOptions = {
        responsive: true,
        legend: {
            position: "top"
        },
        title: {
            display: true,
            text: "Data Prosentase Nilai"
        },
        scales: {
            yAxes: [{
            ticks: {
                beginAtZero: true
            }
            }]
        },
        elements: {
            point: {
                radius: 0,
                hitRadius: 10,
                hoverRadius: 4,
                hoverBorderWidth: 3,
            }
        }
    }

    var ctx = document.getElementById("mediaProsentaseCanvas").getContext("2d");

    var barChart = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: chartOptions
    });
});
</script>