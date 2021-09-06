<?php include 'header.php';

if(!$kln->yetki(Main::config("yetki/kullanici"))){
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
				<h2>Kullanıcılar</small></h2>
				
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

							<th style="text-align: center;">Ad</th>
							<th style="text-align: center;">Soyad</th>
							<th style="text-align: center;">Email</th>
							<th style="text-align: center;">Yetki</th>
							<th style="text-align: center;">Durum</th>
							<th style="text-align: center;">Güncelle</th>
							<th style="text-align: center;">Sil</th>
						</tr>
					</thead>


					<tbody>
						
						<?php 

						
						if($kln->kullanicigetir()){
							if($kln->sayac()){
								if($kln->veri()){
									$x=0;
									foreach ($kln->veri() as $key) {

										if($kveri->k_salt==$kln->veri()[$x]->k_salt){
											$x++;
											continue;

										}else{ ?>
											<tr>
												<td style="text-align: center;"><?php echo $kln->veri()[$x]->k_ad; ?></td>
												<td style="text-align: center;" ><?php echo $kln->veri()[$x]->k_soyad; ?> </td>
												<td style="text-align: center;" ><?php echo $kln->veri()[$x]->k_email; ?> </td>
												<td style="text-align: center;"><?php echo $kln->yetkiler()[$x];?></td>
												<td style="text-align: center;" ><?php if($kln->veri()[$x]->durum==true) echo "Aktif"; elseif($kln->veri()[$x]->durum==false) echo "Pasif" ;?></td>
												<td style="text-align: center;" ><a href="kullanici_guncelle?id=<?php echo $kln->veri()[$x]->k_salt ?>"><input type="button" class="btn btn-success" name="Güncelle" value="Güncelle"></a></td>

												<td style="text-align: center;" ><a href="kullanici_sil?id=<?php echo $kln->veri()[$x]->k_salt ?>"><input type="button" class="btn btn-danger" name="sil" value="Sil"></a></td>
											</tr>

										<?php	}
										$x++;
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
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>


<?php include 'footer.php' ?>