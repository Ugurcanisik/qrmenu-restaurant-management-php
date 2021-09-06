<?php 

class DB{

	public static $_baglan=null;

	private $_pdo,
	$_query,
	$_sayac=0,
	$_sonuc,
	$_hatalar=false;


	public function __construct(){
		
		try {
			$this->_pdo = new PDO('mysql:host='.Main::config('mysql/host').';dbname='.Main::config('mysql/hostdb'),Main::config('mysql/hostname'),Main::config('mysql/hostparola'));
			$this->_pdo->exec("set names utf8");
		} catch (PDOException $e) {

			die($e->getMessage());
		}

		
	}

	public function baglan(){
		
		if(!isset(self::$_baglan)){
			self::$_baglan = new DB();	
		}
		return self::$_baglan;
		
	}


	public function ekle($tablo=null,$alanlar=array()){
		if($tablo && count($alanlar)){
			$anahtar=array_keys($alanlar);
			$deger="";
			$x=1;

			foreach ($alanlar as $key) {
				$deger.="?";
				if($x<count($alanlar)){
					$deger.=", ";
				}
				$x++;
			}
			$sql="insert into $tablo (`".implode('`, `', $anahtar)."`) values ($deger) ";
			if(!$this->query($sql,$alanlar)->hatalar()){
				return true;
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}

	public function guncelle($veriler=array(),$alanlar=array()){

		if(count($veriler) && count($alanlar)){

			$set="";
			$x=1;

			foreach ($alanlar as $anahtar => $deger) {
				$set.="{$anahtar}=?";
				if($x<count($alanlar)){
					$set.=", ";
				}
				$x++;
			}


			$sql="update $veriler[0] set {$set} where $veriler[1]=$veriler[2]";

			if(!$this->query($sql,$alanlar)->hatalar())
				return true;
			else
				return false;
		}else{
			return false;
		}
		
	}

	


	public function resup($nere=null){
		if($nere){
			$uploads_dir=$nere;
			$name=$_FILES['resim']["name"];
			$tmp_name=$_FILES['resim']["tmp_name"];
			$r1=rand(1,100);
			$benzersizad=$r1;
			$resimyol=$uploads_dir."/".$benzersizad.$name;
			copy($tmp_name, "$uploads_dir/".$benzersizad.$name);
			return $resimyol;
		}else{
			return false;
		}
		

	}

	
	public function getir($alanlar=array()){

		if(count($alanlar)){
			switch ($alanlar[1]) {
				case 'hepsi':
				$sql="select * from $alanlar[0] where silindimi = ?";
				if(!$this->query($sql,array(0))->hatalar()){
					return $this;
				}else{
					return false;
				}
				break;
				case 'pop':
				$sql="select * from $alanlar[0] where silindimi = ? and u_kategori = ? and durum = ?";
				if(!$this->query($sql,array(0,7,1))->hatalar()){
					return $this;
				}else{
					return false;
				}
				break;
				case 'ciro':
				$ay = $alanlar[2];
				$sql="select sum(toplam) as ciro from $alanlar[0] where silindimi = ? and tarih like  '$ay'";

				if(!$this->query($sql,array(0))->hatalar()){
					return $this;
				}else{
					return false;
				}
				break;		
				case 'graf':
				$ay = $alanlar[2];
				$sql="select * from $alanlar[0] where silindimi = ? and tarih like  '$ay'";

				if(!$this->query($sql,array(0))->hatalar()){
					return $this;
				}else{
					return false;
				}
				break;	
				case 'excel':
			    $start = $alanlar[3];
				$end = $alanlar[4];
				$sql="select sum(toplam) as toplam from $alanlar[0] where silindimi = ? and turu = ? and tarih between '$start' and '$end' ";

				
				if(!$this->query($sql,array(0,$alanlar[2]))->hatalar()){
					return $this;
				}else{
					return false;
				}
				break;
				case 'sorgu':
				$operatorler= array("=",">","<",">=","<=");
				$alan=$alanlar[2];
				$operator=$alanlar[3];
				$deger=$alanlar[4];

				if(in_array($operator,$operatorler)){

					$sql="select * from $alanlar[0] where silindimi = ? and  $alan $operator ?";
					if(!$this->query($sql,array(0,$deger))->hatalar()){
						return $this;
					}else{
						return false;
					}

				}else{
					return false; 
				}

				break;
				case 'orderbysorgu':

				$operatorler = array("=",">","<",">=","<=","asc","desc");
				$alan=$alanlar[2];
				$operator=$alanlar[3];
				$deger=$alanlar[4];
				$ascordesc=$alanlar[5];

				if(in_array($operator,$operatorler)){
					if(in_array($ascordesc, $operatorler)){
						$sql="select * from $alanlar[0] where durum = ? and silindimi = ? and  $alan $operator ? order by sira $ascordesc";
						if(!$this->query($sql,array(1,0,$deger))->hatalar()){
							return $this;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					return false; 
				}

				break;
				case 'orderby':

				$operatorler = array("asc","desc");

				$operator=$alanlar[2];
				if(in_array($operator,$operatorler)){

					$sql="select * from $alanlar[0] where durum = ? and silindimi = ? order by sira $operator";
					if(!$this->query($sql,array(1,0))->hatalar()){
						return $this;
					}else{
						return false;
					}

				}else{
					return false; 
				}

				break;
				case 'order':
				$alan = $alanlar[2];
				$alandeger = $alanlar[3];
				$sql="select * from $alanlar[0] where silindimi = ? order by $alan $alandeger";
				if(!$this->query($sql,array(0))->hatalar()){
					return $this;
				}else{
					return false;
				}
				break;

				case 'raporgg':
				$start = $alanlar[2];
				$end = $alanlar[3];
				$sql="select * from $alanlar[0] where silindimi = ? and tarih between '$start' and '$end' ";

				
				if(!$this->query($sql,array(0))->hatalar()){
					return $this;
				}else{
					return false;
				}
				break;

				case 'pie':

				$sql="select sum(toplam) as top, turu from gider GROUP by turu";
				if(!$this->query($sql,array(0))->hatalar()){
					return $this;
				}else{
					return false;
				}
				break;

				case 'raportur':
				$start = $alanlar[2];
				$end = $alanlar[3];
				$sql="select * from $alanlar[0] where silindimi = ? and turu = ? and tarih between '$start' and '$end' ";

				
				if(!$this->query($sql,array(0,$alanlar[4]))->hatalar()){
					return $this;
				}else{
					return false;
				}
				break;
			}
		}else{
			return false;
		}
	}


	public function query($sql=null,$parametre=array()){

		if($sql && count($parametre)){

			if($this->_query=$this->_pdo->prepare($sql)){
				$x=1;

				if(count($parametre)){
					foreach ($parametre as $param) {
						$this->_query->bindValue($x,$param);
						$x++;
					}

					if($this->_query->execute()){
						$this->_sonuc=$this->_query->fetchAll(PDO::FETCH_OBJ);
						$this->_sayac=$this->_query->rowCount();
					}else{
						$this->_hatalar=true;
					}
					return $this;
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



	public function sayac(){
		return $this->_sayac;
	}



	public function hatalar(){
		return $this->_hatalar;
	}


	public function ilk(){
		return $this->_sonuc[0];
	}

	public function sonuc(){
		return $this->_sonuc;
	}




}














?>