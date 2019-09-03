$(document).ready(function() {


	/*** SET HEIGHT BASED ON VIEW PORT ***/				
	function thirty_pc() {
	var height = $(window).height();
	var thirtypc = (100 * height) / 100;
	thirtypc = parseInt(thirtypc) + 'px';
	$(".right-bar").css('height',thirtypc);
	$(".menu").css('height',thirtypc);
	}
	$(document).ready(function() {
	thirty_pc();
	$(window).bind('resize', thirty_pc);
	});		

	/*** Account Toogle ***/	
	$('#account').click(function() {
	$('.account2').slideToggle('slow');
	return false;
	});
	
	/*** User Online Toogle ***/	
	$('#user-online').click(function() {
	$('.user-online2').slideToggle('slow');
	return false;
	});
	
	/*** Disk Usage Toogle ***/	
	$('#disk-usage').click(function() {
	$('.disk-usage').slideToggle('slow');
	return false;
	});
	
	/*** Pending Task Toogle ***/	
	$('#pending-task').click(function() {
	$('.pending-task').slideToggle('slow');
	return false;
	});
	
	/*** Notification Toogle ***/	
	$(".notification-btn").click( function(){
	$('.message').fadeOut();
	$(this).next('.notification').fadeToggle();
	});	
	
	/*** Message Toogle ***/	
	$(".message-btn").click( function(){
	$(this).next('.message').fadeToggle();
	$('.notification').fadeOut();
	});	
	
	/*** Upload Files Toogle ***/	
	$(".upload-btn").click( function(){
	$(this).next('.upload-files').fadeToggle();
	$('.message').fadeOut();
	$('.notification').fadeOut();
	});	

	
	/*** Responsive Menu  ***/
	$(".responsive-menu ul li").click( function(){
	$("ul",this).slideToggle();
	});		

	/*** Responsive Menu  ***/
	$(".responsive-menu-dropdown").click( function(){
	$(".responsive-menu > ul").slideToggle();
	});
	/*** Responsive Menu  ***/
	$(".right-bar-btn-mobile").click( function(){
	$(".right-bar").slideToggle('slow');
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
	
	/*** Gallery Delete Function  ***/
	$(".hide-btn").click( function(){
	$(this).parent().parent().parent().parent().parent().fadeOut();
	});		

	
});

$(document).ready(function(){ 

	/*** Scrollbar Timeline ***/	
	$('#scrollbox3').enscroll({
	showOnHover: true,
	verticalTrackClass: 'track3',
	verticalHandleClass: 'handle3'
	});	

	/*** Sidebar Scroll ***/	
	$('#scrollbox4').enscroll({
	showOnHover: true,
	verticalTrackClass: 'track3',
	verticalHandleClass: 'handle3'
	});	
	
	/*** Contact list Scroll ***/	
	$('#scrollbox5').enscroll({
	showOnHover: true,
	verticalTrackClass: 'track3',
	verticalHandleClass: 'handle3'
	});	
	
	/*** Chat Widget Scroll ***/	
	$('#scrollbox6').enscroll({
	showOnHover: true,
	verticalTrackClass: 'track3',
	verticalHandleClass: 'handle3'
	});	
	
	/*** Inbox Widget Scroll ***/	
	$('#scrollbox7').enscroll({
	showOnHover: true,
	verticalTrackClass: 'track3',
	verticalHandleClass: 'handle3'
	});	
	
	/*** Inbox Page  Scroll ***/	
	$('#scrollbox8').enscroll({
	showOnHover: true,
	verticalTrackClass: 'track3',
	verticalHandleClass: 'handle3'
	});	
	
	/*** Read Message Scroll ***/	
	$('#scrollbox9').enscroll({
	showOnHover: true,
	verticalTrackClass: 'track3',
	verticalHandleClass: 'handle3'
	});	
	
	
	/*** Carousal Widget ***/
	$('.slidewrap').carousel({
	slider: '.slider',
	slide: '.slide1',
	slideHed: '.slidehed',
	nextSlide : '.next',
	prevSlide : '.prev',
	addPagination: false,
	addNav : false
	});

	/** Profile Tab **/
	$('#tab-content div').hide();
	$('#tab-content div:first').show();

	$('#nav1 li').click(function() {
	$('#nav1 li a').removeClass("active");
	$(this).find('a').addClass("active");
	$('#tab-content div').hide();

	var indexer = $(this).index(); //gets the current index of (this) which is #nav1 li
	$('#tab-content div:eq(' + indexer + ')').fadeIn(); //uses whatever index the link has to open the corresponding box 
	});
});	

/*** Sortable Table  ***/
		$(document).ready(function(){

		$(".sortable-table th").click(function(){
		sort_table($(this));
		});

		});

		function sort_table(clicked){
		var current_table = clicked.parents(".sortable-table"),
		sorted_column = clicked.index(),
		column_count = current_table.find("th").length,
		sort_it = [];

		current_table.find("tbody tr").each(function(){
		var new_line = "",
		sort_by = "";
		$(this).find("td").each(function(){
		if($(this).next().length){
		new_line += $(this).html() + "+";
		}else{
		new_line += $(this).html();
		}
		if($(this).index() == sorted_column){
		sort_by = $(this).text(); 
		}
		});

		new_line = sort_by + "*" + new_line;
		sort_it.push(new_line);
		//console.log(sort_it);

		});

		sort_it.sort();
		$("th span").text("");
		if(!clicked.hasClass("sort-down")){
		clicked.addClass("sort-down");
		clicked.find("span").text("▼");
		}else{
		sort_it.reverse();
		clicked.removeClass("sort-down");
		clicked.find("span").text("▲");
		}

		$("#country-list tr:not('.country-table-head')").each(function(){
		$(this).remove();
		});

		$(sort_it).each(function(index, value) {
		$('<tr class="current-tr"></tr>').appendTo(clicked.parents("table").find("tbody"));
		var split_line = value.split("*"),
		td_line = split_line[1].split("+"),
		td_add = "";

		//console.log(td_line.length);
		for (var i = 0; i < td_line.length; i++){
		td_add += "<td>" + td_line[i] + "</td>";
		}
		$(td_add).appendTo(".current-tr");
		$(".current-tr").removeClass("current-tr");

});
}

		
		
		
$(document).ready(function() {
  $('#reportrange').daterangepicker(
	 {
		startDate: moment().subtract('days', 29),
		endDate: moment(),
		minDate: '01/01/2012',
		maxDate: '12/31/2014',
		dateLimit: { days: 60 },
		showDropdowns: true,
		showWeekNumbers: true,
		timePicker: false,
		timePickerIncrement: 1,
		timePicker12Hour: true,
		ranges: {
		   'Today': [moment(), moment()],
		   'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
		   'Last 7 Days': [moment().subtract('days', 6), moment()],
		   'Last 30 Days': [moment().subtract('days', 29), moment()],
		   'This Month': [moment().startOf('month'), moment().endOf('month')],
		   'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
		},
		opens: 'left',
		buttonClasses: ['btn btn-default'],
		applyClass: 'btn-small btn-primary',
		cancelClass: 'btn-small',
		format: 'MM/DD/YYYY',
		separator: ' to ',
		locale: {
			applyLabel: 'Submit',
			fromLabel: 'From',
			toLabel: 'To',
			customRangeLabel: 'Custom Range',
			daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
			monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			firstDay: 1
		}
	 },
	 function(start, end) {
	  console.log("Callback has been called!");
	  $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	 }
  );
  //Set the initial state of the picker label
  $('#reportrange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
});