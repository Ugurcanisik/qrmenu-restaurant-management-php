<?php 


class Main{

	private $_db,$_veri,$_sayac;


	public function __construct($veriler=array()){
		$this->_db=DB::baglan();

		/*
		0 => tablo adı
		1 => id adı
		2 => id değeri
		*/

		if(count($veriler)){
			if($veri=$this->_db->getir(array($veriler[0],"sorgu",$veriler[1],"=",$veriler[2]))){
				if($veri->sayac()){
					if($veri->ilk()){
						$this->_sayac=$veri->sayac();
						$this->_veri=$veri->ilk();
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


		
	}



	public function verigetir($alanlar){

		/*
		0 => tablo adı
		1 => hepsi,sorgu,between
		2 => alan
		3 => =,=<
		4 => deger
		*/

		if(count($alanlar)){
			if($veri=$this->_db->getir($alanlar)){
				if($veri->sayac()){
					if($veri->ilk()){
						$this->_sayac=$veri->sayac();
						if(count($veri->sonuc())===1){
							$this->_veri=$veri->ilk();
						}elseif(count($veri->sonuc())>1){
							$this->_veri=$veri->sonuc();
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
		}else{
			return false;
		}
	}



	public function veriguncelle($sayfa=array(),$veriler,$alanlar){
			/*
		veriler
		0 => tablo
		1 => id adı
		2 => id değeğeri
		*/

		if(count($sayfa) && $veriler && $alanlar){
			if(!$this->_db->guncelle($veriler,$alanlar)){
				return false;
			}else{
				
				switch ($sayfa[0]) {
					case 'guncelle':
					if(!Session::varmi(Main::config("mesaj/mesaj"))){
						Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/guncelleme"));
					}
					Main::yon($sayfa[1]);
					break;
					case 'sil':
					if(!Session::varmi(Main::config("mesaj/mesaj"))){
						Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/silme"));
					}
					Main::yon($sayfa[1]);
					break;
				}
			}
		}else{
			return false;
		}
	}



	public function veriekle($veriler=array(),$alanlar){

		/*
		0 => tablo
		1 => sayfa
		*/
		if(count($veriler) && $alanlar){
			if(!$this->_db->ekle($veriler[0],$alanlar)){
				return false;
			}else{
				if(!Session::varmi(Main::config("mesaj/mesaj"))){
					Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/ekleme"));
				}
				Main::yon($veriler[1]);
			}
		}else{
			return false;
		}
	}



	public function config($yol=null){
		if($yol){
			$yol=explode("/", $yol);
			$config=$GLOBALS['config'];
			foreach ($yol as $bit) {
				if(isset($config[$bit])){
					$config=$config[$bit];
				}else{
					return false;
				}
			}
			return $config;
		}else{
			return false;
		}
	}

	public function inputcheck($button=null,$kaynak="post"){

		switch ($kaynak) {
			case 'post':
			return (!empty($_POST[$button]))? true : false;
			break;
			case 'get':
			return (!empty($_GET))? true : false;
			break;
			default:
			return false;
			break;
		}

	}

	public function inputbring($alan=null){
		if($alan){
			if ($_POST) {
				return $_POST[$alan];
			}elseif($_GET){
				return $_GET[$alan];
			}
		}else{
			return false;
		}
	}



	public function yon($konum=null){
		if($konum){
			header("location: ".$konum);
			exit();
		}

	}


	public function veri(){
		return $this->_veri;
	}

	public function sayac(){
		return $this->_sayac;
	}






}


?>