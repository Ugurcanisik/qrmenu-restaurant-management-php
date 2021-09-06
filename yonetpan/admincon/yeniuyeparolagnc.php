<?php require_once 'core/init.php'; 

if(!Session::varmi(Main::config("session/session_ismi"))){
  Main::yon("login");
}elseif($kln = new Kullanici()){
  if($kln->sayac()){
    if($kln->veri()){
      if($kln->veri()->k_yeniuye==false){
        Main::yon("index");
      }
    }else{
      Main::yon("login");
    }
  }else{
    Main::yon("login");
  }
}else{
  Main::yon("login");
}
if(Main::inputcheck("kpwdegistir") && Token::kontrol(Main::inputbring(Main::config("session/token_ismi")))){


  $onaylama = new Onaylama();

  $onaylama->kontrol($_POST,array(
    "mevcut_parola"=>array(
      "zorunlu"=>true,
      "min"=>3,
      "max"=>50,
      "pw"=>"pw"),
    "yeni_parola"=>array(
      "zorunlu"=>true,
      "min"=>3,
      "max"=>50,
      "pw"=>"pw"),
    "yeni_parola_tekrar"=>array(
      "zorunlu"=>true,
      "min"=>3,
      "max"=>60,
      "pw"=>"pw",
      "eslesme"=>"yeni_parola")
  ));


  if($onaylama->tamam()){




    if(Hash::olustur(Main::inputbring("mevcut_parola"),$kln->veri()->k_salt)==$kln->veri()->k_parola){
      if(Hash::olustur(Main::inputbring("yeni_parola"),$kln->veri()->k_salt)==$kln->veri()->k_parola){
        $msg="Mevcut Parolayı Girimezsiniz";
      }else{
        $guncel=$kln->kullaniciguncelle(array("yeniuyeparola",$kln->veri()->k_salt),array(
          "k_parola"=>Hash::olustur(Main::inputbring("yeni_parola"),$kln->veri()->k_salt),
          "k_yeniuye"=>0));

        if(!$guncel){
          $msg="Hata";
        }
      }
    }else{
      $msg="Mevcut Parola Hatalı!!";
    }






  }else{
    foreach ($onaylama->hatalar() as $key) {
      $msg.=$key."<br>";
    }
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

  <title>Firma Adı gelicek</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">

</head>

<body class="login">
  <div>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form method="POST" action="">
            <h1>Parola Değiştir</h1>
            <div>
              <input type="password" name="mevcut_parola" class="form-control" placeholder="Mevcut Parolanız" required=""  />
            </div>
            <div>
              <input type="password" name="yeni_parola" class="form-control" placeholder="Yeni Parolanız" required="" />
            </div>
            <div>
              <input type="password" name="yeni_parola_tekrar" class="form-control" placeholder="Yeni Parola Tekrar" required="" />
            </div>
            <div>
              <input type="hidden" value="<?php echo Token::olustur(); ?>" name="<?php echo Main::config("session/token_ismi"); ?>">
              <input type="submit" style="margin-left: 38%" class="btn btn-default submit" value="Değiştir" name="kpwdegistir">
            </div>
            <div class="clearfix"></div>
          </form>
        </section>
        <div style="width: 300px; height: <?php echo strlen($msg); ?> px"><?php echo $msg; ?></div>
      </div>
    </div>
  </div>
</body>
</html>

