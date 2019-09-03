$(function(){
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
});