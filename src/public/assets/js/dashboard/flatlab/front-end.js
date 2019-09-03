$(document).ready(function() {

	/*** Front End Carousal ***/
	$('.slidewrap').carousel({
	slider: '.slider',
	slide: '.slide',
	slideHed: '.slidehed',
	nextSlide : '.next',
	prevSlide : '.prev',
	addPagination: false,
	addNav : false
	});
	
	$("#owl-demo").owlCarousel({
	autoPlay: 3000,
	items : 5,
	itemsDesktop : [1199,3],
	itemsDesktopSmall : [979,3]
	});
	
		
	/*** Visitor Widget Tab ***/	
	$(".tabs-menu a").click(function(event) {
	event.preventDefault();
	$(this).parent().addClass("current");
	$(this).parent().siblings().removeClass("current");
	var tab = $(this).attr("href");
	$(".tab-content").not(tab).css("display", "none");
	$(tab).fadeIn();
	});
		
		

	
		$(function() {
	//create instance	
		/*** returning Circle Stats ***/	
	$(".returning").easyPieChart({animate:2000});setTimeout(function(){$(".returning").data("easyPieChart").update(48)},5000);setTimeout(function(){$(".returning").data("easyPieChart").update(57)},10000);setTimeout(function(){$(".returning").data("easyPieChart").update(68)},15000);setTimeout(function(){$(".returning").data("easyPieChart").update(92)},19000);setTimeout(function(){$(".returning").data("easyPieChart").update(50)},32000)
	
	/*** Earning Circle Stats ***/	
	$(".earning").easyPieChart({animate:2000});setTimeout(function(){$(".earning").data("easyPieChart").update(78)},5000);setTimeout(function(){$(".earning").data("easyPieChart").update(67)},10000);setTimeout(function(){$(".earning").data("easyPieChart").update(84)},15000);setTimeout(function(){$(".earning").data("easyPieChart").update(23)},19000);setTimeout(function(){$(".earning").data("easyPieChart").update(40)},32000)	
	
	});
	
	



});