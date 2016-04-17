@extends('layout')

@section('content')
<div class="small-12 columns">
	<h1 class="bg-green">All rocklegend songs</h1>
	<p>This is an overview of all {{Song::count()}} songs by {{Artist::count()}} artists which are currently available on rocklegend.</p>
	<hr />
</div>
	@foreach(Song::get() as $song)
		<div class="small-6 columns">
			<div class="row">
				<div class="small-5 columns big-text v-middle" style="position: relative;top: 4px;">
					<span class="song-title">{{$song->title}}</span>
					<br />
					<small>{{$song->artist->name}} | {{$song->playCount()}} plays</small>
				</div>
				<div class="small-7 columns text-right tracks"  style="margin-bottom: 10px;">
				{{-- difficulties --}}
				@for($i = 2; $i <= 5; $i++)
					<?php 
						$track = $song->getTrackForDifficulty($i);
					?>

					@if($track)
						<a href="{{route('game.play', array('track' => $track->id, 'song' => $song->slug, 'artist'=>$song->artist->slug))}}" class="btn bg-{{Config::get('game.difficulty_colors.'.$track->difficulty)}}">{{Lang::get('game.difficulties.'.$track->difficulty)}}</a>
					@else
						<a href="#" class="btn bg-{{Config::get('game.difficulty_colors.'.$i)}} disabled trackable">{{Lang::get('game.difficulties.'.$i)}}</a>
					@endif
				@endfor
				</div>
			</div>
		</div>
	@endforeach
	<div class="clear"></div>

	

	<div class="small-12 columns">
		<hr />
		<p>Feel like something's missing?<br />Post your suggestions in our <a href="//forum.rocklegend.org">Forum</a> and check if others also want to see your favorite artist here!</p>
	</div>
@stop