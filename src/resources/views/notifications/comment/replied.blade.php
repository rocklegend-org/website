<?php 
	$parent_comment = TrackComment::find($groupNotifications[0]->message)->parent;
	$new_comment = TrackComment::find($groupNotifications[0]->message);

	if(!is_null($parent_comment)){
?>
<li class="notification comment-reply {{$notification->active ? 'active' : ''}}" data-notification-id="{{$notification->id}}">
	<a href="{{route('game.play', array('artist' => $parent_comment->track->song->artist->slug, 'song' => $parent_comment->track->song->slug, 'track' => $parent_comment->track->id))}}?ref=notify">
		<div class="left">
			<img src="{{$new_comment->user->getAvatarUrl()}}" alt="{{$new_comment->user->username}}" style="width:60px;" />
		</div>
		<div class="right">
		@if($parent_comment->user_id == User::current()->id)
			@if(count($groupNotifications) > 1)
				There are <b>{{count($groupNotifications)}} new replies</b> to your comment on <b>{{$parent_comment->track->song->title}} ({{$parent_comment->track->getDifficultyName()}})</b>.
			@else
				<b>{{$new_comment->user->username}}</b> replied to your comment on <b>{{$parent_comment->track->song->title}} ({{$parent_comment->track->getDifficultyName()}})</b>
			@endif
		@else
			@if(count($groupNotifications) > 1)
				There are <b>{{count($groupNotifications)}} new replies</b> for a comment you replied on at <b>{{$parent_comment->track->song->title}} ({{$parent_comment->track->getDifficultyName()}})</b>.
			@else
				@if($new_comment->user == $parent_comment->user)
					<b>{{$new_comment->user->username}}</b> replied to {{$new_comment->user->genderPronoun()}} comment you replied on at <b>{{$parent_comment->track->song->title}} ({{$parent_comment->track->getDifficultyName()}})</b>
				@else
					<b>{{$new_comment->user->username}}</b> replied to a comment you replied on at <b>{{$parent_comment->track->song->title}} ({{$parent_comment->track->getDifficultyName()}})</b>
				@endif
			@endif
		@endif
			<br />
			<span class="meta">
			<i class="fa fa-pencil"></i> <?php 
				$date = Date::parse($new_comment->created_at)->ago();
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