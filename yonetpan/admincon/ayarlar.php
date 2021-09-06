<?php include 'header.php'; 

if(!$kln->yetki(Main::config("yetki/ayarlar"))){
	if(!Session::varmi(Main::config("mesaj/mesaj"))){
		Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/yetkimsg"));
	}
	Main::yon("index");
}elseif(Main::inputcheck("ayarguncelle")){

	if(empty($_FILES['resim']['name']) && $acek->a_url==Main::inputbring("url") && 
		$acek->a_title==Main::inputbring("baslik") && $acek->a_description==Main::inputbring("aciklama") 
		&& $acek->a_keywords==Main::inputbring("anahtar_kelime") && $acek->a_firmaad==Main::inputbring("firmad_adi")){
		$msg="Bütün Veriler Aynı Değişiklik Yapmadınız!";
}else{

	if(empty($_FILES['resim']['name'])){
		
		$guncel=$ayar->veriguncelle(array("guncelle","ayarlar"),array("ayarlar","a_id",$acek->a_id),array(
			"a_url"=>Main::inputbring("url"),
			"a_title"=>Main::inputbring("baslik"),
			"a_description"=>Main::inputbring("aciklama"),
			"a_keywords"=>Main::inputbring("anahtar_kelime"),
			"a_firmaad"=>Main::inputbring("firmad_adi")));

		if(!$guncel){
			$msg="Hata";
		}




	}elseif(isset($_FILES['resim']['name'])){


		$logonay= new Onaylama();

		$logonay->reskontrol(array(
			"resim"=>array(
				"zorunlu"=>true,
				"boyut"=>1024*1024*4
			)));



		if($logonay->tamam()){


			$resyol=DB::resup("../../img");
			$guncel=$ayar->veriguncelle(array("guncelle","ayarlar"),array("ayarlar","a_id",$acek->a_id),array(
				"a_logo"=>$resyol,
				"a_url"=>Main::inputbring("url"),
				"a_title"=>Main::inputbring("baslik"),
				"a_description"=>Main::inputbring("aciklama"),
				"a_keywords"=>Main::inputbring("anahtar_kelime"),
				"a_firmaad"=>Main::inputbring("firmad_adi")));

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
}
}
?>
<div class="right_col" role="main">


	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Genel Ayarlar</h2>

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
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" > Logo <span class="required">*</span>
							</label>
							<img width="400px" height="160px" src="<?php echo $acek->a_logo; ?>"  />
						</div>
						<div class="form-group" >
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="resim"> Logo Değiştir <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="file"  style="width: 100%" name="resim"  class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">  Url <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="last-name" name="url" value="<?php echo $acek->a_url ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="baslik"> Başlık <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="baslik" value="<?php echo $acek->a_title ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="aciklama"> Açıklama <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" class="form-control" value="<?php echo $acek->a_description ?>" name="aciklama" >
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="anahtar_kelime"> Anahtar Kelimeler <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" class="form-control" value="<?php echo $acek->a_keywords ?>" name="anahtar_kelime" >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="firmad_adi"> Firma Adı <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" class="form-control" value="<?php echo $acek->a_firmaad ?>" name="firmad_adi" >
							</div>
						</div>
						
						
						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">	
								<input type="submit" name="ayarguncelle" style="margin-left: 40%"  class="btn btn-success" value="Güncelle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>












</div>
<?php include 'footer.php'; ?>