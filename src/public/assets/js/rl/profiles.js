$(function(){
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
});