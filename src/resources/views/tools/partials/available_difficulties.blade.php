<?php 
	$default = isset($default) ? $default : 0;
?>
@foreach($missing as $diff)
	<option value="{{$diff}}" {{$default == $diff ? 'selected' : ''}} >{{Lang::get('game.difficulties.'.Config::get('game.difficulties.'.$diff.'.name'))}}</option>
@endforeach
@foreach($tracks as $track)
	<option value="{{$track->difficulty}}" disabled="disabled"  {{$default == $track->difficulty ? 'selected' : ''}}>
	{{Lang::get('game.difficulties.'.Config::get('game.difficulties.'.$track->difficulty.'.name'))}} - by {{$track->user->username}}
	</option>
@endforeach