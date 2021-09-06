<?php include 'header.php'; ?>



<?php 

if(!$kln->yetki(Main::config("yetki/urunler"))){
	if(!Session::varmi(Main::config("mesaj/mesaj"))){
		Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/yetkimsg"));
	}
	Main::yon("index"); 
}else{
	if(Main::inputbring("gider_ekle")){

		$onaylama = new Onaylama();

		$onaylama->kontrol($_POST,array(
			
			"toplam"=>array(
				"zorunlu"=>true,
				"min"=>1,
				"max"=>50,
				"prag"=>"/^[0-9.]+$/i"),
			"tur"=>array(
				"zorunlu"=>true,
				"min"=>1)
			
		));


		if($onaylama->tamam()){

		
			$katekle= new Main();
			$ekle=$katekle->veriekle(array("gider","gider"),array(
				"turu"=>Main::inputbring("tur"),
				"toplam"=>Main::inputbring("toplam"),
				"tarih"=>Main::inputbring("tarihler"),
				"aciklama"=>Main::inputbring("aciklama"),
				"maas"=>Main::inputbring("maas")
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
					<h2>Gider Ekle</h2>
					
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

						<div class="form-group" id="tursec">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_ad">Gider Adı <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12"  name="tur">
									<option value="0">Seçiniz</option>
									<?php 
									
									$katgetir=new Main();

									if($katgetir->verigetir(array("giderturu","order","ad","asc"))){
										if($katgetir->sayac()){


											foreach ($katgetir->veri() as $key ) { ?>
												<option value="<?php echo $key->g_id ?>"><?php echo $key->ad; ?></option>
												<?php

											}

										}else{
											// Main::yon("index");
										}
									}else{
										// Main::yon("index");
									} ?>





								</select>
							</div>
							
						</div>

						<div class="form-group" id="aciklama">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_sira">Açıklama <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="aciklama" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group" id="maas">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_sira">Alacaklı <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" name="maas">
									<option value="">Seçiniz</option>	
									<option value="Muhammed">Muhammed</option>
									<option value="Uğur">Uğur</option>
									<option value="Yunus">Yunus</option>
									<option value="Berkant">Berkant</option>
									<option value="Zakir">Zakir</option>
									<option value="Derkar">Derkar</option>
									<option value="Oguz">Oguz</option>
									<option value="Zorbey">Zorbey</option>
									<option value="Gıyas">Gıyas</option>
									<option value="Doğukan">Doğukan</option>
									<option value="Feyzullah">Feyzullah</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_sira">Toplam <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="toplam" class="form-control col-md-7 col-xs-12">
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

								<input type="submit" name="gider_ekle" style="margin-left: 40%"  class="btn btn-success" value="Ekle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>



</div>


<?php include 'footer.php'; ?>