@extends('dashboard/layout')

@section('content')

	<div class="col-md-6">

		<div class="panel panel-default">

			<div class="panel-heading">

				<span class="panel-title"><i class="fa fa-users"></i> Users</span>

				<a class="btn btn-default btn-xs pull-right" href="{{ URL::action('Dashboard\\UserController@create') }}" title="Add User"><i class="fa fa-plus"></i></a>

			</div>

			<!--
			<div class="panel-body">
			</div>
			-->

			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Username</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					@foreach ($users as $user)
					<tr>

						<td width="5%">
							<a href="{{ URL::action('Dashboard\\UserController@show', $user->id) }}" title="Show User">
								<code>#{{ $user->id }}</code>
							</a>
						</td>

						<td>
							<a href="{{ URL::action('Dashboard\\UserController@show', $user->id) }}" title="Show User">
								{{ $user->username }}
							</a>
						</td>

						<td align="right">

							<a class="btn btn-default btn-xs" href="{{ URL::action('Dashboard\\UserController@show', $user->id) }}" title="Show User"><i class="fa fa-eye"></i></a>

							<a class="btn btn-default btn-xs" href="{{ URL::action('Dashboard\\UserController@edit', $user->id) }}" title="Edit User"><i class="fa fa-pencil"></i></a>

							<a class="btn btn-default btn-xs" href="{{ URL::action('Dashboard\\UserController@destroy', $user->id) }}" title="Delete User"><i class="fa fa-trash-o"></i></a>

						</td>

					</tr>
					@endforeach

				</tbody>
			</table>

			<div class="panel-footer">

				<a class="btn btn-default btn-xs pull-right" href="{{ URL::action('Dashboard\\UserController@create') }}" title=""><i class="fa fa-plus"></i></a>

				<div class="clearfix"></div>

			</div>

		</div>

	</div>

@stop