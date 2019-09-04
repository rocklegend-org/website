@extends('layout')

@section('content')

<div class="hide-for-small medium-3 columns">
	<h1 class="bg-violet">New highscores</h1><br />
	<table>
	@foreach($lastScores as $score)
		@include('partials.scores.user.single')
	@endforeach
	</table>
</div>

<div class="small-12 medium-6 decoration-blue columns">
	<h1 class="first bg-blue">Welcome to rocklegend!</h1>
		<p>A <b>free and <a href="https://github.com/rocklegend-org/website" target="_blank">open source</a> online music game</b>. If you know Guitar Hero or Rockband, you'll know how to play. Just use your keyboard to hit the notes at the right time, score high and become a rocklegend!</p>
		</p>
		<iframe width="49%" height="auto" src="https://www.youtube.com/embed/UQsMIHo8E8U" frameborder="0" allowfullscreen style="display: inline-block;"></iframe>
		<iframe width="49%" height="auto" src="https://www.youtube.com/embed/veWSp0WxHgo" frameborder="0" allowfullscreen style="display: inline-block;"></iframe>
		<p>After quiet some time of silence, I'm trying to get back to update and implement new <b class="t-blue">features, enhancements and bugfixes</b>.<br />
		</p>

		<h2 class="bg-green">Support this project!</h2>
		<p>If you want to support this project, please consider becoming a patreon. This will help with server costs, and feeding the kids while I work on new things!<br />
		On some tiers, you may also <b class="t-green">request new songs and tracks to be added!</b><br /><br />
		<a href="https://www.patreon.com/bePatron?u=3916023" data-patreon-widget-type="become-patron-button">Become a Patron!</a><script async src="https://c6.patreon.com/becomePatronButton.bundle.js"></script>
		</p>

		<h2>Get in touch!</h2>
		<p>
			Tell me what you like, what you miss,<br />and what doesn't work for you via rocklegends <a href="https://facebook.com/rocklegendgame" target="_blank" title="facebook">facebook page</a>!<br>
		</p>

		<p>
			Cheers and <i>thank you for joining!</i>,<br>
			Patrick
		</p>
</div>

<div class="hide-for-small medium-3 columns">
	<div class="row">
		<div class="small-12 columns decoration-red home-hot-tracks">
			<h1 class="first bg-red">Hot tracks</h1>
			<div class="clear"></div>

			<div style="line-height:12px;">
				@foreach($hotTracks as $track)
					<?php $track = Track::find($track['track_id']); ?>

					<a href="{{route('game.play',
									array(
										'track' => $track->id,
										'song' => $track->song->slug,
										'artist'=>$track->song->artist->slug
									)
								)}}" class="home-track-btn btn bg-{{Config::get('game.difficulty_colors.'.$track->difficulty)}}">{{Lang::get('game.difficulties.'.$track->difficulty)}}<small><br />by {{$track->user->username}}</small></a>
						<span class="song-title" style="display:inline-block;">{{$track->song->title}}<small><br />by {{$track->song->artist->name}}</small></span>
						<br />
				@endforeach
			</div>
			<br />
		</div>
		<div class="clear"></div>
		<div class="small-12 columns decoration-green home-tracks">
			{{-- beta updates --}}
			<h1 class="first bg-green">New tracks</h1>
			<div class="clear"></div>

			<div style="line-height:12px;">
				@foreach($newestTracks as $track)

					<a href="{{route('game.play',
									array(
										'track' => $track->id,
										'song' => $track->song->slug,
										'artist'=>$track->song->artist->slug
									)
								)}}" class="home-track-btn btn bg-{{Config::get('game.difficulty_colors.'.$track->difficulty)}}">{{Lang::get('game.difficulties.'.$track->difficulty)}}<small><br />by {{$track->user->username}}</small></a>
						<span class="song-title" style="display:inline-block;">{{$track->song->title}}<small><br />by {{$track->song->artist->name}}</small></span>
						<br />
				@endforeach
			</div>
		</div>
	</div>
</div>
@stop
