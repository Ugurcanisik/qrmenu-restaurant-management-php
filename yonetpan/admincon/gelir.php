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
				<h2>Gelirler</small></h2>
				<a href="gelir_ekle" style="position: relative; float: right;" class="btn btn-success" >Gelir Ekle</a>
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
					<p>Bu Ayki Toplam Ciro: <?php 

					$ciro = new Main();
					$now = date('m');
					$like = "_____$now%";
					$ciro->verigetir(array("gelir","ciro",$like));
					echo $ciro->veri()->ciro."₺";


				?></p>
			</center>
			<table id="datatable" class="table table-striped table-bordered">
				<thead>
					<tr>

						<th style="text-align: center;">Tarih</th>
						<th style="text-align: center;">Toplam</th>
						<th style="text-align: center;">Güncelle</th>
						<th style="text-align: center;">Sil</th>
					</tr>
				</thead>


				<tbody>

					<?php 

					$urun= new Main();
					$urun->verigetir(array("gelir","graf",$like));




					if($urun->sayac()>1){
						foreach ($urun->veri() as $key) { ?>
							<tr>
								<td style="text-align: center;"><?php echo $key->tarih; ?></td>
								<td style="text-align: center;"><?php echo $key->toplam; ?></td>


								<td style="text-align: center;" ><a href="gelir_guncelle?id=<?php echo $key->g_id ?>"><input type="button" class="btn btn-success" name="Güncelle" value="Güncelle"></a></td>

								<td style="text-align: center;" ><a href="gelir_sil?id=<?php echo$key->g_id ?>"><input type="button" class="btn btn-danger" name="sil" value="Sil"></a></td>
							</tr>

						<?php 	}


					}else{ ?>
						<tr>
							<td style="text-align: center;"><?php echo $urun->veri()->tarih; ?></td>
							<td style="text-align: center;"><?php echo $urun->veri()->toplam; ?></td>


							<td style="text-align: center;" ><a href="gelir_guncelle?id=<?php echo $urun->veri()->g_id ?>"><input type="button" class="btn btn-success" name="Güncelle" value="Güncelle"></a></td>

							<td style="text-align: center;" ><a href="gelir_sil?id=<?php echo $urun->veri()->g_id ?>"><input type="button" class="btn btn-danger" name="sil" value="Sil"></a></td>
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