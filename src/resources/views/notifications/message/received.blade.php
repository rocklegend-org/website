<?php 
	$message = Message::find($groupNotifications[0]->message);

	if(is_object($message))
	{
?>
<li class="notification message-received {{$notification->active ? 'active' : ''}}" data-notification-id="{{$notification->id}}">
	<a href="{{route('conversation.read', array('conversation' => $message->thread_id))}}">
		<div class="left">
			<img src="{{$message->user->getAvatarUrl()}}" alt="{{$message->user->username}}" style="width:60px;" />
		</div>
		<div class="right">
		@if(count($groupNotifications) > 1)
			You have <b>{{count($groupNotifications)}} new messages</b> in the conversation <b>{{$message->thread->subject}}</b>.
		@else
			<b>{{$message->user->username}}</b> sent you a message: "{{strlen($message->body) <= 75 ? $message->body : substr($message->body, 0, 75).'...'}}"
		@endif
			<br />
			<span class="meta">
			<i class="fa fa-envelope"></i> <?php 
				$date = Date::parse($message->created_at)->ago();
				echo $date;
			?>
			</span>
		</div>
		<div class="clear"></div>
	</a>
</li>
<?php
	}
?>