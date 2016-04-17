@extends('layout')

@section('content')

<div class="small-12 medium-3 columns">
	<a href="{{route('conversation')}}"><i class="fa fa-arrow-circle-left"></i> conversation list</a>

	<br />
	<h3 class="bg-blue">Participants</h3>
	<br />
	@foreach($conversation->participants as $part)
		<img src="{{$part->user->getAvatarUrl()}}" style="width:25px;" />
		&nbsp;<a href="{{route('profile', array('username' => $part->user->username))}}">{{$part->user->username}}
		</a>
		<br />
	@endforeach
</div>

<div class="small-12 medium-6 columns">
	&nbsp;
	<br />
	<h3 class="bg-green" style="display: block; text-align:center;">{{$conversation->subject}}</h3>

	<div class="messages-container" id="conversation-{{$conversation->id}}" data-conversation-id="{{$conversation->id}}">
		{!!$messagesHtml!!}
	</div>

	<div class="clear"></div>

	<form action="{{ route('conversation.message')}}" method="post" id="send-conversation-message" class="ajax" data-before="window.conversations.beforeMessage" data-cb="window.conversations.update" data-conversation-id="{{$conversation->id}}">
		{!! csrf_field() !!}
		<input type="hidden" value="{{$conversation->id}}" name="thread_id" />
		<h3>New Message</h3>
		<br />
		<textarea name="message" placeholder="Write a new message..." style="margin: 0 0 2px 0;" rows="5"></textarea>
		<button class="btn"><i class="fa fa-envelope"></i> Send!</button>
		&nbsp;&nbsp;
		<input type="checkbox" value="1" name="useEnterForSend" /> Send when pressing ENTER
	</form>
</div>

<div class="small-12 medium-3 columns">
&nbsp;
</div>

@stop

@section('footer-scripts')
	<script type="text/javascript">
	$(function(){ 
		window.conversations.init();
	});
	</script>
@stop