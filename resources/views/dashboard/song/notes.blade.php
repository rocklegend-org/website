@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>{{ $song->title }} <small>by {{ $song->artist->name }}</small></h1>
	</div>

	<a href="{{ Url::route('dashboard.song.edit', array('id' => $song->id)) }}">Song Information</a>

	{!! Form::open(array('url' => Url::route('dashboard.song.notes.approve', array('id' => $song->id)) )) !!}
		{!! $form !!}
		<div class="clearfix"></div>
	{!! Form::close() !!}

@stop