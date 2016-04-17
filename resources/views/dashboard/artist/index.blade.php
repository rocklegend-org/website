@extends('dashboard/layout')

@section('content')
	<div class="heading-sec">
		<h1>Artists</h1>
	</div>
	<br />

	<a href="{{ URL::action('Dashboard\\SongController@create') }}" class="btn green m-sml-btn">Create</a>

	<table id="stream_table" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Songs</th>
				<th>Albums</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>	 
		@foreach ($artists as $artist)
			<tr>
				<td>#{{ $artist->id }}</td> 
				<td>{{ $artist->name }}</td>
				<td>
					<a href="{{ URL::action('Dashboard\\ArtistController@show', array('id' => $artist->id)) }}">
						{{ $artist->songs->count() }}
					</a>
				</td>
				<td>
					<a href="{{ URL::action('Dashboard\\AlbumController@show', array('artist_id' => $artist->id)) }}">
						{{ $artist->albums->count() }}
					</a>
				</td>
				<td>
					<a href="{{ URL::action('Dashboard\\ArtistController@edit', array('id' => $artist->id)) }}" class="btn blue m-sml-btn">
						<i class="fa fa-edit"></i> Edit
					</a>
					{!! Form::open(array('route' => array('dashboard.artist.destroy', $artist->id), 'method' => 'DELETE')) !!}
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