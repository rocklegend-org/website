@extends('dashboard/layout')

@section('content')

	<div class="col-md-6">

		<div class="panel panel-default">

			<div class="panel-heading">

				<span class="panel-title"><i class="fa fa-user"></i> User {{ $user->username }}</span>

			</div>

			{!! Form::open(array('id' => 'create-user-form', 'method' => 'PUT', 'class' => 'form-horizontal', 'action' => array('Dashboard\\UserController@update', $user->id ))) !!}

			<div class="panel-body">

				<div class="form-group">
					{!! Form::label('username', 'Username', array('class' => 'col-md-3 control-label')) !!}
					<div class="col-md-9">
						{!! Form::text('username', $user->username, array('class' => 'form-control') ) !!}<br />
					</div>
				</div>

				<div class="form-group">
					{!! Form::label('email', 'E-Mail', array('class' => 'col-md-3 control-label')) !!}
					<div class="col-md-9">
						{!! Form::text('email', $user->email, array('class' => 'form-control') ) !!}<br />
					</div>
				</div>

				<div class="form-group">
					{!! Form::label('password', 'Password', array('class' => 'col-md-3 control-label')) !!}
					<div class="col-md-9">
						{!! Form::password('password', array('class' => 'form-control') ) !!}<br />
					</div>
				</div>

				<div class="form-group">
					{!! Form::label('official_tracker', 'Official Tracker', array('class' => 'col-md-3 control-label')) !!}
					<div class="col-md-9">
						{!! Form::checkbox('official_tracker', 1, $user->official_tracker, array('class' => 'form-control') ) !!}<br />
					</div>
				</div>

				<?php 
					$hasDonatorBadge = UserBadge::where('user_id', $user->id)->where('badge_id', Badge::where('internal_name','donator')->first()->id)->first() != null;
				?>
				<div class="form-group">
					{!! Form::label('donator_badge', 'Donator Badge', array('class' => 'col-md-3 control-label')) !!}
					<div class="col-md-9">
						{!! Form::checkbox('donator_badge', 1, $hasDonatorBadge ? 1 : 0, array('class' => 'form-control') ) !!}<br />
					</div>
				</div>

				<?php 
					$sentinelUser = Sentinel::findById($user->id);
					$isThrottled = false;

					try {
						$app['sentinel.checkpoint.throttle']->login($sentinelUser);
					} catch (Exception $e) {
						$isThrottled = true;
					}
				?>
				<div class="form-group">
					{!! Form::label('suspended', 'Suspended', array('class' => 'col-md-3 control-label')) !!}
					<div class="col-md-9">
						{!! Form::checkbox('suspended', 1, $isThrottled, array('class' => 'form-control') ) !!}<br />
					</div>
				</div>
			</div>

			<div class="panel-footer">

				{!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}

			</div>

			{!! Form::close() !!}

		</div>

	</div>

@stop