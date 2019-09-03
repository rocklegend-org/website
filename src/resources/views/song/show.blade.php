@extends('layout')

@section('content')

<div class="hide-for-small medium-3 columns">
	<h2>Your previous scores</h2>
	<div class="clear"></div>
	-
</div>

<div class="small-12 medium-6 columns main-column">
	<div class="row">
		<div class="text-center">
			<h1 class="bg-green text-black">
				{{ $song->title }}<br />
				<span class="small" style="font-size:13px;">by {{ $song->artist->name }}</span>
			</h1>
			<div class="clear"></div>
			<h3>select difficulty</h3>

			<div class="row">
				<table class="small-centered small-12 columns">
					<thead>
					<th>Version</th>
					<th>Notes</th>
					<th>Lanes</th>
					<th>Creator</th>
					<th></th>
					</thead>
					@foreach($song->tracks as $key => $track)
						@if($track->deleted_at == NULL)
							<tr>
								<td>#{{ $key+1 }}</td>
								<td>{{ $track->getCount(); }}</td>
								<td>{{ $track->difficulty_id; }}</td>
								<td>{{ $track->user->username }}</td>
								<td><a href="{{ URL::action('game.play', array('artist' => $song->artist->slug, 'song' => $song->slug, 'track' => $track->id)) }}">PLAY!</a></td>
							</tr>
						@endif
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>

<div class="hide-for-small medium-3 columns">
	<h2>Highscores</h2>
	<div class="clear"></div>
	-
</div>

@stop