@extends('dashboard/layout')

@section('content')

	<div class="col-md-6">

		<div class="panel panel-default">

			<div class="panel-heading">

				<span class="panel-title"><i class="fa fa-user"></i> User {{ $user->username }}</span>

				<a class="btn btn-default btn-xs pull-right" href="{{ URL::action('Dashboard\\UserController@edit', $user->id) }}" title="Edit User"><i class="fa fa-pencil"></i></a>

			</div>

			<div class="panel-body">

				<small class="pull-right">Created: {{ $user->created_at }}<br>Updated: {{ $user->updated_at }}</small>

				<code>#{{ $user->id }}</code> {{ $user->username }}<br>

			</div>

		</div>

	</div>

@stop