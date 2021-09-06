$(document).ready(function(){




	$('#aciklama').hide();
	$('#maas').hide();






	$('#tursec').change(function () {
		var optionSelected = $(this).find("option:selected");
		var valueSelected  = optionSelected.val();
		var textSelected   = optionSelected.text();



		if(textSelected=="Diğer" || textSelected=="Online Alışveriş"){
			$('#aciklama').show();
		}else{
			$('#aciklama').hide();
		}


		if(textSelected=="Maaş"){
			$('#maas').show();
		}else{
			$('#maas').hide();
		}


	});











});


