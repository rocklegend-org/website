<h2 class="bg-violet">Highscores</h2>

<div class="highscore-box">
	<div class="button-box">
		<a href="#" title="Global" class="active js-scores-region tooltip" data-region="all"><i class="fa fa-lg fa-globe"></i></a>

		{{-- <a href="#" title="Your Country" class="js-scores-region tooltip" data-region="country"><i class="fa fa-lg fa-map-marker"></i></a> --}}
	
		<a href="#" title="Followed Users" class="js-scores-region tooltip" data-region="followed"><i class="fa fa-lg fa-eye"></i></a>

		<select name="highscores-timespan">
			<option value="all">All-Time</option>
			<option value="today">Today</option>
			<option value="week" selected>Week</option>
			<option value="month">Month</option>
		</select>
	</div>

	<div class="highscore-list">
		@include('game.partials.highscores_scores')
	</div>
</div>