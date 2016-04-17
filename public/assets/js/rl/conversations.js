window.conversations = {
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
};