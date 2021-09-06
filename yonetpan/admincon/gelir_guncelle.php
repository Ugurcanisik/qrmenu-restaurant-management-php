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
				if($ktbul = new Main(array("gelir","g_id",$id))){
					if($ktbul->sayac()){

						$ktcek=$ktbul->veri();

						if(Main::inputcheck("gelir_guncelle")){

							$onaylama = new Onaylama();

							$onaylama->kontrol($_POST,array(

								"gelir"=>array(
									"zorunlu"=>true,
									"min"=>1,
									"max"=>50,
									"prag"=>"/^[0-9.]+$/i")
							));


							if($onaylama->tamam()){


								if($ktcek->toplam==Main::inputbring("gelir")){
									$msg="Bütün Veriler Aynı Değişiklik Yapmadınız";
								}else{

									$guncel=$ktbul->veriguncelle(
										array("guncelle","gelir_guncelle?id=$id"),array("gelir","g_id",Main::inputbring("id")),
										array(
											"toplam"=>Main::inputbring("gelir")
										));

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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_ad"> Ciro <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="first-name" name="gelir" value="<?php echo $ktcek->toplam ?>" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<input type="hidden" name="id" value="<?php echo $id ?>" >
								<input type="submit" name="gelir_guncelle" style="margin-left: 40%"  class="btn btn-success" value="Güncelle">	
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>












</div>
<?php include 'footer.php'; ?>