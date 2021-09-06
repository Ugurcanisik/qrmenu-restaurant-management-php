 $(document).ready(function(){
 	$("ul li a").on('click', function(event) {
 		var id=$(this).attr("id");
 		id+="2";
 		event.preventDefault();
 		if (this.hash !== "") {

 			var hash = this.hash;

 			$('html, body').animate({
 				scrollTop: $(hash).offset().top
 			}, 2000, function(){

 				window.location.hash = hash;


				 
 				setTimeout(function() {
 					var a = document.getElementsByClassName(id);
 					for (i = 0; i < a.length; i++) {

 						a[i].style.animation = "blinker 0.9s linear infinite";
 					}
 					setTimeout(function() {
 						var a = document.getElementsByClassName(id);
 						for (i = 0; i < a.length; i++) {

 							a[i].style.animation = "";
 						}
 					}, 1000);

 				}, 1);
 			});
 		}
 	});
 });



 $(function(){
 	$('#top').click(function () {

 		$('body,html').animate({
 			scrollTop: 0
 		}, 600);


 	});

 	$(window).scroll(function () {

 		if ($(this).scrollTop() > 15) {
 			$('.totop a').fadeIn(500);
 		} else {
 			$('.totop a').fadeOut(500);
 		}
		 


 	});
 });


