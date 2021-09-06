<?php 

require_once 'core/init.php';

if(!Session::varmi(Main::config("session/session_ismi"))){
	Main::yon("login");
}

if($kln = new Kullanici()){
	if(!$kln->yetki(Main::config("yetki/urunler"))){
		if(!Session::varmi(Main::config("mesaj/mesaj"))){
			Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/yetkimsg"));
		}
		Main::yon("index");
	}else{
		if(!Main::inputcheck(null,"get")){
			Main::yon("index");
		}else{
			$id=Main::inputbring("id");
			if(!$id){
				Main::yon("index");
			}else{
				$a=Onaylama::getonayla($id);
				if($a){
					Main::yon("index");
				}else{
					if($ktsil = new Main(array("gider","g_id",$id))){
						if($ktsil->sayac()){
							
							$ktsil->veriguncelle(array("sil","gider"),array("gider","g_id",$id),array("silindimi"=>1));
							
						}else{
							Main::yon("index");
						}
					}else{
						Main::yon("index");
					}									
				}
			}
		}
	}
}else{
	Main::yon("index");
}














?>