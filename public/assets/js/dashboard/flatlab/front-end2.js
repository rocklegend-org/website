
$(document).ready(function() {
	
	

	
	/*** Earning Circle Stats ***/	
	$('.earning').easyPieChart({
	animate: 1000,
	barColor: '#576879',
	trackColor: '#c8d2db',
	scaleColor: '#999999',
	onStep: function(value) {
	this.$el.find('span').text(~~value);
	}
	});
	
	/*** Earning Circle Stats ***/	
	$('.returning').easyPieChart({
	animate: 1000,
	barColor: '#5bbbff',
	trackColor: '#c8d2db',
	scaleColor: '#999999',
	onStep: function(value) {
	this.$el.find('span').text(~~value);
	}
	});
	
	
		/*** Scrollbar Timeline ***/	
	$('#scrollbox3').enscroll({
	showOnHover: true,
	verticalTrackClass: 'track3',
	verticalHandleClass: 'handle3'
	});	
	
});