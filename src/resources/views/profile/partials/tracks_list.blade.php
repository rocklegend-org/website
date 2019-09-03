<ul class="song-list blue">
	@foreach($tracks as $track)
		@if($track->difficulty > 0)
		<li>
			<a href="{{ route('game.play', array('artist' => $track->song->artist->slug, 'song' => $track->song->slug, 'track' => $track->id)) }}?ref=profile">
				<strong>{{ $track->song->title }} ({{Lang::get('game.difficulties.'.$track->difficulty)}})</strong> by {{$track->song->artist->name}}
			</a>
		</li>
		@endif
	@endforeach
</ul>