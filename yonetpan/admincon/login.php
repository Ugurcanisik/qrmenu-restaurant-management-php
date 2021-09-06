<?php require_once 'core/init.php'; 

if(Session::varmi(Main::config("session/session_ismi"))){
  Main::yon("index");
}elseif(Main::inputcheck("klogin") && Token::kontrol(Main::inputbring(Main::config("session/token_ismi")))){


  $recaptchakodu=Main::inputbring("recaptchakodu");
  
  function guvenlik($jeton){
    $ip=$_SERVER['REMOTE_ADDR'];
    $talep=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeuTt0ZAAAAAKxc0gww5PKolH55lpooSKZ40axz&response=".$jeton."&remoteip=".$ip);
    $cevap=json_decode($talep);
    return $cevap;
  }
  
  $kontrol=guvenlik($recaptchakodu);
// $kontrol->success!=1 && $kontrol->score<0.5 && $kontrol->action!="login"
  if(false){
    $msg="Hatalı Işlem Yaptınız";
  }else{


    $onaylama = new Onaylama();

    $onaylama->kontrol($_POST,array(
      "email"=>array(
        "zorunlu"=>true,
        "min"=>5,
        "max"=>50,
        "prag"=>"/^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[com.tr]+$/i"),
      "parola"=>array(
        "zorunlu"=>true,
        "min"=>3,
        "max"=>50,
        "pw"=>"pw")
    ));


    if($onaylama->tamam()){


      $kullanici= new Kullanici();
      $dene=$kullanici->giris(Main::inputbring("email"),Main::inputbring("parola"));
      if($dene){
        if(!Session::varmi(Main::config("mesaj/mesaj"))){
          Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/loginmsg"));
        }
        Main::yon("index");
      }else{
        if(!Session::varmi(Main::config("mesaj/mesaj"))){
          $msg="Email Veya Parola Hatalı";
        }else{
          $msg=Session::mesaj(Main::config("mesaj/mesaj"));

        }

      }

    }else{
      foreach ($onaylama->hatalar() as $key ) {
        $msg.= $key."<br>";
      }
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

  <title>Noxsus Chocolate Workshop</title>

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
  
  <script src="https://www.google.com/recaptcha/api.js?render=6LeuTt0ZAAAAAL7JZ-3mRjuHceQcS3bNf6mIKHmg"></script>
  
  <script>
    function rec() {
     grecaptcha.execute('6LeuTt0ZAAAAAL7JZ-3mRjuHceQcS3bNf6mIKHmg', {action: 'login'}).then(function(token) {
       document.getElementById("recaptchaalani").value=token;
     });
   }
 </script>
 
</head>

<body class="login" onload="rec()">
  <div>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form method="POST" action="">
            <h1>Giriş</h1>
            <div>
              <input type="text" name="email" class="form-control" placeholder="Email Adresiniz" required="" />
            </div>
            <div>
              <input type="password" name="parola" class="form-control" placeholder="Şifreniz" required="" />
            </div>
            
            <div>
              <input type="hidden" name="recaptchakodu" id="recaptchaalani">
            </div>


            <div>
              <input type="hidden" value="<?php echo Token::olustur(); ?>" name="<?php echo Main::config("session/token_ismi"); ?>">
              <input type="submit" style="margin-left: 38%" class="btn btn-default submit" value="Giriş Yap" name="klogin">
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
