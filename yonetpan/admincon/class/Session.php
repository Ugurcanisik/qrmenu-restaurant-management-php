<?php 

class Session{

	public function yerlestir($isim=null,$deger=null){
		if($isim && $deger){
			return $_SESSION[$isim]=$deger;
		}else{
			return false;
		}
	}


	public function varmi($isim=null){
		if($isim){
			return (isset($_SESSION[$isim]))? true : false;
		}else{
			return false;
		}
	}

	public function getir($isim=null){
		if($isim){
			if(self::varmi($isim)){
				return $_SESSION[$isim];
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function sil($isim=null){
		if($isim){
			if(self::varmi($isim)){
				unset($_SESSION[$isim]);			
			}else{
				return false;
			}
		}else{
			return false;
		}
	}


	public function mesaj($isim,$deger=""){

		if(self::varmi($isim)){
			$session=self::getir($isim);
			self::sil($isim);
			return $session;
		} else {
			self::yerlestir($isim,$deger);
			
		}
		return false;

	}
}

?>