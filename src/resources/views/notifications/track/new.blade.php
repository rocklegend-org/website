<?php 
	$track = Track::find($groupNotifications[0]->message); 
?>
<li class="notification track-new {{$notification->active ? 'active' : ''}}" data-notification-id="{{$notification->id}}">
	<a href="{{$track->url()}}">
		<div class="left">
			<img src="{{$track->user->getAvatarUrl()}}" alt="{{$track->user->username}}" style="width:60px;" />
		</div>
		<div class="right">
		@if(count($groupNotifications) > 1)
			<b>{{$track->user->username}}</b> published new tracks! Play <b>{{$track->song->title}}</b> by <i>{{$track->song->artist->name}}</i> on {{$track->getDifficultyName()}} now!
		@else
			<b>{{$track->user->username}}</b> published a new track!<br />Play <b>{{$track->song->title}}</b> by <i>{{$track->song->artist->name}}</i> on {{$track->getDifficultyName()}} now!
		@endif
			<br />
			<span class="meta">
			<i class="fa fa-music"></i> <?php 
				$date = Date::parse($track->updated_at)->ago();
				echo $date;
			?>
			</span>
		</div>
		<div class="clear"></div>
	</a>
</li>