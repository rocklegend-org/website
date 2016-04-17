@extends('dashboard/layout')

@section('content')

	<div class="col-md-6">

		<div class="panel panel-default">

			<div class="panel-heading">

				<span class="panel-title"><i class="fa fa-user"></i> Create User</span>

			</div>

			{!! Form::open(array('id' => 'create-user-form', 'action' => 'Dashboard\\UserController@store' )) !!}

			<div class="panel-body">

				{!! Form::label('username').": ".Form::text('username') !!}<br />
				{!! Form::label('email').": ".Form::text('email') !!}<br />
				{!! Form::label('password').": ".Form::password('password') !!}<br />

			</div>

			<div class="panel-footer">

				{!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}

			</div>

			{!! Form::close() !!}

		</div>

	</div>

@stop