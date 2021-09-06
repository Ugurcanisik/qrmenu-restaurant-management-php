<?php include 'header.php'; 



if(!$kln->yetki(Main::config("yetki/urunler"))){
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
				if(!$urunbul = new Main(array("urunler","u_id",$id))){
					Main::yon("index");
				}else{
					if(!$urunbul->sayac()){
						Main::yon("index");
					}else{
						if(!$urunbul->veri()){
							Main::yon("index");
						}else{
							$uruncek=$urunbul->veri();

							if(Main::inputcheck("u_guncelle")){

								if(empty($_FILES['resim']['name']) && $uruncek->u_ad==Main::inputbring("urun_ad") && $uruncek->u_fiyat==Main::inputbring("urun_fiyat") && 
									$uruncek->u_kategori==Main::inputbring("urun_kategori") && $uruncek->u_icerik==Main::inputbring("urun_icerik") && $uruncek->sira==Main::inputbring("urun_sira") && $uruncek->durum==Main::inputbring("durum")){
									$msg="Bütün Veriler Aynı Değişiklik Yapmadınız";
							}else{
								$onaylama = new Onaylama();
								$onaylama->kontrol($_POST,array(
									"urun_ad"=>array(
										"zorunlu"=>true,
										"min"=>1,
										"max"=>50,
										"prag"=>"/^[0-9a-zçÇğĞİıIöÖşŞüÜ()\/\., ]+$/i"),
									"urun_sira"=>array(
										"zorunlu"=>true,
										"min"=>1,
										"max"=>10,
										"prag"=>"/^[0-9]+$/i")
								));



								if($onaylama->tamam()){

									if(empty($_FILES['resim']['name'])){

										$guncel=$urunbul->veriguncelle(array("guncelle","urun_guncelle?id=$id"),array("urunler","u_id",Main::inputbring("id")),array(
											"u_ad"=>Main::inputbring("urun_ad"),
											"u_fiyat"=>Main::inputbring("urun_fiyat"),
											"u_kategori"=>Main::inputbring("urun_kategori"),
											"u_icerik"=>Main::inputbring("urun_icerik"),
											"sira"=>Main::inputbring("urun_sira"),
											"durum"=>Main::inputbring("durum")));

										if(!$guncel){
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

											$guncel=$urunbul->veriguncelle(array("guncelle","urun_guncelle?id=$id"),array("urunler","u_id",Main::inputbring("id")),array(
												"u_resim"=>$resyol,
												"u_ad"=>Main::inputbring("urun_ad"),
												"u_fiyat"=>Main::inputbring("urun_fiyat"),
												"u_kategori"=>Main::inputbring("urun_kategori"),
												"u_icerik"=>Main::inputbring("urun_icerik"),
												"sira"=>Main::inputbring("urun_sira"),
												"durum"=>Main::inputbring("durum")),Main::inputbring("id"));

											if(!$guncel){
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
					}
				}
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
					<h2>Ürün Güncelle</h2>
				
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
								<input type="text" id="first-name" name="urun_ad" value="<?php echo $uruncek->u_ad ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="urun_fiyat"> Ürün Fiyatı <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="urun_fiyat" value="<?php echo $uruncek->u_fiyat ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="urun_kategori"> Ürün Kateogorisi <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" name="urun_kategori">
									<?php 
									$urunkt= new Main();
									if($urunkt->verigetir(array("kategori","hepsi"))){
										if($urunkt->sayac()){
											if($urunkt->veri()){
												$i=0;
												foreach ($urunkt->veri() as $key) {							
													if($urunkt->veri()[$i]->kt_id==$uruncek->u_kategori){ ?>
														<option selected="" value="<?php echo $urunkt->veri()[$i]->kt_id  ?>"><?php echo $urunkt->veri()[$i]->kt_ad; ?></option>

													<?php }else{ ?>
														<option value="<?php echo $urunkt->veri()[$i]->kt_id  ?>"><?php echo $urunkt->veri()[$i]->kt_ad; ?></option>
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="urun_icerik"> Ürün İçerik <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="urun_icerik" value="<?php echo $uruncek->u_icerik ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="urun_sira"> Ürün Sıra <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="number" id="first-name" name="urun_sira" value="<?php echo $uruncek->sira ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="durum"> Durum <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" name="durum">
									<?php
									if($uruncek->durum==true){
										echo "<option selected value='1' >Aktif</option>"; 
										echo "<option value='0' >Pasif</option>";
									}elseif($uruncek->durum==false){
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
								<input type="submit" name="u_guncelle" style="margin-left: 40%"  class="btn btn-success" value="Güncelle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>












</div>
<?php include 'footer.php'; ?>