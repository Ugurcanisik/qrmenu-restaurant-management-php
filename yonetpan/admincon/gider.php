<?php include 'header.php';

if(!$kln->yetki(Main::config("yetki/urunler"))){
	if(!Session::varmi(Main::config("mesaj/mesaj"))){
		Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/yetkimsg"));
	}
	Main::yon("index");
}

?>

<div class="right_col" role="main">

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Giderler</small></h2>
				<a href="giderturu_ekle" style="position: relative; float: right;" class="btn btn-success" >Gider Turu Ekle</a>
				<a href="gider_ekle" style="position: relative; float: right;" class="btn btn-success" >Gider Ekle</a>

				<div class="clearfix"></div>
				<p>
					<?php 	
					if(Session::varmi(Main::config("mesaj/mesaj"))){
						$msg=Session::mesaj(Main::config("mesaj/mesaj"));
					}
					?>
					<div style="width: 300px; height: <?php echo strlen($msg); ?> px"><?php echo $msg; ?></div>
				</p>
			</div>
			<div class="x_content">
				<center>
					<p>Bu Ayki Toplam Gider: <?php 

					$gider = new Main();

					$now = date('m');

					$like = "_____$now%";
					
					$gider->verigetir(array("gider","ciro",$like));
					echo $gider->veri()->ciro."₺";




				?></p>
			</center>
			<table id="datatable" class="table table-striped table-bordered">
				<thead>
					<tr>

						<th style="text-align: center;">Tarih</th>
						<th style="text-align: center;">Tür</th>
						<th style="text-align: center;">Açıklama</th>
						<th style="text-align: center;">Alacak</th>
						<th style="text-align: center;">Toplam</th>
						<th style="text-align: center;">Güncelle</th>
						<th style="text-align: center;">Sil</th>
					</tr>
				</thead>


				<tbody>

					<?php 

					$urun= new Main();
					$urun->verigetir(array("gider","graf",$like));

					


					if($urun->sayac()>1){
						foreach ($urun->veri() as $key) { ?>
							<tr>
								<td style="text-align: center;"><?php echo $key->tarih; ?></td>
								<td style="text-align: center;" >
									<?php 
									$katad= new Main();
									$katad->verigetir(array("giderturu","sorgu","g_id","=",$key->turu));
									echo $katad->veri()->ad;
									?>
								</td>
								<td style="text-align: center;"><?php echo $key->aciklama; ?></td>
								<td style="text-align: center;"><?php echo $key->maas; ?></td>
								<td style="text-align: center;"><?php echo $key->toplam; ?></td>

								<td style="text-align: center;" ><a href="gider_guncelle?id=<?php echo $key->g_id ?>"><input type="button" class="btn btn-success" name="Güncelle" value="Güncelle"></a></td>

								<td style="text-align: center;" ><a href="gider_sil?id=<?php echo$key->g_id ?>"><input type="button" class="btn btn-danger" name="sil" value="Sil"></a></td>
							</tr>

						<?php 	}


					}else{ ?>
						<tr>
							<td style="text-align: center;"><?php echo $urun->veri()->tarih; ?></td>
							<td style="text-align: center;" >
								<?php 
								$katad= new Main();
								$katad->verigetir(array("giderturu","sorgu","g_id","=",$urun->veri()->turu));
								echo $katad->veri()->ad;
								?>
							</td>
							<td style="text-align: center;"><?php echo $urun->veri()->aciklama; ?></td>
							<td style="text-align: center;"><?php echo $urun->veri()->maas; ?></td>
							<td style="text-align: center;"><?php echo $urun->veri()->toplam; ?></td>

							<td style="text-align: center;" ><a href="gider_guncelle?id=<?php echo $urun->veri()->g_id ?>"><input type="button" class="btn btn-success" name="Güncelle" value="Güncelle"></a></td>

							<td style="text-align: center;" ><a href="gider_sil?id=<?php echo $urun->veri()->g_id ?>"><input type="button" class="btn btn-danger" name="sil" value="Sil"></a></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
</div>


<?php include 'footer.php' ?>