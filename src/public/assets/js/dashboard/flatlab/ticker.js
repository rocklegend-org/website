(function ($){

  $.fn.ticker = function(options){

    var settings = $.extend({
        speed         : "50",
        number        : "0",
        end           : "100"
    }, options);

    $(this).text(settings.number);

    var selector = $(this).get();

    var i = settings.number;

    $(this).text(settings.number);

	  var ticker = function ticker(){

	  	i++;

	    if(i <= settings.end) {

	      $(selector).text(i);

	    }

	  }

	  setInterval(ticker, settings.speed);    

	  return this;

  }

}(jQuery));

$(function(){

  $(".ticker--one").ticker({
  
    speed: "1",
    
    end: "50"
  
  });	
    
  $(".ticker--two").ticker({
  
    speed: "1",
    
    end: "1256"
  
  });
    
  $(".ticker--three").ticker({
  
    speed: "400",
    
    end: "20"
  
  });	
  
  $(".ticker--four").ticker({
  
    speed: "50",
    
    end: "500"
  
  });	  
  
});