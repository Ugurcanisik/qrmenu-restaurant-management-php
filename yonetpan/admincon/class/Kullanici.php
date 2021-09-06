<?php 

class Kullanici{

	private $_db,
	$_session,
	$_veri,
	$_girisyapti=false,
	$_yetkiadi,
	$_sayac=0,
	$_yetkiler=array();



	public function __construct($kullanici=null){

		$this->_db =  DB::baglan();
		$this->_session=Main::config("session/session_ismi");

		if(!$kullanici){

			if(Session::varmi($this->_session)){

				if($this->bul(Session::getir($this->_session))){
					return $this->_girisyapti=true;
				}else{
					return $this->_girisyapti;
				}

			}else{
				return false;
			}
		}else{
			return $this->bul($kullanici);
		}
	}

	public function kullaniciekle($alanlar=null){

		if($alanlar && $this->girisyapti()){
			if(!$this->_db->ekle(Main::config("tablo/kullanici"),$alanlar)){
				return false;
			}else{

				if(!Session::varmi(Main::config("mesaj/mesaj"))){
					Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/ekleme"));
				}
				Main::yon("kullanici");
			}
		}else{
			return false;
		}
	}



	public function kullanicigetir(){

		if($veri=$this->_db->getir(array(Main::config("tablo/kullanici"),"hepsi"))){
			if($veri->sayac()){
				if($veri->sonuc()){
					$this->_veri=$veri->sonuc();
					$this->_sayac=$veri->sayac();

					for($x=0;$x<$this->_sayac;$x++){
						$yetki=$this->_db->getir(array(Main::config("tablo/yetki"),"sorgu","y_id","=",$this->_veri[$x]->k_yetki));
						$this->_yetkiler[] = $yetki->ilk()->y_adi;
					}
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function yetkigetir(){

		if($veri=$this->_db->getir(array(Main::config("tablo/yetki"),"hepsi"))){
			if($veri->sayac()){
				if($veri->sonuc()){
					$this->_veri=$veri->sonuc();
					$this->_sayac=$veri->sayac();
					return true;
				}else{
					return false;	
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function giris($mail=null,$pw=null){

		if($mail && $pw){
			if($mail=$this->bul($mail)){
				if($this->veri()->k_parola===Hash::olustur($pw,$this->veri()->k_salt)){
					if($this->veri()->durum==true){
						Session::yerlestir($this->_session,$this->veri()->k_salt);
						if($this->veri()->k_yeniuye==true){
							Main::yon("yeniuyeparolagnc");
						}elseif($this->veri()->k_yeniuye==false){
							return true;
						}
					}else{
						if(!Session::varmi(Main::config("mesaj/mesaj"))){
							Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/kpasifmsg"));
						}
						return false;
					}		
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function kullaniciguncelle($veriler=array(),$alanlar){

		/*
		veriler
		0 => gidilecek sayfa
		1 => id 
		*/

		if(count($veriler) && $alanlar && $this->girisyapti()){
			
			if(!$this->_db->guncelle(array(Main::config("tablo/kullanici"),"k_salt",$veriler[1]),$alanlar)){
				return false;
			}else{

				switch ($veriler[0]) {
					case 'ksil':
					if(!Session::varmi(Main::config("mesaj/mesaj"))){
						Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/silme"));
					}
					Main::yon("kullanici");
					break;
					case 'kguncelle':
					if(!Session::varmi(Main::config("mesaj/mesaj"))){
						Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/guncelleme"));
					}
					Main::yon("kullanici_guncelle?id=$veriler[1]");
					break;
					case 'kprofil':
					if(!Session::varmi(Main::config("mesaj/mesaj"))){
						Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/guncelleme"));
					}
					Main::yon("profil_guncelle");
					break;
					case 'kparola':
					if(!Session::varmi(Main::config("mesaj/mesaj"))){
						Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/guncelleme"));
					}
					Main::yon("parola_guncelle");
					break;
					case 'yeniuyeparola':
					if(!Session::varmi(Main::config("mesaj/mesaj"))){
						Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/loginmsg"));
					}
					Main::yon("index");
					break;
				}

			}

		}else{
			return false;
		}

	}

	public function bul($mail=null){
		if($mail){
			$alan=(is_numeric($mail))? "k_salt" : "k_email";
			$veri=$this->_db->getir(array(Main::config("tablo/kullanici"),"sorgu",$alan,"=",$mail));
			if ($veri) {
				if($veri->sayac()){
					if($veri->ilk()){
						$this->_veri=$veri->ilk();
						$this->_sayac=$veri->sayac();
						$yetki=$this->_db->getir(array(Main::config("tablo/yetki"),"sorgu","y_id","=",$this->_veri->k_yetki));
						if($yetki){
							if($yetki->sayac()){
								if($yetki->ilk()){
									$this->_yetkiadi=$yetki->ilk()->y_adi;
									return true;
								}else{
									return false;
								}
							}else{
								return false;
							}
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}

	}


	public function yetki($yet=null){
		if($yet){

			if($yetki=$this->_db->getir(array(Main::config("tablo/yetki"),"sorgu","y_id","=",$this->veri()->k_yetki))){
				if($yetki->sayac()){
					if($yetki->ilk()){
						$izinler=json_decode($yetki->ilk()->y_yetki,true);
						if(isset($izinler[$yet]) && $izinler[$yet]==true){
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}


	public function veri(){
		return $this->_veri;
	}

	public function girisyapti(){
		return $this->_girisyapti;
	}

	public function yetkiadi(){
		return $this->_yetkiadi;
	}
	public function sayac(){
		return $this->_sayac;
	}

	public function yetkiler(){
		return $this->_yetkiler;
	}





	



}