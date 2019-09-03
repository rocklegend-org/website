@extends('stats.layout')

@section('content')
	<h2 class="bg-blue">Track Play Count</h2>
	<br />
	<a href="/admin-stats?page=trackplaycount&timespan=all" {{ $timespan == 'all' ? 'class="active"' : '' }}>
		All Time
	</a> | 
	<a href="/admin-stats?page=trackplaycount&timespan=today" {{ $timespan == 'today' ? 'class="active"' : '' }}>
		Today
	</a> | 
	<a href="/admin-stats?page=trackplaycount&timespan=week" {{ $timespan == 'week' ? 'class="active"' : '' }}>
		This Week
	</a> | 
	<a href="/admin-stats?page=trackplaycount&timespan=month" {{ $timespan == 'month' ? 'class="active"' : '' }}>
		This Month
	</a> 
	<br />
	<table>
		<tr>
			<th>Play Count</th>
			<th>Song</th>
			<th>Track</th>
			<th>Go to</th>
		</tr>
	@foreach($scores as $score)
		<tr>
			<td>{{ $score->c }}</td>
			<td>{{ $score->track->song->title }}</td>
			<td>{{ $score->track->getDifficultyName().' (#'.$score->track->id.')' }}</td>
			<td><a href="{{ route('game.play', array('artist' => $score->track->song->artist->slug, 'song' => $score->track->song->slug, 'track' => $score->track_id)) }}" target="_blank">play</a>
		</tr>
	@endforeach
	</table>
@stop