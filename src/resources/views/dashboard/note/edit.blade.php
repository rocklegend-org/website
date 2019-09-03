@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>{{ $notes->song->title }} <small>by {{ $notes->song->artist->name }}</small></h1>
		<a href="{{ route('dashboard.song.edit', array('id' => $notes->song->id )) }}">Song Information</a> | <a href="{{ route('dashboard.song.notes', array('id' => $notes->song->id )) }}">Notes</a>
	</div>

	<span class="label label-info">{{ $notes->getDifficultyName() }}</span>

	<div class="heading-sec">
		<h2>[Notes Editor]</h2>
	</div>

@stop