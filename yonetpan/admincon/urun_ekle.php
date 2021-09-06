<?php include 'header.php'; 


if(!$kln->yetki(Main::config("yetki/urunler"))){
	if(!Session::varmi(Main::config("mesaj/mesaj"))){
		Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/yetkimsg"));
	}
	Main::yon("index"); 
}else{
	if(Main::inputcheck("urun_ekle")){

		$onaylama = new Onaylama();

		$onaylama->kontrol($_POST,array(
			"urun_ad"=>array(
				"zorunlu"=>true,
				"min"=>1,
				"max"=>50,
				"prag"=>"/^[a-z0-9çÇğĞİıIöÖşŞüÜ.()\/\ ]+$/i"),
			"urun_kategori"=>array(
				"zorunlu"=>true),
			"urun_sira"=>array(
				"zorunlu"=>true,
				"min"=>1,
				"max"=>10,
				"prag"=>"/^[0-9]+$/i")
		));


		if($onaylama->tamam()){

			if(empty($_FILES['resim']['name'])){

				$urekle= new Main();
				$ekle=$urekle->veriekle(array("urunler","urunler"),array(
					"u_ad"=>Main::inputbring("urun_ad"),
					"u_fiyat"=>Main::inputbring("urun_fiyat"),
					"u_kategori"=>Main::inputbring("urun_kategori"),
					"u_icerik"=>Main::inputbring("urun_icerik"),
					"sira"=>Main::inputbring("urun_sira"),
					"durum"=>Main::inputbring("durum")
				));

				if(!$ekle){
					$msg="Hata";
				}


			}elseif(isset($_FILES['resim']['name'])){

				$logonay= new Onaylama();

				$logonay->reskontrol(array(
					"resim"=>array(
						"zorunlu"=>true,
						"boyut"=>1024*1024*10,
						"uzanti"=>"jpg/PNG/jpeg"
					)));



				if($logonay->tamam()){


					$resyol=DB::resup("../../img");
					$urekle= new Main();
					$ekle=$urekle->veriekle(array("urunler","urunler"),array(
						"u_resim"=>$resyol,
						"u_ad"=>Main::inputbring("urun_ad"),
						"u_fiyat"=>Main::inputbring("urun_fiyat"),
						"u_kategori"=>Main::inputbring("urun_kategori"),
						"u_icerik"=>Main::inputbring("urun_icerik"),
						"sira"=>Main::inputbring("urun_sira"),
						"durum"=>Main::inputbring("durum")
					));

					if(!$ekle){
						$msg="Hata";
					}

				}else{
					foreach ($logonay->hatalar() as $key) {
						$msg.=$key."<br>";
					}
				}



			}else{
				$msg="hata";
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
					<h2>Ürün Ekle</h2>
					
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
					<form class="form-horizontal form-label-left" action="" method="POST" enctype="multipart/form-data">
						<div class="form-group" >
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="resim"> Ürün Resmi <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="file"  style="width: 100%" name="resim"  class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="urun_ad"> Ürün Adı <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="urun_ad" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="urun_fiyat"> Ürün Fiyatı <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="urun_fiyat" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="urun_kategori"> Ürün Kategori <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" name="urun_kategori">
									<?php 
									
									$katgetir=new Main();

									if($katgetir->verigetir(array("kategori","hepsi"))){
										if($katgetir->sayac()){
											if($katgetir->veri()){
												$x=0;
												foreach ($katgetir->veri() as $key ) { ?>
													<option value="<?php echo $katgetir->veri()[$x]->kt_id ?>"><?php echo $katgetir->veri()[$x]->kt_ad; ?></option>
													<?php
													$x++;
												}
											}else{
												Main::yon("index");
											}
										}else{
											Main::yon("index");
										}
									}else{
										Main::yon("index");
									} ?>
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="urun_icerik"> Ürün İçerik <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="urun_icerik"  class="form-control col-md-7 col-xs-12">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="urun_sira"> Ürün Sıra <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="number" id="first-name" name="urun_sira"  class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="durum"> Ürün Durum <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" name="durum">
									<option value="1">Aktif</option>
									<option value="0">Pasif</option>
								</select>
							</div>
						</div>
						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

								<input type="submit" name="urun_ekle" style="margin-left: 40%"  class="btn btn-success" value="Ekle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>












</div>
<?php include 'footer.php'; ?>