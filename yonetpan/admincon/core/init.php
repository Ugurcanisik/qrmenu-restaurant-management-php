<?php 
// error_reporting(0);
session_start();
ob_start();

$msg="";

$GLOBALS['config']=array(
	"mysql"=>array(	
    "host"=>"localhost",
      "hostname"=>"db",
      "hostparola"=>"pw",
      "hostdb"=>"dbname"),
	"session"=>array(
		"session_ismi"=>"kullanici",
		"token_ismi"=>"token",
		"cap_ismi"=>"cap"),
	"mesaj"=>array(
		"mesaj"=>"mesaj",
		"loginmsg"=>"Giriş Başarılı",
		"yetkimsg"=>"Yetkisiz Erişim İsteği",
		"kpasifmsg"=>"Kullanıcı Pasif Durumda",
		"guncelleme"=>"Güncelleme Başarılı",
		"ekleme"=>"Ekleme Başarılı",
		"silme"=>"Silme Başarılı"),
	"tablo"=>array(
		"kullanici"=>"kullanici",
		"yetki"=>"yetki",
		"ayarlar"=>"ayarlar",
		"hakkimizda"=>"hakkimizda",
		"slider"=>"slider",
		"urunler"=>"urunler",
		"kategori"=>"kategori"),
	"yetki"=>array(
		"menuler"=>"menu",
		"hakkimizda"=>"hakkimizda",
		"ayarlar"=>"ayarlar",
		"slider"=>"slider",
		"kullanici"=>"kullanici",
		"musteri"=>"musteri",
		"temp"=>"temp",
		"slider"=>"slider",
		"urunler"=>"urunler"),
	"upload"=>array(
		"resim"=>"upresim")
);







spl_autoload_register(function($class){

	require_once 'class/'.$class.'.php';
});


require_once 'function/fonksiyonlar.php';




















?>