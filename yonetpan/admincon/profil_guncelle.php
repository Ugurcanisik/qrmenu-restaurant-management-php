<?php include 'header.php'; 



if(Main::inputcheck("k_profil_guncelle")){

	$a="";
	$b="";

	if($kveri->k_email!=Main::inputbring("email")){
		$a="benzersiz";
		$b=Main::config("tablo/kullanici");
	}

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
			"prag"=>"/^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[com.tr]+$/i",
			$a=>$b)
	));


	if($onaylama->tamam()){


		if($kveri->k_ad==Main::inputbring("ad") && $kveri->k_soyad==Main::inputbring("soyad") && 
			$kveri->k_email==Main::inputbring("email")){
			$msg="Bütün Veriler Aynı Değişiklik Yapmadınız";
	}else{


		$guncel=$kln->kullaniciguncelle(array("kprofil",$kveri->k_salt),array(
			"k_ad"=>Main::inputbring("ad"),
			"k_soyad"=>Main::inputbring("soyad"),
			"k_email"=>Main::inputbring("email")));

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


?>
<div class="right_col" role="main">


	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Profil Güncelleme</h2>

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
								<input type="text" id="first-name" name="ad" value="<?php echo $kveri->k_ad ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="soyad"> Soyad <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="last-name" name="soyad" value="<?php echo $kveri->k_soyad ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"> Email <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="email" value="<?php echo $kveri->k_email ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="yetki"> Yetki <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" class="form-control" value="<?php echo $kln->yetkiadi(); ?>" name="yetki" disabled>
							</div>
						</div>	

						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<input type="submit" name="k_profil_guncelle" style="margin-left: 40%"  class="btn btn-success" value="Güncelle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>

</div>
<?php include 'footer.php'; ?>