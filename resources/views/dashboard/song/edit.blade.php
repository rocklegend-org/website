@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>{{ $song->title }} <small>by {{ $song->artist->name }}</small></h1>
	</div>

	<a href="{{ route('dashboard.song.edit', array('id' => $song->id )) }}">Song Information</a> | <a href="{{ Url::route('dashboard.song.notes', array('id' => $song->id)) }}">Notes</a>

	<div class="widget-body custom-form">
	{!! Form::open(array('url' => Url::route('dashboard.song.update', array('id' => $song->id)), 'method' => 'patch', 'files' => true )) !!}
		{!! $form !!}
		<div class="clearfix"></div>
	{!! Form::close() !!}
	</div>

@stop