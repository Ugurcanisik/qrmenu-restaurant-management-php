<?php include 'header.php' ?>

<div class="right_col" role="main">
 <div class="row tile_count">



  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-user"></i> Günlük Gider</span>
    <div class="count">
      <?php 
      $topgider = new Main();
      $now = date('Y-m-d');
      $topgider->verigetir(array("gider","ciro",$now));
      echo $topgider->veri()->ciro."₺";
      ?>
    </div>
  </div>



  <!-- <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-clock-o"></i> Haftalık Gider</span>
    <div class="count">

      <?php 

      // $a =  date('Y-m-d');
      // $b = explode("-", date('Y-m-d'));
      // $gun = 7;
      // $gun -= $b[2];

      // $end = $b[0]."-".$b[1]."-".$gun;
      // $haf = new Main();

      // $haf->verigetir(array("gider","raporgg",$a,$end));

      // $haftop=0;
      // foreach ($haf->veri() as $key) {
      //   $haftop+=$key->toplam;
      // }

      // echo $haftop."₺";

      ?> 


      yapılacak      



    </div>
  </div>
-->



<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count" style="width: 300px">
  <span class="count_top"><i class="fa fa-user"></i> Aylık Gider</span>
  <div class="count " >


   <?php 
   $ay = date('m');
   $like = "_____$ay%";
   $aylik = new Main();
   $aylik->verigetir(array("gider","ciro",$like));

   echo $aylik->veri()->ciro."₺";

   ?>





 </div>
</div>



<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
  <span class="count_top"><i class="fa fa-user"></i> Dünkü Ciro</span>
  <div class="count">

    <?php 

    $bugun = date("Y-m-d");
    $cevir = strtotime('-1 day',strtotime($bugun));
    $ay = date("Y-m-d",$cevir); 
    $haf = new Main();
    $haf->verigetir(array("gelir","ciro",$ay));
    echo $haf->veri()->ciro."₺";



    ?>


  </div>

</div>

<!-- <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
  <span class="count_top"><i class="fa fa-user"></i> Haftalık Ciro</span>
  <div class="count">yapılacak</div>

</div> -->

<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
  <span class="count_top"><i class="fa fa-user"></i> Aylık Ciro</span>
  <div class="count">
    <?php 

    $ciro = new Main();
    $now = date('m');
    $like = "_____$now%";
    $ciro->verigetir(array("gelir","ciro",$like));
    echo $ciro->veri()->ciro."₺";


    ?>


  </div>

</div>
</div>

<div style="width: 60%; margin: 50px auto">
  <canvas id="line-chart" style="width: auto;" ></canvas>

</div>
<div style="width: 50%; margin: 50px auto">
  <canvas id="pie" style="width: auto;" ></canvas>
</div>

<?php




$ayhesap = new Main();

$ayhesap->verigetir(array("gelir","hepsi"));

$ay = array();
$like = "_____$now%";


foreach ($ayhesap->veri() as $key) {

  $date=$key->tarih;
  $date=explode("-",$date)[1];


  if(!in_array($date,$ay)){
    array_push($ay, $date);
  }



}



?>

<script >
  var ctx = document.getElementById("line-chart").getContext('2d')
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {

      labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
      datasets: [

      <?php 


      foreach ($ay as $key) {
        $topciro = "";
        $cirohesap = new Main();
        $like="_____$key%";
        $cirohesap->verigetir(array("gelir","graf",$like)); 

        if($cirohesap->sayac()==1){

          $topciro=$cirohesap->veri()->toplam;

        }else{
         foreach ($cirohesap->veri() as $cro) {
           $topciro.="$cro->toplam".",";
         }
       }



       $topciro=trim($topciro,",");

       ?>

       {
        label: "<?php echo aybul($key)  ?>",
        data: [<?php echo $topciro; ?>],
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      },
      <?php  $topciro = ""; }  ?>
      ]
    },

    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<?php

$aylar="";
$aylarciro=null;

foreach ($ay as $key) {
  $topciro=0;
  $aylar.=chr(34).aybul($key).chr(34).",";
  $cirohesap = new Main();
  $like="_____$key%";
  $cirohesap->verigetir(array("gelir","ciro",$like)); 
  $aylarciro.=$cirohesap->veri()->ciro.",";
}

?>


<script>
  var ctx = document.getElementById("pie").getContext('2d')
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [<?php echo $aylar; ?>],
      datasets: [{
        label: '',
        data: [<?php echo $aylarciro; ?>],
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>


<!-- <script>



  <?php 

  $pie = new Main();


  $pie->verigetir(array("gider","pie"));


  $gider = "";
  $top = "";


// print_r($pie->veri());


  foreach ($pie->veri() as $key) {
    $giderturu = new Main(array("giderturu","g_id",$key->turu));
    $gider.=chr(34).trim($giderturu->veri()->ad," ").chr(34).",";
    $top.="$key->top".",";

  }

  $gider= trim($gider,",");
  $top= trim($top,",");

  ?>





  var ctx = document.getElementById("pie").getContext('2d')
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: {

      labels: [<?php echo $gider; ?>],
      datasets: [
      {

        data: [<?php echo $top; ?>],
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      },

      ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script> -->

</div>
</div>
</div>
</div>

</div>

<?php include 'footer.php'; ?>