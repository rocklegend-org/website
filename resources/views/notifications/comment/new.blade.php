<?php 
	$comment = TrackComment::find($groupNotifications[0]->message); 

	if(!is_null($comment)){
?>
<li class="notification comment-received {{$notification->active ? 'active' : ''}}" data-notification-id="{{$notification->id}}">
	<a href="{{route('game.play', array('artist' => $comment->track->song->artist->slug, 'song' => $comment->track->song->slug, 'track' => $comment->track->id))}}?ref=notify">
		<div class="left">
			<img src="{{$comment->user->getAvatarUrl()}}" alt="{{$comment->user->username}}" style="width:60px;" />
		</div>
		<div class="right">
		@if(count($groupNotifications) > 1)
			You have <b>{{count($groupNotifications)}} new comments</b> for your track <b>{{$comment->track->song->title}} ({{$comment->track->getDifficultyName()}})</b>.
		@else
			<b>{{$comment->user->username}}</b> commented on your track <b>{{$comment->track->song->title}} ({{$comment->track->getDifficultyName()}})</b>.
		@endif
			<br />
			<span class="meta">
			<i class="fa fa-pencil"></i> <?php 
				$date = Date::parse($comment->created_at)->ago();
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