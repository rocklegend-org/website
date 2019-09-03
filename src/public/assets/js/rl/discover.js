window.discover = {
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
};