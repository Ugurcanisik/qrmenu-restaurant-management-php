<?php 

require_once 'core/init.php';

if(!Session::varmi(Main::config("session/session_ismi"))){
	Main::yon("login");
}else{
	
	if($kln = new Kullanici()){
		if(!$kln->yetki(Main::config("yetki/kullanici"))){
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
						if($kln->bul($id)){
							if($kln->sayac()){
								if($kln->veri()){
									$kln->kullaniciguncelle(array("ksil",$id),array("silindimi"=>1));
								}else{
									Main::yon("index");
								}
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
		Yonlendir::yon("index");
	}


}















?>