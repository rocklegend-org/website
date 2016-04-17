//jQuery.noConflict();

if(WebSocketTest){
	window.realtime = {};
}else{
	window.realtime = false;
}

function disableFunctionKeys(e) {
    var functionKeys = new Array(112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 123);
    if (functionKeys.indexOf(e.keyCode) > -1 || functionKeys.indexOf(e.which) > -1) {
        e.preventDefault();
    }
};

$(document).ready(function() {
    $(document).on('keydown', disableFunctionKeys);
});

function WebSocketTest()
{
  if ("WebSocket" in window) { return true; }else{ return false; }
}

jQuery(function($){
	$(document).foundation({
		'abide': {
			      patterns: {
			        password: /^(.){5,}$/
			      }
			    }
	}); 

	$(".fancybox").fancybox({
		beforeShow: function(){
			 var alt = this.element.find('img').attr('alt');
        
		    this.inner.find('img').attr('alt', alt);
		        
		        this.title = alt;
		}
	});

	rl.init();
	rl.parallax();

	notifications.init();
});

if(typeof(currentArtistId) === 'undefined'){
var currentArtistId = 0;
}
if(typeof(currentSongId) === 'undefined'){
var currentSongId = 0;
}

var rl = {
	init: function(){
		$('.tooltip').tooltip({
			track: true
		});

		$('div[data-image]').each(function(){
			$(this).backstretch($(this).attr('data-image'), 0);
		});

		if($('#home-slider').length > 0){
			$('#home-slider').bxSlider({
				pager: false,
				mode: 'fade',
				randomStart: true,
				auto: true,
				pause: 2500,
				autoShow: true,
				autoHover: true
			});
		}

		this.initializeAjaxForms();

		$('#mobile-nav-toggle').on('click', rl.toggleMobileNav);

		$('button.changeKey').on('click', function(e){
			var keyName = $(this).data('name');
			var jQuerybutton = $(this);

			$(this).html('Please press the key you want to use.');

			$(document).bind('keyup.changeKey',function(e){
				$('input[name="'+keyName+'"]').val(e.which);

				jQuerybutton.html(String.fromCharCode(e.which))

				$(document).unbind('keyup.changeKey');
			});
		});

		$('.info-box .close').on('click', function(){
			$(this).parents('.info-box').removeClass('active');
		})
	},
	toggleMobileNav: function(){
		jQuery('ul.navigation.main li').not('.mobile-nav').each(function(){
			if(jQuery(this).hasClass('hide-on-small')){
				jQuery(this).removeClass('hide-on-small');
			}else{
				jQuery(this).addClass('hide-on-small');
			}
		});
	},
	jumpTo: function(anchor){
		jQuery.scrollTo( jQuery(anchor), 1000 );
	},
	parallax: function(){
		jQuery(window).on('scroll', function(){
			waitForFinalEvent(function(){
				var scrollTop = jQuery(window).scrollTop();
				jQuery('.trenn').each(function(){
					var pos = jQuery(this).css('backgroundPosition').split(' ');
					jQuery(this).css({
						'background-position': pos[0] +' '+(scrollTop-520)+'px'
					});
				})
			}, 0, 'parallax');
		});
	},
	toggleFocus: function()
	{
		if($('#rl-page-darken-overlay').css('display') == 'block'){
			rl.darkenPage(false);
		}else{
			rl.darkenPage(true);
		}
	},
	darkenPage: function(activate)
	{
		if(activate){
			$('#rl-page-darken-overlay').css({
				height: $(document).height(),
				width: $(document).width()
			})
			$('#rl-page-darken-overlay').fadeIn();
			rl.focusMode = true;
		}else{
			$('#rl-page-darken-overlay').fadeOut();
			rl.focusMode = false;
		}
	},

	initializeAjaxForms: function()
	{
		$('form.ajax').unbind().ajaxForm({
			dataType: 'json',
			beforeSubmit: function(arr, $form)
			{
				var before = $form.data('before');

				if(typeof(before) != 'undefined' && before != ''){
					eval(before+'()');
				}

				return true;
			},
			success: function(data, status, xhr, $form)
			{
				var cb = $form.data('cb');

				if(typeof(cb) != 'undefined' && cb != ''){
					eval(cb+'(data)');
				}
			}
		});
	}
}

rl.badge = {
	showBadgeInfo: function(badge)
	{
		if(typeof(badge) == "number"){
			// badge id -> fetch data via ajax
			$.post(
				'/badge/'+badge+'.json',
				function(data){
					showInfoBox(data);
				},
				'json'
			);
		}else{
			showInfoBox(badge);
		}

		function showInfoBox(badge){
			var $infoBox = $('.info-box--bottom');
			
			$infoBox.find('.badge-title').html(badge.name);
			$infoBox.find('.badge-description').html(badge.description);
			$infoBox.find('.badge-info img').attr('src', '/assets/images/frontend/badges/'+badge.image).attr('alt', badge.name);

			$infoBox.addClass('active');

			/*setTimeout(function(){
				$infoBox.removeClass('active');
			}, 3000);*/
		}
	}
}

var pageLoader = {
	_pl : null,
	time: 0,
	init: function(){
		this._pl = jQuery('#rl-page-loading-overlay');
	},
	loadPage: function(url){
		pageLoader.show();
		setTimeout(function(){
			location.href = url;
		}, pageLoader._time)
	},
	submitForm: function(formid){
		var attr = jQuery('#'+formid).attr('data-invalid');
		if(typeof attr === typeof undefined || attr === false){
			pageLoader.show();
			setTimeout(function(){
				jQuery('#'+formid).addClass('pl-ready').submit();
			}, pageLoader._time)
		}
	},
	show : function(){
		pageLoader._pl.fadeIn(0);
	},
	hide : function(){
		pageLoader._pl.fadeOut(0);
	}
}

function facebookLogin()
{
	location.href = '/auth/facebook';
}

var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();

var guid = (function() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
               .toString(16)
               .substring(1);
  }
  return function() {
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
           s4() + '-' + s4() + s4() + s4();
  };
})();

function lzw_decode(s) {
    var dict = {};
    var data = (s + "").split("");
    var currChar = data[0];
    var oldPhrase = currChar;
    var out = [currChar];
    var code = 256;
    var phrase;
    for (var i=1; i<data.length; i++) {
        var currCode = data[i].charCodeAt(0);
        if (currCode < 256) {
            phrase = data[i];
        }
        else {
           phrase = dict[currCode] ? dict[currCode] : (oldPhrase + currChar);
        }
        out.push(phrase);
        currChar = phrase.charAt(0);
        dict[code] = oldPhrase + currChar;
        code++;
        oldPhrase = phrase;
    }
    return out.join("");
}

// LZW-compress a string
function lzw_encode(s) {
    var dict = {};
    var data = (s + "").split("");
    var out = [];
    var currChar;
    var phrase = data[0];
    var code = 256;
    for (var i=1; i<data.length; i++) {
        currChar=data[i];
        if (dict[phrase + currChar] != null) {
            phrase += currChar;
        }
        else {
            out.push(phrase.length > 1 ? dict[phrase] : phrase.charCodeAt(0));
            dict[phrase + currChar] = code;
            code++;
            phrase=currChar;
        }
    }
    out.push(phrase.length > 1 ? dict[phrase] : phrase.charCodeAt(0));
    for (var i=0; i<out.length; i++) {
        out[i] = String.fromCharCode(out[i]);
    }
    return out.join("");
}

var keyStr = "ABCDEFGHIJKLMNOP" +
           "QRSTUVWXYZabcdef" +
           "ghijklmnopqrstuv" +
           "wxyz0123456789+/" +
           "=";
           
function base64_encode(input) {
 input = escape(input);
 var output = "";
 var chr1, chr2, chr3 = "";
 var enc1, enc2, enc3, enc4 = "";
 var i = 0;

 do {
    chr1 = input.charCodeAt(i++);
    chr2 = input.charCodeAt(i++);
    chr3 = input.charCodeAt(i++);

    enc1 = chr1 >> 2;
    enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
    enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
    enc4 = chr3 & 63;

    if (isNaN(chr2)) {
       enc3 = enc4 = 64;
    } else if (isNaN(chr3)) {
       enc4 = 64;
    }

    output = output +
       keyStr.charAt(enc1) +
       keyStr.charAt(enc2) +
       keyStr.charAt(enc3) +
       keyStr.charAt(enc4);
    chr1 = chr2 = chr3 = "";
    enc1 = enc2 = enc3 = enc4 = "";
 } while (i < input.length);

 return output;
}

function base64_decode(input) {
     var output = "";
     var chr1, chr2, chr3 = "";
     var enc1, enc2, enc3, enc4 = "";
     var i = 0;

     // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
     var base64test = /[^A-Za-z0-9\+\/\=]/g;
     if (base64test.exec(input)) {
        alert("There were invalid base64 characters in the input text.\n" +
              "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
              "Expect errors in decoding.");
     }
     input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

     do {
        enc1 = keyStr.indexOf(input.charAt(i++));
        enc2 = keyStr.indexOf(input.charAt(i++));
        enc3 = keyStr.indexOf(input.charAt(i++));
        enc4 = keyStr.indexOf(input.charAt(i++));

        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;

        output = output + String.fromCharCode(chr1);

        if (enc3 != 64) {
           output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
           output = output + String.fromCharCode(chr3);
        }

        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";

     } while (i < input.length);

     return unescape(output);
  }