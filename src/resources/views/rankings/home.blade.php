@extends('layout')

@section('page_title')
Tools | rocklegend
@overwrite

@section('content')

<div class="small-12 medium-1 columns">
&nbsp;
</div>

<div class="small-12 medium-9 columns">
	<p>We're currently working an an <i>awesome fan/experience system</i> and the all new rocklegend design.<br />
		<b>Until this is done, you can check the top 100 players in this simple list :)</b></p>
	
	<h2 class="bg-blue">Best players by {{$sortBy}}</h2>
	<table class="full-width">
		<thead>
			<tr>
				<th>#</th>
				<th>User</th>
				<th>Total Points</th>
				<th>Songs played</th>
			</tr>
		</thead>
		<tbody>
		@foreach($rankedUsers as $key => $rankedUser)
		<?php $user = User::find($rankedUser->user_id); ?>
		<tr <?=($user->id == User::current()->id) ? 'class="highlight"':''?>>
			<td>{{$key+1}}</td>
			<td><a href="{{$user->profileUrl()}}" style="padding-right: 4px;"><img src="{{$user->getAvatarUrl()}}" style="height: 35px; position:relative; top: 0px;" />&nbsp;&nbsp;{{$user->username}}</td>
			<td>{{number_format($rankedUser->total_score, 0, ',','.')}}</td>
			<td>{{$rankedUser->plays}}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
		
</div>

<div class="small-12 medium-1 columns">
&nbsp;
</div>

@stop