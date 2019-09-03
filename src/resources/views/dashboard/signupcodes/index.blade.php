@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>Signup Codes</h1>
	</div>
	<br />

	<a href="{{ URL::action('Dashboard\\SignupCodeController@create') }}" class="btn green m-sml-btn">Create</a>

	<table id="stream_table" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Code</th>
				<th>Used count</th>
				<th>Left</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($codes as $code)
			<tr>
				<td>#{{ $code->id }}</td>
				<td>{{ $code->code }}</td>
				<td>{{ $code->usedCount() }}</td>
				<td>{{ $code->leftCount() }}</td>
				<td>{{ $code->active_from }}</td>
				<td>{{ $code->active_to }}</td>
				<td><a href="{{ route('dashboard.signupcode.edit', array('id' => $code->id)) }}">Edit</a></td>
				<td><a href="{{ route('dashboard.signupcode.delete', array('id' => $code->id)) }}">Delete</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>
@stop