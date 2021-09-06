<?php include 'core/init.php'; 

$ayar = new Main();
if($ayar->verigetir(array("ayarlar","hepsi"))){
  $acek=$ayar->veri();
}else{
  Main::yon("404");
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $acek->a_title; ?></title>
  <link rel="shortcut icon" href="<?php echo substr($acek->a_logo, 6) ?>">
  <meta name="description" content="<?php echo $acek->a_description ?>">
  <meta name="keywords" content="<?php echo $acek->a_keywords ?>">
  <meta name="viewport" content="width=1000, user-scalable=no"/>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Satisfy|Bree+Serif|Candal|PT+Sans">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <!--Last CSS-->
  <link rel="stylesheet" type="text/css" href="css/last.css">
  <link href="https://fonts.googleapis.com/css2?family=Trispace:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-4E54JDHV80"></script>
    <script src="js/jquery.min.js"></script>
  <script src="js/alert.js" ></script>

  
  
  <?php 

  $urungetir = new Main();
  $urungetir->verigetir(array("urunler","pop"));
  $ran = rand(1,count($urungetir->veri()))-1;
  $urun = $urungetir->veri();

  //echo $urun[$ran]->u_ad;



  ?>
  
    <style>

    .po{
      font-family: 'Trispace', sans-serif; 
      font-size:40px;
      color: black;

    }


  </style>
  
  <script>
    $(document).ready(function(){
      $.pop = function(){
       Swal.fire({
       imageUrl: '<?php echo substr($urun[$ran]->u_resim, 6) ?>',
        showConfirmButton: false,
        timer: 4000,
        grow: 'row',
        heightAuto: true,
        
        html:
        '<p class="po" ><?php echo $urun[$ran]->u_ad  ?> Tatlımızı Denediniz mi ?</p>',
      })
     }
   });

 </script>
  
  
  
  
  
  
  
  <style type="text/css">
    <!--
    a.gflag {vertical-align:middle;font-size:32px;padding:1px 0;background-repeat:no-repeat;background-image:url(//gtranslate.net/flags/32.png);}
    a.gflag img {border:0;}
    a.gflag:hover {background-image:url(//gtranslate.net/flags/32a.png);}
    #goog-gt-tt {display:none !important;}
    .goog-te-banner-frame {display:none !important;}
    .goog-te-menu-value:hover {text-decoration:none !important;}
    body {top:0 !important;}
    #google_translate_element2 {display:none!important;}
    -->
  </style>
  <script type="text/javascript">
    function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'tr',autoDisplay: false}, 'google_translate_element2');}
  </script><script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>
  <script type="text/javascript">
    /* <![CDATA[ */
    eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',43,43,'||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'),0,{}))
    /* ]]> */
  </script>
</head>
<body  onload="$.pop();">

 <div id="google_translate_element2"></div>
 <a href="#" onclick="doGTranslate('tr|tr');return false;" class="gflag nturl" style="background-position:-100px -500px;"><img src="//gtranslate.net/flags/blank.png" height="32" width="32" alt="Turkish" /></a>

 <a href="#" onclick="doGTranslate('tr|en');return false;" class="gflag nturl" style="background-position:-0px -0px;"><img src="//gtranslate.net/flags/blank.png" height="32" width="32" alt="English" /></a>


 <section id="menu-list" class="section-padding">
  <div class="container">
    <div class="row">
      <!--
      <div class="col-md-12 text-center marb-35">
          <a href="index.php"><img src="<?php // echo substr($acek->a_logo, 6) ?>" style="background-color: #f2f2f2;" width="100%" height="610px;"></a>
          <h1 class="header-h menufont">Menu</h1>

        </div>
      -->

      <div style="margin-top: -60px">
        <center>
          <div style="margin-bottom: 50px;"><a style="text-decoration: none" href="index.php"><h1 class="header-h menufont">Menu</h1></a></div>
        </center>
      </div>
      <div class="col-md-12  text-center" id="menu-flters">
        <ul style="list-style-type: none;margin: 0; padding: 0;" >
          <?php 
          $kategori= new Main();
          if($kategori->verigetir(array("kategori","orderby","asc"))){
            if($kategori->sayac()){
              if($kategori->veri()){
                
                foreach ($kategori->veri() as $kategoribaslik) { ?>
                 <li><a onclick="go(this.id)" href="#<?php echo seo($kategoribaslik->kt_ad)  ?>" id="<?php echo seo($kategoribaslik->kt_ad)  ?>1"  style=" font-family: 'Trispace', sans-serif; font-size:20px; border-radius: 50px; background-color: #3a1200;color: white;"><?php echo $kategoribaslik->kt_ad; ?></a></li>
                 <?php }
               }else{
                Main::yon("404");
              }
            }else{
              Main::yon("404");
            }
          }else{
            Main::yon("404");
          }
          ?>
        </ul>
      </div>
    </center>
    <div id="menu-wrapper">
      <?php 

       
      $kategoriget= new Main();
      if(!$kategoriget->verigetir(array("kategori","orderby","asc"))){
        Main::yon("404");
      }
      foreach ($kategoriget->veri() as $gruplar) { ?>
        <div class="<?php echo seo($gruplar->kt_ad)."12" ?>" style=" margin-bottom: 10px; overflow: auto; border: 1px solid black; " id="<?php echo seo($gruplar->kt_ad) ?>">
          <?php 
          $urungetir = new Main();
          $urungetir->verigetir(array("urunler","orderbysorgu","u_kategori","=",$gruplar->kt_id,"asc"));
          
          ?>
          <div style=" margin-top: 20px;">
           <center>
            <span class="ktbaslik"><?php echo $gruplar->kt_ad ; ?></span>
          </center>
        </div>
        <?php 
        foreach ($urungetir->veri() as $urunler) { ?>
         <div class="restaurant" style="height: 
         <?php echo $gruplar->kt_yukseklik."px"?>;">
         <input type="hidden" onload="pos();" name="">
         <span class="clearfix">
          <span class="title urunad"><?php 
          echo $urunler->u_ad ?></span>
          <span   class="price urunfiyat"><?php echo $urunler->u_fiyat ; ?></span>
        </span>
        <?php 

        if(strlen($urunler->u_resim)>0){ ?>

          <div style="overflow: auto;">
            <div style="margin-right: 7px;  float: left; width: 100px; height: 100px; ">
              <a href="<?php echo substr($urunler->u_resim, 6) ?>" class="highslide" onclick="return hs.expand(this)">
                <img style="border-radius: 50px;" src="<?php echo substr($urunler->u_resim, 6) ?>" width="100px" height="100px" style="float: left; margin-right: 10px;">
              </a>
            </div>
            <p class="urundetay" ><?php echo $urunler->u_icerik; ?></p>
          </div>
          <?php
        }else{ ?>
          <p class="urundetay" ><?php echo $urunler->u_icerik; ?></p>
          <?php
        }


        ?>


      </div>
      <?php
      
    }
    ?>
  </div>
  <?php  
  
}
?>
</div>
</div>
</section>
<!--/ menu -->
<p class="totop" > 
  <a id="top">
    <img style="border-radius: 50%;" src="<?php echo substr($acek->a_logo, 6) ?>" width="100px" height="100px">
  </a> 
</p>
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
<!--Last JS-->
<script src="js/last.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
<script src="contactform/contactform.js"></script>
<script type="text/javascript" src="highslide/highslide-with-gallery.js"></script>
<script type="text/javascript">
  hs.graphicsDir = 'highslide/graphics/';
  hs.align = 'center';
  hs.transitions = ['expand', 'crossfade'];
  hs.wrapperClassName = 'dark borderless floating-caption';
  hs.fadeInOut = true;
  hs.dimmingOpacity = .75;

  // Add the controlbar
  if (hs.addSlideshow) hs.addSlideshow({
    //slideshowGroup: 'group1',
    interval: 5000,
    repeat: false,
    useControls: true,
    fixedControls: 'fit',
    overlayOptions: {
      opacity: .6,
      position: 'bottom center',
      hideOnMouseOut: true
    }
  });
</script>
