@extends('layout')

@section('page_title')
Tools | rocklegend
@overwrite

@section('content')

<div class="small-12 medium-1 columns">
&nbsp;
</div>

<div class="small-12 medium-9 columns">

	<div class="row">

		<div class="small-12 columns">
			<h1>Tools</h1><br />
			<p>Create new tracks for rocklegend official songs with the rocklegend track editor!</p>

			<a href="{{ URL::route('create.track') }}" class="btn bg-red">Create new track</a>
			<a href="{{ URL::route('tools.trash') }}" class="btn bg-violet">Show deleted tracks</a>
			
			<br />
			
			<hr />
				
			<h3>My Tracks</h3>

			@if(Session::has('success'))
				<div class="alert-box success clearfix">
					{{ Session::get('success') }}
				</div>
			@endif

			@if(Session::has('error'))
				<div class="alert-box error">
					{{ Session::get('error') }}
				</div>
			@endif
			<table class="full-width">
				<thead>
					<tr>
						<th>Last Update</th>
						<th>Song</th>
						<th>Difficulty</th>
						<th>Status</th>
						<th>Note Count</th>
						<th>Plays</th>
						<th colspan="3"></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($myTracks as $track): 

				if($track->song){ ?>
				<tr>
					<td>
						{{ date('d.m.Y', strtotime($track->updated_at)) }}
						<small>
							{{ date('h:m', strtotime($track->updated_at)) }}
						</small>
					</td>
					<td>
						<strong>{{ $track->song->title }}</strong>
						<br /> 
						<small>by {{ $track->song->artist->name }}</small>
					</td>
					<td>
						<strong>{{$track->getDifficultyName()}}</strong> <small>#{{$track->id}}</small>
					</td>
					<td>{{ $track->getStatusName() }}</td>
					<td>{{ $track->getCount() }}</td>
					<td>{{ $track->play_count }}</td>
					<td><a href="{{ route('create.editor', array('song' => $track->song->slug,
															 'lanes' => $track->lanes,
															 'track' => $track->id)) }}">Edit</a></td>
					<td><a href="{{ route('clone.track', array('track' => $track->id)) }}">Clone</a></td>
					<td><a href="{{ route('delete.track', array('track' => $track->id)) }}">Delete</a></td>
					<td><a href="{{ route('game.play.test', array('track' => $track->id )) }}">Test-Play</a></td>
				</tr>
				<?php }
				endforeach; ?>
				</tbody>
			</table>
		</div>

	</div>

</div>

<div class="small-12 medium-1 columns">
&nbsp;
</div>

@stop