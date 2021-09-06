<?php include 'header.php'; 


if(!$kln->yetki(Main::config("yetki/urunler"))){
	if(!Session::varmi(Main::config("mesaj/mesaj"))){
		Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/yetkimsg"));
	}
	Main::yon("index"); 
}else{
	if(Main::inputbring("kategori_ekle")){

		$onaylama = new Onaylama();

		$onaylama->kontrol($_POST,array(
			"kategori_ad"=>array(
				"zorunlu"=>true,
				"min"=>3,
				"max"=>50,
				"prag"=>"/^[a-zçÇğĞİıIöÖşŞüÜ ]+$/i"),
			"kategori_yukseklik"=>array(
				"zorunlu"=>true,
				"min"=>1,
				"max"=>50,
				"prag"=>"/^[0-9]+$/i"),
			"kategori_sira"=>array(
				"zorunlu"=>true,
				"min"=>1,
				"max"=>10,
				"prag"=>"/^[0-9]+$/i"),
			"durum"=>array(
				"zorunlu"=>true)
		));


		if($onaylama->tamam()){


			$katekle= new Main();

			$ekle=$katekle->veriekle(array("kategori","kategoriler"),array(
				"kt_ad"=>Main::inputbring("kategori_ad"),
				"kt_yukseklik"=>Main::inputbring("kategori_yukseklik"),
				"sira"=>Main::inputbring("kategori_sira"),
				"durum"=>Main::inputbring("durum")
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
					<h2>Kategori Ekle</h2>
					
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_ad">Kategori Adı <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="kategori_ad" class="form-control col-md-7 col-xs-12">
							</div>
						</div>


						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_sira">Kategori Sira <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="number" id="first-name" name="kategori_sira" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_sira">Kategori Yukseklik <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="number" id="first-name" name="kategori_yukseklik" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="durum">Kategori Durumu <span class="required">*</span>
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

								<input type="submit" name="kategori_ekle" style="margin-left: 40%"  class="btn btn-success" value="Ekle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>












</div>
<?php include 'footer.php'; ?>