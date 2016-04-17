@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>Create Artist</h1>
	</div>

	{{ Form::open(array('id' => 'create-user-form', 'action' => 'Dashboard\\UserController@store' )) }}
	{{ Form::label('name').": ".Form::text('name') }}<br />
	{{ Form::submit('Save'); }}
	{{ Form::close() }}

@stop