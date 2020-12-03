<?php
      $position = 1;
      //$method = $_GET["method"];
      //$submethod = $_GET["submethod"];
      if($method === "province"){
          include_once "_includes/classes/param_class.php";
          $params = new param ( );
          $provincelist = array();
          $rs = $params->propinsi_data_viewlist (""," and propinsi_del_st = 1");
          $i = 0;
          while ( $arr = $rs->FetchRow () ) {
            $i ++;
            array_push($provincelist, array("value"=>$arr['propinsi_id'],"label"=>$arr['propinsi_name'])) ;
          }
          echo json_encode($provincelist);
      }else if($method === "city"){
          include_once "_includes/classes/param_class.php";
          $params = new param ( );
          $cityList = array();
          $rs = $params->kabupaten_data_viewlist_service ("and kabupaten_del_st = 1");
          $i = 0;
          while ( $arr = $rs->FetchRow () ) {
            $i ++;
            array_push($cityList, array("value"=>$arr['kabupaten_id'],"label"=>$arr['kabupaten_name'])) ;
          }
          echo json_encode($cityList);
      }else if($method === "customer"){
          include_once "_includes/classes/master_customer_class.php";
          $customer = new mastercustomer ( );
          $customerList = array();
          $rs = $customer->master_customer_viewlist_service ("");
          $i = 0;
          while ( $arr = $rs->FetchRow () ) {
            $i ++;
            array_push($customerList, array("value"=>$arr['customer_id'],"label"=>$arr['customer_name'])) ;
          }
          echo json_encode($customerList);
      }else if($method === "reportprosentasenilai"){
          include_once "_includes/classes/report_prosentasenilai_class.php";
          $prosentasenilai = new reportprosentasenilai();
          $medialist = array();
          $beritapositiflist = array();
          $beritanegatiflist = array();
          $beritaadvertoriallist = array();
          $rs = $prosentasenilai->report_prosentasenilai_viewlist_service ("","","");
          $i = 0;
          while ( $arr = $rs->FetchRow ()){
            $i ++;
            array_push($medialist, $arr["media_name"]);
            array_push($beritapositiflist, $arr["media_nilaipositif"]);
            array_push($beritanegatiflist, $arr["media_nilainegatif"]);
            array_push($beritaadvertoriallist, $arr["media_nilaiadvertorial"]);
          }

          if($submethod === "media"){
            echo json_encode($medialist);
          }else if($submethod === "beritapositif"){
            echo json_encode($beritapositiflist);
          }else if($submethod === "beritanegatif"){
            echo json_encode($beritanegatiflist);
          }else if($submethod === "beritaadvertorial"){
            echo json_encode($beritaadvertoriallist);
          }
        
      }else if($method === "totalmedia"){
        include_once "_includes/classes/master_media_class.php";
        $mastermedia = new mastermedia();
        $recordcount = null;
        if(isset($submethod) && ($submethod == 1 || $submethod == 2 || $submethod == 3 || $submethod == 4 || $submethod == 5)){
          $recordcount = $mastermedia->master_media_count_service($submethod);
        }

        echo $recordcount;
        
        
      }

?>
