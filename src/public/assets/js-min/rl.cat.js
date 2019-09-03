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
  };$(function(){
	window.chat = {
		$c : $('.realtime-chat-container'),
		$msg: $('.realtime-chat-container .messages'),
		user_id: 0,
		unread_messages: 0,

		init: function()
		{
			this.user_id = this.$c.find('input[name="user_id"]').val();

			// connect to chat socket
			window.realtime.chat = realtime_services.chat.socket;

			realtime.chat.emit("new.user", { user_id: this.user_id });

			chat.toggleCloseIcon();

			this.$c.find('.handle').on('click', window.chat.toggle);

			this.$c.find('form.chat-message').on('submit', function(e){
				e.preventDefault();

				if($(this).find('input[name="chat-message"]').val() != ''){
					realtime.chat.emit(
						'new.message', 
						{ 
							message: $(this).find('input[name="chat-message"]').val(),
							user_id: $(this).find('input[name="user_id"]').val(),
							guid: guid()
						}
					);

					$(this).find('input[name="chat-message"]').val('');
				}
			});

			this.initEventListeners();

			this.$msg.animate({ scrollTop: this.$msg[0].scrollHeight });
		},
		hide: function(){
			this.$c.remove();
		},
		toggle: function()
		{
			chat.$c.toggleClass('active');

			chat.toggleCloseIcon();

			$.post('/chat/set-open', { open: window.chat.$c.hasClass('active') });

			if(window.chat.$c.hasClass('active')){
				chat.$c.find('.unread-container').removeClass('show');
				chat.unread_messages = 0;
				chat.$c.find('.unread-container .unread-count').html('0');				
			}
		},
		toggleCloseIcon: function(){
			if(chat.$c.hasClass('active')){
				chat.$c.find('.close').fadeIn();
			}else{
				chat.$c.find('.close').fadeOut();				
			}
		},
		appendMessage: function(data)
		{
			this.$msg.append($(data.html));
			this.$msg.stop().animate({ scrollTop: this.$msg[0].scrollHeight });
		},
		initEventListeners: function()
		{
			realtime.chat.on('new.message',function(data)
			{
				chat.appendMessage(data);

				if(chat.$c.hasClass('active') == false){
					chat.unread_messages++;
					if(chat.$c.find('.unread-container').hasClass('show') == false){
						chat.$c.find('.unread-container').addClass('show');
					}
					chat.$c.find('.unread-container .unread-count').html(chat.unread_messages);
				}
			});

			realtime.chat.on('user.count', function(data)
			{
				chat.$c.find('.user-count').html(data.count);
			});
		}
	};
	
	if(window.realtime && window.chat.$msg.length > 0){
		window.chat.init();
	}else{
		window.chat.hide();
	}
});;$(function(){
	$(document).on('click', '.comments-module input[type="submit"]', function(e)
	{
		if($(this).parent().find('textarea').val() != '')
		{
			$(this).attr('disabled', 'disabled');
			$(this).css('cursor', 'wait');

			$(this).parents('form').submit();
		}
		
		return false;
	});

	$(document).on('focus', '.comment-options textarea', function(){
		if(typeof(RL) !== 'undefined')
		{
			RL.typing = true;
		}
	});
	$(document).on('blur', '.comment-options textarea', function(){
		if(typeof(RL) !== 'undefined')
		{
			RL.typing = false;
		}
	});

	$(document).on('click', '.comments-pagination a', function(e)
	{
		e.preventDefault();

		var url = ($(this).attr('href')).replace('#','');
		var $container = $(this).parents('.comments-module');
		var comment = $('textarea[name="comment"]').val();

		$.post(url, { comment: comment, _token: csrf }, function(data)
		{
			$container.replaceWith(data);
			rl.initializeAjaxForms();
		});
	});

	$(document).on('click', 'a.comment-reply', function(e){
		e.preventDefault();

		var url = $(this).attr('href');
		var track_id = $(this).parent().data('track-id');
		var replyHtml = $('<b>Reply to comment</b><textarea></textarea><a href="#">Send reply</a>');

		$(this).parent().append(replyHtml);
		$(this).parent().find('a[href="#"]').on('click', function(e){
			e.preventDefault();
			var text = $(this).parent().find('textarea').val();

			if(text != ''){
				$(this).parent().find('a[href="#"]').remove();
				$.post(url, { reply: text, _token: csrf }, function(data){
					appendTrackComment(data);
				});
			}
		});

		$(this).remove();
	});
});

/**
 * accepts a comment object and appends it to the comment area
 */
function appendTrackComment(data)
{
	var $container = $('.comments-module[data-track-id="'+data.track_id+'"]');

	$.post('/track/comments/'+data.track_id, { _token: csrf },  function(data)
	{
		$container.replaceWith(data);

		rl.initializeAjaxForms();
	});
};window.conversations = {
	messageCount: 5,
	checkInterval: false,
	autoScroll: true,
	sendOnEnter: false,
	init: function(){
		autoSuggestPrefill = typeof(autoSuggestPrefill) != 'undefined' ? autoSuggestPrefill : '';
		
		$("input[name=recipients]").autoSuggest("/conversations/availableRecipients", 
			{
				minChars: 2, 
				matchCase: false,
				canGenerateNewSelections: false,
				neverSubmit: true,
				useOriginalInputName: true,
				selectionLimit: 8,
				preFill: autoSuggestPrefill
			}
		);

		$('input[name=recipients]').attr('required', true);
		
		$('input[name="useEnterForSend"]').on('change', function(){
			conversations.sendOnEnter = $('input[name="useEnterForSend"]').is(':checked');
		});

		$('#send-conversation-message textarea[name="message"]').on('keydown', function(e){
			if(conversations.sendOnEnter && e.keyCode == 13 && $(this).val().length > 0){
				$(this.form).submit();
				$(this).val('');
				return false;
			}
		});

		$('.messages-container').on('scroll', function(){
			conversations.autoScroll = false;
		});

		$('a.js-load-all-messages').on('click', function(){
			$('.messages-container').fadeTo(250,0.5);
			$.get(
				'/conversations/messages/'+$(this).parents('.messages-container').eq(0).data('conversation-id'),
				{
					limit: 0, 
					_token: csrf
				}, 
				conversations.update
			);
		});

		if($('.messages-container').length > 0){
			conversations.checkInterval = setInterval(function(){
				conversations.fetchMessages();
			}, 5000);
		}

		conversations.scrollToCurrent();
	},
	beforeMessage: function()
	{
		//pageLoader.show();
		conversations.autoScroll = true;
		$('.messages-container').fadeTo(250,0.5);
		$('#send-conversation-message textarea[name="message"]').val('');
	},
	fetchMessages: function()
	{
		conversations.autoScroll = true;
		$('.messages-container').each(function(){
			$.get(
				'/conversations/messages/'+$(this).data('conversation-id'), 
				{ ident: $(this).find('.identifier').data('ident'), _token: csrf }, 
				conversations.update
			);
		})
	},
	update: function(data){
		//pageLoader.hide();
		$('.messages-container').fadeTo(250,1);
		$('#conversation-'+data.id).html(data.html);
		if(conversations.autoScroll){
			setTimeout(function(){
				conversations.scrollToCurrent();
			}, 250);
		}
		profiles.updateProfileInfoTooltips();
	},
	scrollToCurrent: function(){
		$('.messages-container').each(function(){
			$(this).animate({ scrollTop: $(this)[0].scrollHeight }, 500);
		});
	}
};;window.discover = {
	init: function()
	{
		$('input[name="search_text"]').on('keyup', function(e)
		{
			var q = $(this).val();

			if(q != ''){
				$('.artist-box-big').each(function(){
					if($(this).data('artist').toLowerCase().indexOf(q.toLowerCase()) > -1){
						$(this).removeClass('invisible').addClass('visible').show();
					}else{
						$(this).removeClass('visible').addClass('invisible').hide().css('display','none');
					}
				});

				$('.song-title').each(function()
				{
					if($(this).text().toLowerCase().indexOf(q.toLowerCase()) > -1){
						$(this).parents('.artist-box-big').removeClass('invisible').addClass('visible').show();
					}
				});
			}else{
				$('.artist-box-big').each(function(){ $(this).removeClass('invisible').addClass('visible').show(); });
			}

			discover.updateClears();
		});

		$('.js-discover-sort').on('click', function(e)
		{
			e.preventDefault();

			$('.js-discover-sort').addClass('inactive');
			$(this).removeClass('inactive');

			var sortBy = $(this).data('sort');

			switch(sortBy){
				case 'plays':
					$('.artist-box-big').tsort({attr:'data-artist-plays', order: 'desc'});
					break;
				case 'name':
					$('.artist-box-big').tsort({attr:'data-artist'});
					break;
				case 'artist_added':
					$('.artist-box-big').tsort({attr:'data-artist-added'});
					break;
			}

			discover.updateClears();
		});
	},

	updateClears: function()
	{
		$('.artist-container .clear').remove();
		$('.artist-box-big.visible').each(function(key,ele){
			if((key+1)%2==0){
				$(this).after('<div class="clear"></div>');
				counter = 0;
			}
		});
	}
};;window.notifications = {
	hideTimeout: false,
	init: function(){
		$(document).on('mouseover', '.notifications-container', function(e)
		{
			clearTimeout(notifications.hideTimeout);
			$('.notifications-list').stop().fadeIn();
		});


		$(document).on('mouseleave', '.notifications-container', function(e)
		{
			notifications.hideTimeout = setTimeout(function(){
				$('.notifications-list').stop().fadeOut();
			}, 500);
		});

		$(document).on('click', '.notifications-list li.notification', function(e){
			if(!$(this).hasClass('title')){
				e.preventDefault();

				$.post('/notifications/dismiss', {id: $(this).data('notification-id'), _token: csrf});

				location.href = $(this).find('a').attr('href');
			}
		});
	},
	update: function()
	{
		$.get('/notifications.html?_token='+csrf, function(html){
			$('.notifications-container').replaceWith(html);
		});
	},
};;window.playerPage = {
	init: function(){
		$.post('/track/notes.json', { id: track_id, _token: csrf }, function(data){
			aNotes = base64_decode(data.notes);

			aNotes = JSON.parse(aNotes);

			// migration code
			if(aNotes.length <= 5){
				aNotes.splice(0, 0, [false]);
			}

			RL.showLoadingScreen();
			RL.init();
		});

		$('.js-nscroll').nscroll({
			parent: '.js-nscroll-parent',
			offsetY: -100,
			speed: 250
		});
	}
}
;$(function(){
	window.profiles = {
		init: function()
		{
			$('a[href*="profile/detail"]').not('.no-tooltip').each(function(){
				var url = $(this).attr('href');
				var username = url.match(/profile\/detail\/(.*)/i);
				username = username[1];

				$(this).data('tipped-options', "ajax: { url: '/profile/box/"+username+"' }");
			
				Tipped.create(this, {
					skin: 'light',
					size: 'small',
				});
			});

			$(document).on('click', '.js-follow', function(e){
				e.preventDefault();
				window.profiles.follow($(this).data('user-id'), $(this));
			});
			$(document).on('click', '.js-unfollow', function(e){
				e.preventDefault();
				window.profiles.unfollow($(this).data('user-id'), $(this));
			});
		},
		updateProfileInfoTooltips: function(){
			$('a[href*="profile/detail"]').not('.no-tooltip').each(function(){
				if(typeof($(this).data('tipped-options')) == 'undefined'){
					var url = $(this).attr('href');
					var username = url.match(/profile\/detail\/(.*)/i);
					username = username[1];

					$(this).data('tipped-options', "ajax: { url: '/profile/box/"+username+"' }");
				
					Tipped.create(this, {
						skin: 'light',
						size: 'small',
					});
				}
			});
			$('a[href*="profile/detail"]').not('.no-tooltip').each(function(){
				Tipped.refresh(this);
			});
		},
		follow: function(userId, $ele){
			$.post('/profile/follow', { user_id: userId, _token: csrf }, function(){
				$ele.removeClass('js-follow').addClass('js-unfollow');
				$ele.html('<i class="fa fa-eye-slash"></i> Unfollow');

				profiles.updateProfileInfoTooltips();
			});
		},
		unfollow: function(userId, $ele){
			$.post('/profile/unfollow', { user_id: userId, _token: csrf }, function(){
				$ele.removeClass('js-unfollow').addClass('js-follow');
				$ele.html('<i class="fa fa-eye"></i> Follow!');
				
				profiles.updateProfileInfoTooltips();
			});
		}
	};

	window.profiles.init();
});;window.scores = {
	region: 'global',
	timespan: 'week',
	track_id: null,
	page: 0,
	init: function(track_id)
	{
		scores.track_id = track_id;

		$('select[name="highscores-timespan"]').on('change', function(e)
		{
			var timespan = $('select[name="highscores-timespan"] option:selected').val();

			scores.timespan = timespan;

			scores.fetch();
		});

		$('a.js-scores-region').on('click', function(e)
		{
			e.preventDefault();

			$('a.js-scores-region.active').removeClass('active');
			$(this).addClass('active');

			scores.region = $(this).data('region');

			scores.fetch();
		});
	},
	fetch: function()
	{
		$.post('/track/'+scores.track_id+'.scores.html',
				{ 
					track_id: scores.track_id, 
					timespan: scores.timespan,
					region: scores.region,
					_token: csrf
				},
				function(data)
				{
					$('.highscore-box .highscore-list').html(data);
					window.profiles.updateProfileInfoTooltips();
				}
		);
	}
}