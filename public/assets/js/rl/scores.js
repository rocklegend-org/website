window.scores = {
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