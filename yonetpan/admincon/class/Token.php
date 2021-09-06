<?php 


class Token{


	public function olustur(){
		
		return Session::yerlestir(Main::config("session/token_ismi"),md5(uniqid()));
	}

	public function kontrol($token=null){
		
		if($token){
			$tokenname=Main::config("session/token_ismi");
			if(Session::varmi($tokenname) && Session::getir($tokenname)===$token){
				Session::sil($tokenname);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

}


?>
