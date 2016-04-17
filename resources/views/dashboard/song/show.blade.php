@extends('dashboard/layout')

@section('content')

	<div class="heading-sec">
		<h1>{{ $song->title }} <small>by {{ $song->artist->name }}</small></h1>
	</div>

@stop