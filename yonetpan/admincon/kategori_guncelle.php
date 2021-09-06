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
				if($ktbul = new Main(array("kategori","kt_id",$id))){
					if($ktbul->sayac()){
						if($ktbul->veri()){
							$ktcek=$ktbul->veri();

							if(Main::inputcheck("kt_guncelle")){

								$onaylama = new Onaylama();




								$onaylama->kontrol($_POST,array(
									"kategori_ad"=>array(
										"zorunlu"=>true,
										"min"=>3,
										"max"=>50,
										"prag"=>"/^[0-9a-zçÇğĞİıIöÖşŞüÜ ]+$/i"),
									"kt_yukseklik"=>array(
										"zorunlu"=>true,
										"min"=>1,
										"max"=>50,
										"prag"=>"/^[0-9]+$/i"),
									"kategori_sira"=>array(
										"zorunlu"=>true,
										"min"=>1,
										"max"=>10,
										"prag"=>"/^[0-9]+$/i")
								));


								if($onaylama->tamam()){


									if($ktcek->kt_yukseklik==Main::inputbring("kt_yukseklik") && $ktcek->sira==Main::inputbring("kategori_sira") && $ktcek->kt_ad==Main::inputbring("kategori_ad") && $ktcek->durum==Main::inputbring("durum")){
										$msg="Bütün Veriler Aynı Değişiklik Yapmadınız";
									}else{

										$guncel=$ktbul->veriguncelle(array("guncelle","kategori_guncelle?id=$id"),array("kategori","kt_id",Main::inputbring("id")),array(
											"kt_ad"=>Main::inputbring("kategori_ad"),
											"kt_yukseklik"=>Main::inputbring("kt_yukseklik"),
											"sira"=>Main::inputbring("kategori_sira"),
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
					<h2>Kategori Güncelle</h2>
					
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_ad"> Kategori Adı <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="kategori_ad" value="<?php echo $ktcek->kt_ad ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_sira"> Kategori Sira <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="number" id="first-name" name="kategori_sira" value="<?php echo $ktcek->sira ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kt_ad"> Kategori Yükseklik <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="number" id="first-name" name="kt_yukseklik" value="<?php echo $ktcek->kt_yukseklik ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="durum"> Durum <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" name="durum">
									<?php
									if($ktcek->durum==true){
										echo "<option selected value='1' >Aktif</option>"; 
										echo "<option value='0' >Pasif</option>";
									}elseif($ktcek->durum==false){
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
								<input type="submit" name="kt_guncelle" style="margin-left: 40%"  class="btn btn-success" value="Güncelle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>












</div>
<?php include 'footer.php'; ?>