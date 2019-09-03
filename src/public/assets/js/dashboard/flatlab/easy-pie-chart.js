$(document).ready(function(){ 

	/*** Reviews Circle Stats ***/	
	$(function() {
	//create instance
	$(".review").easyPieChart({animate:2000});setTimeout(function(){$(".review").data("easyPieChart").update(50)},5000);setTimeout(function(){$(".review").data("easyPieChart").update(70)},10000);setTimeout(function(){$(".review").data("easyPieChart").update(30)},15000);setTimeout(function(){$(".review").data("easyPieChart").update(90)},19000);setTimeout(function(){$(".review").data("easyPieChart").update(40)},32000)
	
	/*** Earning Circle Stats ***/	
	$(".earning").easyPieChart({animate:2000});setTimeout(function(){$(".earning").data("easyPieChart").update(78)},5000);setTimeout(function(){$(".earning").data("easyPieChart").update(67)},10000);setTimeout(function(){$(".earning").data("easyPieChart").update(84)},15000);setTimeout(function(){$(".earning").data("easyPieChart").update(23)},19000);setTimeout(function(){$(".earning").data("easyPieChart").update(40)},32000)	
	});
	
		/*** Reviews Circle Stats ***/	
	$('.review').easyPieChart({
	animate: 1000,
	barColor: '#f2af32',
	trackColor: '#e1e1e1',
	scaleColor: '#cecece',
	onStep: function(value) {
	this.$el.find('span').text(~~value);
	}
	});
	
	/*** Earning Circle Stats ***/	
	$('.earning').easyPieChart({
	animate: 1000,
	barColor: '#576879',
	trackColor: '#e1e1e1',
	scaleColor: '#cecece',
	onStep: function(value) {
	this.$el.find('span').text(~~value);
	}
	});
	

	
});