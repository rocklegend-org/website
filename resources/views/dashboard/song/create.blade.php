@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>Song <i>create</i></h1>
	</div>

	<div class="widget-body custom-form">
	{!! Form::open(array('url' => Url::route('dashboard.song.store'), 'files' => true )) !!}
		{!! $form !!}
		<div class="clearfix"></div>
	{!! Form::close() !!}
	</div>
	
@stop