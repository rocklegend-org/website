@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>{{ $song->title }} <small>by {{ $song->artist->name }}</small></h1>
		<a href="{{ route('dashboard.song.edit', array('id' => $song->id )) }}">Song Information</a> | <a href="{{ route('dashboard.song.notes', array('id' => $song->id )) }}">Notes</a>
	</div>

	<div class="heading-sec">
		<h2>[Notes Editor]</h2>
	</div>

@stop