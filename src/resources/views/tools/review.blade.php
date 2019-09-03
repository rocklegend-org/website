@extends('layout')

@section('content')

<div class="small-12 medium-6 columns medium-centered decoration-green">

	<h2 class="bg-green first">Your new track has been saved successfully!</h2>

	<p>Thank you for trying out the rocklegend note track editor.<br /><br />
		Your tracked notes for <b>{{ $song->title }}</b> with <i>{{ $track->difficulty_id }}</i> lanes has been saved successfully.
		<br /><br />
		As you might have noticed, this is an early version with a few missing
		features and maybe a few bugs.
		<br /><br />
		Please write us <b>your feedback</b> about 'what you liked', 'what you disliked' and 'what you'd suggest',
		in the <a href="//forum.rocklegend.org" target="_blank">rocklegend forum</a>.
		<br /><br />
		You can <a href="{{ route('create.editor', array('song' => $track->song->slug,
					 'lanes' => $track->lanes,
					 'notes' => $track->id)) }}">edit your track</a> or start <a href="{{ route('game.play', array('artist' => $song->artist->slug, 'song' => $song->slug, 'track' => $track->id)) }}">playing it</a>.
		<br /><br />
		You can also <a href="https://www.facebook.com/sharer/sharer.php?app_id=1510352382540804&sdk=joey&u={{ urlencode(route('game.play', array('artist' => $song->artist->slug, 'song' => $song->slug, 'track' => $track->id))) }}&display=popup&ref=plugin" target="_blank">share</a> your track for other early access users to play!
		<br /><br />
		Thanks for being awesome,
		<br />
		#thisisrocklegend.
</div>

@stop