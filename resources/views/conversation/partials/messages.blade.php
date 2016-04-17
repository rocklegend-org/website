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
		$changed = false;

		if($previous_user != $message->user_id){
			$previous_user = $message->user_id;
			$indent *= -1;
			$changed = true;
		}

		if($key <= 0 || ($key > 0 && $changed)){
			if($key > 0){
				?>
					</div>
				</div>
				<div class="clear"></div>
				<?php
			}
		?>
			{{--<div class="message {{ $indent <= -1 ?:'indent' }}">--}}
			<div class="message {{$message->user_id == User::current()->id ?: 'indent'}}">
				<div class="head">
					<img src="{{$message->user->getAvatarUrl()}}" style="width:20px;" />
					<a href="{{route('profile', array('username' => $message->user->username))}}">{{$message->user->username}}</a>
					<br />
				</div>
				<div class="body">
		<?php
		}
		?>
					<small class="meta">{!!\Date::parse($message->created_at)->ago()!!}</small>
					<div class="message-text" data-message-id="{{$message->id}}">
						{!!Helper\RLString::beautify($message->body)!!}
					</div>
		<?php 
		if($key >= count($messages)-1){
		?>
				</div>
			</div>
			<div class="clear"></div>
		<?php
		}
		echo '<div class="clear"></div>';
	}
?>