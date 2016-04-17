@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>Edit Artist - {{ $artist->name }}</h1>
	</div>

	{!! Form::open(array('url' => Url::route('dashboard.artist.update', array('id' => $artist->id)), 'method' => 'patch', 'files' => true )) !!}
		{!! $form !!}
		<div class="clearfix"></div>
		{!! Form::submit('Update', array('class' => 'buttonFinish')) !!}
	{!! Form::close() !!}

@stop