@extends('layout')

@section('content')
<div class="small-12 medium-12 columns">
	<h1 class="bg-yellow">Messages</h1>
	<br />

	<a href="{{route('conversation.start')}}" class="btn bg-green"><i class="fa fa-envelope"></i> New Message</a>

	<div class="clear"></div>
	<p></p>
	<table>
		<tr>
			<th>Last Message</th>
			<th>Subject</th>
			<th>Users</th>
			<th></th>
			<th></th>
		</tr>
	@foreach($conversations as $conv)
		<tr>
			<td>{{Date::parse($conv->lastMessage()->created_at)->ago()}}</td>
			<td><a href="{{route('conversation.read', array('conversation' => $conv->id))}}">{{$conv->subject}}</a></td>
			<td>
				@foreach($conv->participants as $part)
					<a href="{{route('profile', array('username' => $part->user->username))}}">
						<img src="{{$part->user->getAvatarUrl()}}" style="height:25px;" alt="{{$part->user->username}}" />
					</a>
				@endforeach
			</td>
			<td>
				<a href="{{route('conversation.read', array('conversation' => $conv->id))}}">Read</a>
			</td>
			<td>
				<a href="{{route('conversation.leave', array('conversation' => $conv->id))}}">Leave</a>
			</td>
		</tr>
	@endforeach
	</table>
</div>
@stop