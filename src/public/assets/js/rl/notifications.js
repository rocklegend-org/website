window.notifications = {
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
};