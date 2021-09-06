<?php 



class Hash{


	public function olustur($pw=null,$salt=null){
		if($pw && $salt){
			return md5($pw.$salt);
		}else{
			return false;
		}
	}



	public function salt(){

		$x=rand(100000000000000000,999999999999999999);
		$y=rand(100000000000000000,999999999999999999);
		return $x.$y;
	}



	public function unique(){
		return self::olustur(uniqid());
	}







}








?>