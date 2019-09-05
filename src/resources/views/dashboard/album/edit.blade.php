@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>Edit Album - {{ $album->title }}</h1>
	</div>

	{!! Form::open(array('url' => Url::route('dashboard.album.update', array('id' => $album->id)), 'method' => 'patch' )) !!}
		{!! $form !!}
		<div class="clearfix"></div>
		{!! Form::submit('Update', array('class' => 'buttonFinish')) !!}
	{!! Form::close() !!}

@stop