<?php 


require_once 'core/init.php';

// Main::inputcheck(null,"get")


if(Main::inputcheck(null,"get")){



	$start=Main::inputbring("start");

	$end = Main::inputbring("end");


	$raportur = Main::inputbring("tur");




	// $start="2021-06-1";

	// $end = "2021-06-30";


	// $raportur = "gelir";

	$exc = new Main();

	$dizi=[];
	

	if($raportur=='gider'){

		$exc->verigetir(array($raportur,"raporgg",$start,$end));




		$giderturleri=[];



		foreach ($exc->veri() as $key) {
			if(!in_array($key->turu,$giderturleri)){
				array_push($giderturleri,$key->turu);
			}
		}


		foreach ($giderturleri as $key) {

			$tur = new Main();
			$tur->verigetir(array("giderturu","sorgu","g_id","=",$key));

			$top = new Main();
			$top->verigetir(array("gider","excel",$key,$start,$end));


			$x = 
			[
				"Gider"=>$tur->veri()->ad,
				"Toplam"=>str_replace(".", ",", $top->veri()->toplam),
			];

			array_push($dizi, $x);

			$x=null;


		}


		$excel = new Excel();
		$excel->doldur($dizi);
		$excel->kaydet($start."  ".$raportur."  ".$end);


	}elseif($raportur=='gelir'){




		$exc->verigetir(array($raportur,"raporgg",$start,$end));



		foreach ($exc->veri() as $key) {

			$tarih = explode("-", $key->tarih);

			// print_r($tarih);

			$gun = $tarih[2];
			$ay = $tarih[1];
			$yil = $tarih[0];


			$x = 
			[
				"Tarih"=>$key->tarih,
				"Toplam"=>$key->toplam,
			];

			array_push($dizi, $x);

			$x=null;



			
		}





		$excel = new Excel();
		$excel->doldur($dizi);
		$excel->kaydet($start."  ".$raportur."  ".$end);


	}





	

}





?>