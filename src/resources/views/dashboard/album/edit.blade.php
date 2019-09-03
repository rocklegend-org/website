@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>Edit Album</h1>
	</div>

	{{ Form::open(array('id' => 'create-user-form', 'action' => array('Dashboard\\AlbumController@update', $user->id ))) }}
	{{ Form::label('name').": ".Form::text('name') }}<br />
	{{ Form::submit('Save'); }}
	{{ Form::close() }}

@stop