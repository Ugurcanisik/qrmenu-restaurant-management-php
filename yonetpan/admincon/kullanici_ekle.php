<?php include 'header.php'; 


if(!$kln->yetki(Main::config("yetki/kullanici"))){
	if(!Session::varmi(Main::config("mesaj/mesaj"))){
		Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/yetkimsg"));
	}
	Main::yon("index"); 
}else{
	if(Main::inputcheck("k_ekle")){

		$onaylama = new Onaylama();

		$onaylama->kontrol($_POST,array(
			"ad"=>array(
				"zorunlu"=>true,
				"min"=>3,
				"max"=>50,
				"prag"=>"/^[a-zçÇğĞİıIöÖşŞüÜ ]+$/i"),
			"soyad"=>array(
				"zorunlu"=>true,
				"min"=>2,
				"max"=>50,
				"prag"=>"/^[a-zçÇğĞİıIöÖşŞüÜ ]+$/i"),
			"email"=>array(
				"zorunlu"=>true,
				"min"=>10,
				"max"=>60,
				"benzersiz"=>Main::config("tablo/kullanici"),
				"prag"=>"/^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[com.tr]+$/i"),
			"parola"=>array(
				"zorunlu"=>true,
				"min"=>3,
				"max"=>50,
				"pw"=>"pw"),
			"yetki"=>array(
				"zorunlu"=>true),
			"durum"=>array(
				"zorunlu"=>true)
		));


		if($onaylama->tamam()){

			$salt=Hash::salt();

			$ekle=$kln->kullaniciekle(array(
				"k_ad"=>Main::inputbring("ad"),
				"k_soyad"=>Main::inputbring("soyad"),
				"k_email"=>Main::inputbring("email"),
				"k_parola"=>Hash::olustur(Main::inputbring("parola"),$salt),
				"k_salt"=>$salt,
				"k_yetki"=>Main::inputbring("yetki"),
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
					<h2>Kullanıcı Ekle</h2>
					
					<div class="clearfix"></div>
					<div style="width: 300px; height: <?php echo strlen($msg); ?> px"><?php echo $msg; ?></div>
				</div>

				<div class="x_content">
					<br />
					<form class="form-horizontal form-label-left" action="" method="POST">

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ad"> Ad <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="ad" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="soyad"> Soyad <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="last-name" name="soyad"  class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"> Email <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="email"  class="form-control col-md-7 col-xs-12">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="parola"> Parola <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="parola"  class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="yetki"> Yetki <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" name="yetki">
									<?php 
									
									if($kln->yetkigetir()){
										if($kln->sayac()){
											if($kln->veri()){
												$x=0;
												foreach ($kln->veri() as $key ) { ?>
													<option value="<?php echo $kln->veri()[$x]->y_id ?>"><?php echo $kln->veri()[$x]->y_adi; ?></option>
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="durum"> Durum <span class="required">*</span>
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

								<input type="submit" name="k_ekle" style="margin-left: 40%"  class="btn btn-success" value="Ekle">	
								
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>












</div>
<?php include 'footer.php'; ?>