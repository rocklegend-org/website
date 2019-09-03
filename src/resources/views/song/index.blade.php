@extends('layout')

@section('content')

<div class="hide-for-small medium-3 columns">
	<!--<h2>Last Played</h2>
	<div class="clear"></div>
	---->
	&nbsp;
</div>

<div class="small-12 medium-6 columns main-column">
	<div class="row">
		<div class="small-12 columns">
			<h1>Songs</h1>
			<p>We are working hard to get more bands to join rocklegend, and we're always looking for talented note trackers to create awesome rocklegend tracks!</p>
		</div>
		
		<table class="full-width">
			<thead>
				<th>Band</th>
				<th>Song Name</th>
				<th>Tracks</th>
				<th>&nbsp;</th>
			</thead>
			@foreach ($songs as $song)
				<tr>
					<td>{{ $song->artist->name }}</td>
					<td>{{ $song->title }}</td>
					<td>{{ count($song->tracks) }}</td>
					<td><a href="{{ URL::action('game.song', array('artist_id' => $song->artist->slug, 'song_id' => $song->slug)) }}">Play</a></td>
				</tr>
				<div class="clear"></div>
			@endforeach
		</table>
	</div>
</div>

<div class="hide-for-small medium-3 columns">
	<!--<h2>Challenges</h2>
	<div class="clear"></div>
	---->
	&nbsp;
</div>

@stop
