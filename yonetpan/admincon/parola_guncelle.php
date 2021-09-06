<?php include 'header.php'; 

if(Main::inputcheck("k_parola_guncelle")){

	$onaylama = new Onaylama();
	$onaylama->kontrol($_POST,array(
		"mevcut_parola"=>array(
			"zorunlu"=>true,
			"min"=>3,
			"max"=>50,
			"pw"=>"pw"),
		"yeni_parola"=>array(
			"zorunlu"=>true,
			"min"=>3,
			"max"=>50,
			"pw"=>"pw"),
		"yeni_parola_tekrar"=>array(
			"zorunlu"=>true,
			"min"=>3,
			"max"=>60,
			"pw"=>"pw",
			"eslesme"=>"yeni_parola")
	));


	if($onaylama->tamam()){


		if(Hash::olustur(Main::inputbring("yeni_parola"),$kveri->k_salt)==$kveri->k_parola){
			$msg="Parolanız Aynı Değişiklik yapmadınız";
		}else{

			$guncel=$kln->kullaniciguncelle(array("kparola",$kveri->k_salt),array(
				"k_parola"=>Hash::olustur(Main::inputbring("yeni_parola"),$kveri->k_salt)));

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
					<h2>Parola Güncelleme</h2>
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="mevcut_parola"> Mevcut Parola <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="mevcut_parola" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="yeni_parola"> Yeni Parola <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="last-name" name="yeni_parola" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="yeni_parola_tekrar"> Yeni Parola Tekrar <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="yeni_parola_tekrar"  class="form-control col-md-7 col-xs-12">
							</div>
						</div>	
						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<input type="submit" name="k_parola_guncelle" style="margin-left: 40%"  class="btn btn-success" value="Güncelle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>












</div>
<?php include 'footer.php'; ?>