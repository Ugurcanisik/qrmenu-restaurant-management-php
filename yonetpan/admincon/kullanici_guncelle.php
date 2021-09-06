<?php include 'header.php'; 



if(!$kln->yetki(Main::config("yetki/kullanici"))){
	if(!Session::varmi(Main::config("mesaj/mesaj"))){
		Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/yetkimsg"));
	}
	Main::yon("index"); 
}else{

	if(!Main::inputcheck(null,"get")){

		Main::yon("index"); 
	}else{

		$id=Main::inputbring("id");
		if(!$id){
			Main::yon("index"); 
		}else{
			$a=Onaylama::getonayla($id);
			if($a){
				Main::yon("index"); 
			}else{

				if($klnbul = new Kullanici($id)){
					if($klnbul->sayac()){
						if($klnbul->veri()){
							$klncek=$klnbul->veri();
							
							if(Main::inputcheck("k_guncelle")){

								$onaylama = new Onaylama();

								$a="";
								$b="";

								if($klncek->k_email!=Main::inputbring("email")){
									$a="benzersiz";
									$b=Main::config("tablo/kullanici");
								}

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
										"prag"=>"/^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[com.tr]+$/i",
										$a=>$b),
									"yetki"=>array(
										"zorunlu"=>true)
								));


								if($onaylama->tamam()){


									if($klncek->k_ad==Main::inputbring("ad") && $klncek->k_soyad==Main::inputbring("soyad") && 
										$klncek->k_email==Main::inputbring("email") && $klncek->k_yetki==Main::inputbring("yetki") && $klncek->durum==Main::inputbring("durum")){
										$msg="Bütün Veriler Aynı Değişiklik Yapmadınız";
								}else{

									$guncel=$kln->kullaniciguncelle(array("kguncelle",Main::inputbring("id")),array(
										"k_ad"=>Main::inputbring("ad"),
										"k_soyad"=>Main::inputbring("soyad"),
										"k_email"=>Main::inputbring("email"),
										"k_yetki"=>Main::inputbring("yetki"),
										"durum"=>Main::inputbring("durum")));

									if(!$guncel){
										$msg="Hata";
									}
								}

							}else{
								foreach ($onaylama->hatalar() as $key) {
									$msg.=$key."<br>";
								}
							}
						}

					}else{
						Main::yon("index"); 
					}

				}else{
					Main::yon("index"); 
				}


			}else{
				Main::yon("index"); 
			}


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
					<h2>Kullanıcı Ayarları</h2>
					
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ad"> Ad <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="ad" value="<?php echo $klncek->k_ad ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="soyad"> Soyad <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="last-name" name="soyad" value="<?php echo $klncek->k_soyad ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"> Email <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="email" value="<?php echo $klncek->k_email ?>" class="form-control col-md-7 col-xs-12">
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
												$i=0;
												foreach ($kln->veri() as $key) {
													
													if($klncek->k_yetki==$kln->veri()[$i]->y_id){ ?>
														<option selected="" value="<?php echo $kln->veri()[$i]->y_id  ?>"><?php echo $kln->veri()[$i]->y_adi; ?></option>

													<?php }else{ ?>
														<option value="<?php echo $kln->veri()[$i]->y_id  ?>"><?php echo $kln->veri()[$i]->y_adi; ?></option>
														<?php
													}
													$i++;
												}
											}else{
												Main::yon("index");
											}
										}else{
											Main::yon("index");
										}
									}else{
										Main::yon("index");
									} 
									?>
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="durum"> Durum <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" name="durum">
									<?php
									if($klncek->durum==true){
										echo "<option selected value='1' >Aktif</option>"; 
										echo "<option value='0' >Pasif</option>";
									}elseif($klncek->durum==false){
										echo "<option selected value='0' >Pasif</option>"; 
										echo "<option value='1' >Aktif</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<input type="hidden" name="id" value="<?php echo $id ?>" >
								<input type="submit" name="k_guncelle" style="margin-left: 40%"  class="btn btn-success" value="Güncelle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>












</div>
<?php include 'footer.php'; ?>