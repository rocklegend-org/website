@extends('stats.layout')

@section('content')
	<h2 class="bg-violet">Users</h2>
	<br />	

	<p>{{ $scores->count() }} Benutzer haben mind. einen Song zu Ende gespielt.</p>

	<table>
		<tr>
			<th>Username</th>
			<th>Songs Played</th>
			<th>Provider</th>
			<th>Last Login</th>
			<th>E-Mail</th>
		</tr>
		@foreach($scores as $score)
		<tr>
			<td><a href="{{ route('profile', array('username' => $score->user->username)) }}" target="_blank">{{$score->user->username}}</a></td>
			<td>{{$score->c}}</td>
			<td>{{$score->user->provider}}</td>
			<td>{{ date('d.m.Y', strtotime($score->user->last_login)) }}</td>
			<td>{{$score->user->email}}</td>
		</tr>
		@endforeach
	</table>

@stop