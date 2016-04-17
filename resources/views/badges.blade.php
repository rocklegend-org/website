@extends('layout')

@section('page_title')
all badges | rocklegend
@overwrite

@section('content')

<div class="small-12 columns">
	
	<h1 class="bg-black">All Available Badges</h1>
	<p>
		Badges you already acquired are transparent.
	</p>
	<br />
	<div>
		@foreach($badges as $badge)
			@include('profile.partials.badge', array('badge' => $badge,'direct' => true, 'cols' => 4, 'fixedHeight' => true))
		@endforeach
		<div class="clear"></div>
	</div>
</div>
@stop