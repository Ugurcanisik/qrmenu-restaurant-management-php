<?php 

require_once 'core/init.php';

date_default_timezone_set('Europe/Istanbul'); 

if(!Session::varmi(Main::config("session/session_ismi"))){
  Main::yon("login");
}else{
  if($kln = new Kullanici()){
    if(!$kln->yetki(Main::config("yetki/temp"))){
    //Main::yon("404");  // ana temp e gönder
    }else{

      if($kln->sayac()){
        if($kln->veri()){
          $kveri=$kln->veri();

          $ayar = new Main();

          if($ayar->verigetir(array("ayarlar","hepsi"))){
            if($ayar->sayac()){
              if($ayar->veri()){
                $acek=$ayar->veri();
              }else{
                Main::yon("index");
              }
            }else{
              Main::yon("index");
            }
          }else{
            Main::yon("index");
          }
        }else{
         Main::yon("logout");
       }
     }else{
       Main::yon("logout");
     }
   }
 }else{
  Main::yon("logout");
}
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title><?php echo $acek->a_title; ?></title>
  <link rel="shortcut icon" href="<?php echo $acek->a_logo ?>">
  <!-- Bootstrap -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/main.js"></script>
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  <!-- bootstrap-progressbar -->
  <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
  <!-- bootstrap-daterangepicker -->
  <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
  <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>



  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="index" class="site_title"><i class="fa fa-paw"></i> <span><?php echo $acek->a_firmaad; ?></span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="upresim/user.png" style="margin-top: 38px;" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Hoşgeldiniz,</span>
              <h2><?php echo $kveri->k_ad." ".$kveri->k_soyad; ?></h2>
              <h5 style="color: white;">Yetki : <?php echo $kln->yetkiadi(); ?></h3>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Genel Ayarlar</h3>
                <ul class="nav side-menu">

                  <li><a href="index"><i class="fa fa-home"></i> Anasayfa </a></li>
                  <?php 



                  if($kln->yetki(Main::config("yetki/kullanici"))){ 

                    echo " <li><a><i class='fa fa-gears'></i> Kullanıcı İşlemleri <span class='fa fa-chevron-down'></span></a>";
                    echo "<ul class='nav child_menu'>";
                    echo "<li><a href='kullanici'>Kullanıcılar</a></li>";
                    echo "<li><a href='kullanici_ekle'>Kullanıcı Ekle</a></li>";
                    echo "</ul>";
                    echo "</li>";

                    echo " <li><a href='gider'><i class='fa fa-gears'></i> Gider İşlemleri </a></li>";

                    echo " <li><a href='gelir'><i class='fa fa-gears'></i> Gelir İşlemleri </a></li>";



                  } 

                  if($kln->yetki(Main::config("yetki/ayarlar"))){ 
                    echo "<li><a href='ayarlar'><i class='fa fa-users'></i> Genel Ayarlar </a></li>";
                  } 

                  if($kln->yetki(Main::config("yetki/urunler"))){
                    echo " <li><a><i class='fa fa-gears'></i> Ürünler İşlemleri <span class='fa fa-chevron-down'></span></a>";
                    echo "<ul class='nav child_menu'>";
                    echo "<li><a href='urunler'>Ürünler</a></li>";
                    echo "<li><a href='urun_ekle'>Ürün Ekle</a></li>";
                    echo "</ul>";
                    echo "</li>";

                    echo " <li><a><i class='fa fa-gears'></i> Kategori İşlemleri <span class='fa fa-chevron-down'></span></a>";
                    echo "<ul class='nav child_menu'>";
                    echo "<li><a href='kategoriler'>Kategoriler</a></li>";
                    echo "<li><a href='kategori_ekle'>Kategori Ekle</a></li>";
                    echo "</ul>";
                    echo "</li>";
                  }


                  if($kln->yetki(Main::config("yetki/kullanici"))){ 

                    

                    echo " <li><a href='rapor'><i class='fa fa-gears'></i> Raporlar </a></li>";



                  } 

                  ?>



                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a style="width: 100%" data-toggle="tooltip" data-placement="top" title="Çıkış" href="logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="upresim/user.png" alt=""><?php echo $kveri->k_ad." ".$kveri->k_soyad; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="profil_guncelle"><i class="fa fa-user pull-right"></i> Profil Güncelle</a></li>
                    <li><a href="parola_guncelle"><i class="fa fa-lock pull-right"></i>Parola Değiştir</a></li>
                    <li><a href="logout"><i class="fa fa-sign-out pull-right"></i> Çıkış</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->