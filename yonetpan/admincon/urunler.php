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
				<h2>Ürünler</small></h2>
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
				
				<table id="datatable" class="table table-striped table-bordered">
					<thead>
						<tr>

							<th style="text-align: center;">Ürün Adı</th>
							<th style="text-align: center;">Ürün Fiyatı</th>
							<th style="text-align: center;">Ürün Kategorisi</th>
							<th style="text-align: center;">Ürün İçerik</th>
							<th style="text-align: center;">Ürün Resim</th>
							<th style="text-align: center;">Ürün Sıra</th>
							<th style="text-align: center;">Ürün Durum</th>
							<th style="text-align: center;">Güncelle</th>
							<th style="text-align: center;">Sil</th>
						</tr>
					</thead>


					<tbody>
						
						<?php 

						$urun= new Main();

						if($urun->verigetir(array("urunler","hepsi"))){
							if($urun->sayac()){
								if($urun->veri()){
									$x=0;
									foreach ($urun->veri() as $key) { ?>
										<tr>
											<td style="text-align: center;"><?php echo $urun->veri()[$x]->u_ad; ?></td>
											<td style="text-align: center;"><?php echo $urun->veri()[$x]->u_fiyat; ?></td>
											<td style="text-align: center;" >
												<?php 
												$katad= new Main();
												$katad->verigetir(array("kategori","sorgu","kt_id","=",$urun->veri()[$x]->u_kategori));
												echo $katad->veri()->kt_ad;
												?>
											</td>
											<td style="text-align: center;" ><?php echo $urun->veri()[$x]->u_icerik; ?> </td>
											<td style="text-align: center;" ><?php 
											if(strlen($urun->veri()[$x]->u_resim)>0){
												echo "var";
											}else{
												echo "yok";
											}?> </td>
											<td style="text-align: center;"><?php echo $urun->veri()[$x]->sira;?></td>
											<td style="text-align: center;" ><?php if($urun->veri()[$x]->durum==true) echo "Aktif"; elseif($urun->veri()[$x]->u_durum==false) echo "Pasif" ;?></td>
											<td style="text-align: center;" ><a href="urun_guncelle?id=<?php echo $urun->veri()[$x]->u_id ?>"><input type="button" class="btn btn-success" name="Güncelle" value="Güncelle"></a></td>

											<td style="text-align: center;" ><a href="urun_sil?id=<?php echo $urun->veri()[$x]->u_id ?>"><input type="button" class="btn btn-danger" name="sil" value="Sil"></a></td>
										</tr>

										<?php $x++;	}
										
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

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<?php include 'footer.php' ?>