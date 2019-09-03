@if (!is_null(Sentry::getUser()))
<?php 
	$notifications = User::current()->notifications()->where('active',1)->groupBy('group_id')->take(10)->orderBy('created_at', 'DESC')->get();

?>
<div class="notifications-container">
	<span class="notification-box">
		<i class="fa fa-bullhorn "></i> {{count($notifications) > 0 ? count($notifications) :''}}
	</span>{{--
	<span class="label bg-white t-red"><i class="fa {{count($notifications) > 0 ? 't-red fa-bullhorn' : 'fa-bell-o'}} notification-toggle"></i> {{count($notifications) > 0 ? count($notifications):''}}</span>--}}
	<ul class="notifications-list">
		<li class="title">Notifications</li>
		@foreach($notifications as $notification)
			<?php
				try{
					$groupNotifications = Notification::where('group_id', $notification->group_id)->where('active',1)->orderBy('created_at','DESC')->where('recipient_id', User::current()->id)->get();
			?>
					@include('notifications.'.$notification->type)
			<?php 
				}catch(Exception $e)
				{
					echo $e->getMessage();
				}
			?>
		@endforeach

		@if(count($notifications) <= 0)
			<li>
			you don't have any new notifications
			</li>
		@endif
	</ul>
</div>
@endif
