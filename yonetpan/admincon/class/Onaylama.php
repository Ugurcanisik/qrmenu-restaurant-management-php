<?php 




class Onaylama{

	private $_hatalar=array(),
	$_db,
	$_tamam=false;



	public function __construct(){
		$this->_db=DB::baglan();
	}

	public function gettemizle($veri=null){
		if($veri){
			$veri=trim($veri);
			return preg_replace("/[^0-9]/i","",$veri);
		}else{
			return false;
		}
	}


	public function getonayla($veri=null){
		if($veri){
			$veri=trim($veri);
			return preg_match("/[^0-9]/i",$veri);
		}else{
			return false;
		}
	}



	public function reskontrol($bolumler=array()){

		if($bolumler){
			foreach ($bolumler as $bolum => $kurallar) {
				$deger=$_FILES[$bolum];
				foreach ($kurallar as $kural => $kural_deger) {
					if($kural=="zorunlu" && empty($deger['name'])){	
						$this->hataekle("Dosya Seçiniz");
					}elseif($deger['name']!=""){
						switch ($kural) {
							case 'boyut':
							if($deger['size']>$kural_deger){
								$this->hataekle("Resim Boyutu Fazla");
							}
							break;
							case 'uzanti':
							$uzati = pathinfo($deger["name"], PATHINFO_EXTENSION);
							$uzantitur=explode("/", $kural_deger);

							$x=0;
							$uzan="";
						$sayac=0;
							foreach ($uzantitur as $key) {
								if(mb_strtolower($uzantitur[$x])==mb_strtolower($uzati)){
									$sayac++;
								}
								$x++;
							}

							if($sayac!=1){
								foreach ($uzantitur as $keye) {
									$uzan.=" ".$keye;
								}
								$this->hataekle("Uzantı $uzan Olmalıdır");
							}
							break;
						}
					}
				}
			}

			if(empty($this->_hatalar)){
				return $this->_tamam=true;
			}

			return $this;
		}else{
			return false;
		}
	}





	public function kontrol($kaynak=null,$bolumler=array()){


		if($kaynak && $bolumler){
			foreach ($bolumler as $bolum => $kurallar) {
				foreach ($kurallar as $kural => $kural_deger) {
					@$deger=trim($kaynak[$bolum]);

					if($kural=="zorunlu" && empty($deger)){
						$this->hataekle("$bolum zorunlu alandır");
					}elseif(!empty($deger)){

						switch ($kural) {
							case 'min':
							if(strlen($deger)<$kural_deger){
								$this->hataekle("$bolum en az $kural_deger olmalıdır");
							}
							break;
							case 'max':
							if(strlen($deger)>$kural_deger){
								$this->hataekle("$bolum en fazla $kural_deger olmalıdır");
							}
							break;
							case 'eslesme':
							if($deger!=$kaynak[$kural_deger]){
								$this->hataekle("$kural_deger ile $bolum eslesmedi");
							}
							break;
							case 'benzersiz':
							$kontrol=$this->_db->getir(array($kural_deger,"sorgu","k_"."$bolum","=","$deger"));
							if($kontrol->sayac()){
								$this->hataekle("$bolum zaten kayıtlı");
							}
							break;
							case 'prag':
							$varsa=preg_match($kural_deger, $deger);
							if($varsa==0){
								$this->hataekle("$bolum doğru giriniz");
							}
							break;	
							case 'sayi':
							if(!is_numeric($deger)){
								$this->hataekle("$kural_deger Kısmına Sadece Rakam Giriniz");
							}
							break;
							case 'pw':
							$lenght=strlen($deger);
							$deger=str_replace(chr(34),"",$deger);
							$deger=str_replace(chr(39),"",$deger);
							$deger=str_replace(chr(92),"",$deger);
							$deger=str_replace("`","",$deger);
							$deger=str_replace("~","",$deger);

							if($lenght!=strlen($deger)){
								$this->hataekle("$bolum'de özel karakterler kullanmayınız!");
							}
							break;	

						}

					}

				}

			}

			if(empty($this->_hatalar)){
				return $this->_tamam=true;
			}

			return $this;
		}else{
			return false;
		}



	}


	public function hatalar(){
		return $this->_hatalar;	
	}
	public function hataekle($hata){
		return $this->_hatalar[]=$hata;
	}

	public function tamam(){
		return $this->_tamam;
	}








}
?>