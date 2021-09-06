<?php include 'header.php'; 


if(!$kln->yetki(Main::config("yetki/urunler"))){
	if(!Session::varmi(Main::config("mesaj/mesaj"))){
		Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/yetkimsg"));
	}
	Main::yon("index"); 
}else{
	if(Main::inputbring("gelir_ekle")){

		

		$onaylama = new Onaylama();

		$onaylama->kontrol($_POST,array(

			"gelir"=>array(
				"zorunlu"=>true,
				"min"=>1,
				"max"=>20,
				"prag"=>"/^[0-9.]+$/i"),
			"tarihler"=>array(
				"zorunlu"=>true)
		));


		if($onaylama->tamam()){

	

			$katekle= new Main();

			$ekle=$katekle->veriekle(array("gelir","gelir"),array(
				"toplam"=>Main::inputbring("gelir"),
				"tarih"=>Main::inputbring("tarihler")
			));

			if(!$ekle){
				$msg="Hata";
			}

		}else{
			foreach ($onaylama->hatalar() as $key) {
				$msg.=$key."<br>";
			}
		}
	}
}



?>
<div class="right_col" role="main">


	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gelir Ekle</h2>
					
					<div class="clearfix"></div>
					<?php 

					if(Session::varmi(Main::config("mesaj/mesaj"))){
						$msg=Session::mesaj(Main::config("mesaj/mesaj"));
					}
					?>
					<div style="width: 300px; height: <?php echo strlen($msg); ?> px"><?php echo $msg; ?></div>
				</div>

				<div class="x_content">
					<br />
					<form class="form-horizontal form-label-left" action="" method="POST">



						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_sira"> Ciro <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="gelir" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ad"> Tarih Seçiniz <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="date" class="form-control" name="tarihler" value="<?php 
								echo date('Y-m-d') ?>">

							</div>
						</div>

						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<input type="submit" name="gelir_ekle" style="margin-left: 40%"  class="btn btn-success" value="Ekle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>












</div>




<?php include 'footer.php'; ?>