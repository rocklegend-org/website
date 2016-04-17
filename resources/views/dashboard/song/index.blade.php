@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>Songs</h1>
	</div>
	<br />

	<a href="{{ URL::action('Dashboard\\SongController@create') }}" class="btn green m-sml-btn">Create</a>

	<table id="stream_table" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Artist</th>
				<th>Album</th>
				<th>Note Packages</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($songs as $song)
			<tr>
				<td>#{{ $song->id }}</td>
				<td>{{ $song->title }} ({{ $song->slug }})</td>
				<td><a href="{{ URL::action('Dashboard\\ArtistController@show', array('id' => $song->artist_id)) }}">{{ $song->artist->name }} ({{ $song->artist->slug }})</a></td>
				<td>
					@if($song->album)
						<a href="{{ URL::action('Dashboard\\AlbumController@show', array('id' => $song->album_id)) }}">{{ $song->album->title }} ({{ $song->album->slug }})</a></td>
					@endif
				<td>
					{{ $song->tracks->count() }}
				</td>
				<td>
					<a href="{{ URL::action('Dashboard\\SongController@edit', array('id' => $song->id)) }}" class="btn blue m-sml-btn"><i class="fa fa-edit"></i> Edit</a>
					<a href="{{ Url::route('dashboard.song.notes', array('id' => $song->id)) }}" class="btn green m-sml-btn"><i class="fa fa-music"></i> Notes</a>
					{!! Form::open(array('route' => array('dashboard.song.destroy', $song->id), 'method' => 'DELETE', 'style' => 'display:inline-block;')) !!}
						{!! HTML::decode(Form::button('<i class="fa fa-trash-o"></i> Delete', array('type' => 'submit' , 'class' => 'btn pink m-sml-btn'))); !!}
					{!! Form::close() !!}
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@stop