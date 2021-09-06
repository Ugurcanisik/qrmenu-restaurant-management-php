<?php include 'header.php'; ?>


<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



<?php 
$toptutar=null;
$dizi=[];

if(!$kln->yetki(Main::config("yetki/urunler"))){
	if(!Session::varmi(Main::config("mesaj/mesaj"))){
		Session::mesaj(Main::config("mesaj/mesaj"),Main::config("mesaj/yetkimsg"));
	}
	Main::yon("index"); 
}else{
	if(Main::inputcheck("sorgu")){


		$onaylama = new Onaylama();

		$onaylama->kontrol($_POST,array(

			"alan"=>array(
				"zorunlu"=>true,
				"min"=>1	
			),
			"tarihler"=>array(
				"zorunlu"=>true,
				"min"=>1)
		));

		

		if($onaylama->tamam()){


			$alldate = explode("/", Main::inputbring("tarihler"));

			$start = $alldate[0];

			$end = $alldate[1];


			$raportur = Main::inputbring("alan");

			$sorgu = new Main();
			

			if($raportur=="gelir" || $raportur=="gider"){

				$sorgu->verigetir(array($raportur,"raporgg",$start,$end));

			}else{

				$sorgu->verigetir(array("gider","raportur",$start,$end,$raportur));

			}


		}else{
			foreach ($onaylama->hatalar() as $key) {
				$msg.=$key."<br>";
			}
		}
	}elseif(Main::inputcheck('excelaktar')){


		$alldate = explode("/", Main::inputbring("tarihler"));

		$start = $alldate[0];

		$end = $alldate[1];


		$raportur = Main::inputbring("alan");


		header("location: excelaktar.php?start=$start&end=$end&tur=$raportur");



	}

}




?>
<div class="right_col" role="main">


	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Raporlar</h2>
					
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
							
							
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_ad">Alan <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" name="alan">
									<option value="0">Seçiniz</option>
									<option value="gelir">Toplam Gelir</option>
									<option value="gider">Toplam Gider</option>
									<?php 

									$katgetir=new Main();

									if($katgetir->verigetir(array("giderturu","order","ad","asc"))){
										if($katgetir->sayac()){


											foreach ($katgetir->veri() as $key ) { ?>
												<option value="<?php echo $key->g_id ?>"><?php echo $key->ad; ?></option>
												<?php

											}

										}else{
											// Main::yon("index");
										}
									}else{
										// Main::yon("index");
									} ?>



								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ad"> Tarih Seçiniz <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div id="reportrange"  style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
									<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
									<span></span> <b class="caret"></b>
									<input type="hidden" id="tarih" value="" name="tarihler">
								</div>
								

							</div>
						</div>


						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

								<input type="submit" name="sorgu" style="margin-left: 40%"  class="btn btn-success" value="Sorgula">
								<input type="submit" style="position:relative;" name="excelaktar" class="btn btn-success" value="Excel">	
							</div>
						</div>
					</form>


					<?php if(Main::inputcheck("sorgu")){


						

						if($raportur=="gelir"){ ?>

							<table id="datatable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th style="text-align: center;">Tarih</th>
										<th style="text-align: center;">Toplam</th>
										>
									</tr>
								</thead>


								<tbody>

									<?php 

									foreach ($sorgu->veri() as $key) { ?>
										<tr>
											<td style="text-align: center;"><?php echo $key->tarih; ?></td>
											<td style="text-align: center;"><?php echo $key->toplam; ?></td>
										</tr>

										<?php 	
										$toptutar+=$key->toplam;

									}  

									?>

								</tbody>
							</table>


						<?php }else{ ?>

							<table id="datatable" class="table table-striped table-bordered">
								<thead>
									<tr>

										<th style="text-align: center;">Tarih</th>
										<th style="text-align: center;">Tür</th>
										<th style="text-align: center;">Açıklama</th>
										<th style="text-align: center;">Alacak</th>
										<th style="text-align: center;">Toplam</th>

									</tr>
								</thead>


								<tbody>

									<?php 

									foreach ($sorgu->veri() as $key) { ?>
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

											<?php 	}   ?>

									</tbody>
								</table>

							<?php } 

						}

						?>


						<div class="ln_solid"></div>

						<center>
							<p style="font-size:24px">
								<?php 
								if($toptutar) {
									echo "Toplam:".$toptutar." ₺";
									
								}
								?>

							</p>
							
						</center>




					</div>
				</div>
			</div>
		</div>




	</div>
	<script type="text/javascript">

		$(function() {

			var start = moment().subtract(29, 'days');
			var end = moment();

			function cb(start, end) {
				$('#reportrange span').html(start.format('YYYY-MM-D') + '   -   ' + end.format('YYYY-MM-D'));
				$('#tarih').val(start.format('YYYY-MM-D') + '/' + end.format('YYYY-MM-D'));
			}

			$('#reportrange').daterangepicker({
				name:'sec',
				startDate: start,
				endDate: end,
				showDropdowns: true,
				showWeekNumbers: true,
				timePicker: false,
				timePickerIncrement: 1,
				opens:'right',
				applyClass: 'btn-small btn-primary app',
				ranges: {
					'Bugun': [moment(), moment()],
					'Dün': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Son 7 Gün': [moment().subtract(6, 'days'), moment()],
					'Son 30 Gün': [moment().subtract(29, 'days'), moment()],
					'Bu Ay': [moment().startOf('month'), moment().endOf('month')],
					'Geçen Ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
					'Son 3 Ay': [moment().subtract(2, 'month').startOf('month'), moment().subtract(0, 'month').endOf('month')]
				},
				locale: {
					applyLabel: 'Kaydet',
					cancelLabel: 'İptal',
					fromLabel: 'From',
					toLabel: 'To',
					customRangeLabel: 'Tarih Aralığı Seçiniz',
					daysOfWeek: [" ","Oca", "Şub", "Mar", "Nis", "May", "Haz", "Tem"],
					monthNames: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Agustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
					firstDay: 1
				}
			}, cb);

			cb(start, end);



		});


	</script>
	<?php include 'footer.php'; ?>