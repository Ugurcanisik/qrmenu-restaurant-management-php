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
				<h2>Kategoriler</small></h2>
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

							<th style="text-align: center;">Kategori Adı</th>
							<th style="text-align: center;">Kategori Sira</th>
							<th style="text-align: center;">Kategori Yükseklik</th>
							<th style="text-align: center;">Kategori Durum</th>
							<th style="text-align: center;">Güncelle</th>
							<th style="text-align: center;">Sil</th>
						</tr>
					</thead>


					<tbody>
						
						<?php 

						$katgetir= new Main();

						if($katgetir->verigetir(array("kategori","hepsi"))){
							if($katgetir->sayac()){
								if($katgetir->veri()){
									$x=0;
									foreach ($katgetir->veri() as $key) { ?>
										<tr>
											<td style="text-align: center;"><?php echo $katgetir->veri()[$x]->kt_ad; ?></td>
											<td style="text-align: center;"><?php echo $katgetir->veri()[$x]->sira; ?></td>
											<td style="text-align: center;"><?php echo $katgetir->veri()[$x]->kt_yukseklik; ?>px</td>
											<td style="text-align: center;" ><?php if($katgetir->veri()[$x]->durum==true) echo "Aktif"; elseif($katgetir->veri()[$x]->durum==false) echo "Pasif" ;?></td>
											<td style="text-align: center;" ><a href="kategori_guncelle?id=<?php echo $katgetir->veri()[$x]->kt_id ?>"><input type="button" class="btn btn-success" name="Güncelle" value="Güncelle"></a></td>

											<td style="text-align: center;" ><a href="kategori_sil?id=<?php echo $katgetir->veri()[$x]->kt_id ?>"><input type="button" class="btn btn-danger" name="sil" value="Sil"></a></td>
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