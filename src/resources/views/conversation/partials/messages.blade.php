<?php
	$indent = 1;
	$previous_user = 0;

	echo '<span class="identifier hide" data-ident="'.md5($messages).'"></span>';
	
	if(!$limit == 0 && $count != $countTotal){
	?>
	<div class="text-center">
		<a href="#" class="js-load-all-messages ajax">load all messages</a>
	</div>
	<?php
	}
	foreach($messages as $key => $message){
	?>
		<div class="clear"></div>
		<div class="message {{$message->user_id == User::current()->id ?: 'indent'}}">
			<div class="head">
				<img src="{{$message->user->getAvatarUrl()}}" style="width:20px;" />
				<a href="{{route('profile', array('username' => $message->user->username))}}">{{$message->user->username}}</a>
				<br />
			</div>
			<div class="body">
				<small class="meta">{!!\Date::parse($message->created_at)->ago()!!}</small>
				<div class="message-text" data-message-id="{{$message->id}}">
					{!!Helper\RLString::beautify($message->body)!!}
				</div>
			</div>
		</div>
	<?php
	}
?>