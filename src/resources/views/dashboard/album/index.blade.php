@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>Albums</h1>
	</div>
	<br />

	<a href="{{ URL::action('Dashboard\\AlbumController@create') }}" class="btn green m-sml-btn">Create</a>

	<table id="stream_table" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Artist</th>
				<th>Songs</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($albums as $album)
			<tr>
				<td>#{{ $album->id }}</td>
				<td>{{ $album->name }}</td>
				<td>
					<a href="{{ URL::action('Dashboard\\ArtistController@show', array('id' => $album->artist_id)) }}">
						{{ $album->artist->name }}
					</a>
				</td>
				<td>
					<a href="{{ URL::action('Dashboard\\SongController@show', array('album_id' => $album->id)) }}">
						{{ $album->songs->count() }}
					</a>
				</td>
				<td>
					<a href="{{ URL::action('Dashboard\\AlbumController@edit', array('id' => $album->id)) }}" class="btn blue m-sml-btn">
						<i class="fa fa-edit"></i> Edit
					</a>
					{!! Form::open(array('route' => array('dashboard.album.destroy', $album->id), 'method' => 'DELETE')) !!}
						{!! HTML::decode(
							Form::button('<i class="fa fa-trash-o"></i> Delete',
											array('type' => 'submit' , 'class' => 'btn pink m-sml-btn'))
						) !!}
					{!! Form::close() !!}
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

@stop