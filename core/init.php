  <?php 




  $GLOBALS['config']=array(
   "mysql"=>array(	
    "host"=>"localhost",
      "hostname"=>"dbname",
      "hostparola"=>"pw",
      "hostdb"=>"db"),
    "tablo"=>array(
      "kullanici"=>"kullanici",
      "yetki"=>"yetki",
      "ayarlar"=>"ayarlar",
      "hakkimizda"=>"hakkimizda",
      "slider"=>"slider",
      "urunler"=>"urunler",
      "kategori"=>"kategori")
  );

  spl_autoload_register(function($class){

    require_once 'yonetpan/admincon/class/'.$class.'.php';
  });














  

  function seo($s) {
    $tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',' ',',','?');
    $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','');
    $s = str_replace($tr,$eng,$s);
    $s = strtolower($s);
    $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
    $s = preg_replace('/\s+/', '-', $s);
    $s = preg_replace('|-+|', '-', $s);
    $s = preg_replace('/#/', '', $s);
    $s = str_replace('.', '', $s);
    $s = trim($s, '-');
    return $s;
  }


  ?> 