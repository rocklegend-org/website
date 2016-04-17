@extends('layout')

@section('content')

<div class="small-12 medium-1 columns">
&nbsp;
</div>

<div class="small-12 medium-9 columns">

	<div class="row">

		<div class="small-12 columns">
			<h1>Tools | Trash</h1><br />
			<p>These are tracks that were deleted by you or one of our admins.</p>

			<a href="{{ URL::route('tools') }}" class="btn bg-red">Back to Drafts</a>
			
			<br />
			
			<hr />
				
			<h3>Deleted Tracks</h3>
			<table class="full-width">
				<thead>
					<tr>
						<th>Deleted at</th>
						<th>Song</th>
						<th>Track ID</th>
						<th>Note Count</th>
						<th>Plays</th>
						<th colspan="2"></th>
					</tr>
				</thead>
				<tbody>
				@foreach($tracks as $track)
				<tr>
					<td>
						{{ date('d.m.Y', strtotime($track->deleted_at)) }}
						<small>
							{{ date('h:m', strtotime($track->deleted_at)) }}
						</small>
					</td>
					<td>
						{{ $track->song->title }} 
						<br /> 
						<small>by {{ $track->song->artist->name }}</small>
					</td>
					<td>
						#{{$track->id}}
					</td>
					<td>{{ $track->getCount() }}</td>
					<td>{{ $track->play_count }}</td>
					<td><a href="{{ URL::route('revive.track', array('track' => $track->id)) }}">Revive</a></td>
					<td><a href="{{ URL::route('delete.track', array('track' => $track->id, 'force' => true)) }}">FORCE DELETE</a></td>
				</tr>
				@endforeach
				</tbody>
			</table>
		</div>

	</div>

</div>

<div class="small-12 medium-1 columns">
&nbsp;
</div>

@stop