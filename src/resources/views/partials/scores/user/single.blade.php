<a href="{{ route('game.play', array('artist' => $score->track->song->artist->slug, 'song' => $score->track->song->slug, 'track' => $score->track_id, 'user' => $score->user_id)) }}" title="Play '{{$score->track->song->title}}' by {{$score->track->song->artist->name}}">
	<div class="track-info-box" data-equalizer>
		<div class="medium-4 columns artwork" data-equalizer-watch>
			<div class="full-width"  data-equalizer-watch data-image="{{ $score->track->song->getThumbnail(400,200) }}"></div>
		</div>
		<div class="medium-8 columns data" data-equalizer-watch>
			<span class="rank"><i class="fa fa-trophy"></i> {{$score->rank()}}/{{$score->uniqueScores()}}</span> 
			<span class="points"><i class="fa fa-bar-chart-o"></i> {{number_format($score->score, 0,',','.')}}</span> 
			<br />
			<i class="fa fa-music"></i><span class="title">{{ $score->track->song->title }} - {{Lang::get('game.difficulties.'.$score->track->difficulty)}}</span>
			<br />
			<span class="artist"><i class="fa fa-microphone"></i><i>{{ $score->track->song->artist->name }}</i></span>
			@if(!isset($showUser) || $showUser)
			<span class="username">{{$score->user->username}}</span>
			@endif
		</div>
		<div class="clear"></div>
	</div>
</a>