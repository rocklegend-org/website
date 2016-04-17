<?php
	if(!isset($direct) || $direct == false){
		$badge_direct = $badge->badge;
	}else{
		$badge_direct = $badge;
	}

	if(!isset($cols)){
		$cols = 12;
	}

	$hasBadge = false;
	if(User::current()->id && User::current()->hasBadge($badge_direct->id)){
		$hasBadge = true;
	}
?>
<div class="badge-single small-{{$cols}} columns <?php echo isset($fixedHeight) ? 'fixed-height' : ''; echo $hasBadge && isset($fixedHeight) ? ' bg-green' : ''; ?>" data-equalizer>
	<div class="left" data-equalizer-watch>
		<table><tr><td valign="middle"><a href="{{asset('assets/images/frontend/badges/'.$badge_direct->image)}}" rel="group" class="fancybox"><img src="{{asset('assets/images/frontend/badges/'.$badge_direct->image)}}" width="50" alt="{{$badge_direct->description}}" /></a></td></tr></table>
	</div>
	<div class="r" data-equalizer-watch>
		<h3 class="bg-green">{{$badge_direct->name}}</h3>
		<p>{{$badge_direct->description}}
			@if($badge != $badge_direct)
			<br />
			<small>{{Date::parse($badge->created_at)->ago()}}</small>
			@endif
		</p>
	</div>
	<div class="clear"></div>
</div>