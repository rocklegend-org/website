<?php
	$maxResults = 15;

	if(!isset($where))
	{
		$where = 'AND YEARWEEK(created_at) = YEARWEEK(NOW())';
	}

	// I'm using this crazy query so i don't have to check for the count of printed users in php
	$scores = DB::table(
				DB::raw('(SELECT * FROM scores WHERE track_id = '.$track->id.'  '.$where.' ORDER BY score DESC) scores')
			)->select(
				DB::raw('*')
			)->leftJoin('users', 'users.id', '=', 'scores.user_id');

	$noCountry = false;

	if(isset($region)){
		switch($region){
			case 'country':
				if(is_numeric(User::current()->country)){
					$scores = $scores->where('users.country', User::current()->country);
				}else{
					$noCountry = true;
				}
				break;
		}
	}

	$scores = $scores->groupBy('user_id')
				->orderBy('score', 'DESC');


	$allScores = $scores->lists('user_id');

	$user_score = clone $scores;
	$user_score = $user_score->where('user_id', User::current()->id)->get();

	$highscores = $scores->take($maxResults)
				->get();

	$user_rank = array_search(User::current()->id, $allScores);

	if($user_rank !== false){
		$user_rank +=1;
	}

?>
<h3 class="bg-violet">{{isset($heading) ? $heading : 'Global'}}</h3>

@if($noCountry)
<p>Please update the country information in <a href="{{route('profile.edit')}}">your profile</a> to see highscores for your country.<br /><br />
Until then, we'll show the global highscore list under this tab too.</p>
@endif

@foreach($highscores as $key => $score)
	<?php $user = User::find($score->user_id); ?>
	<div class="highscore-single">
		<a href="{{$track->url($score->user_id)}}">
			<span class="{{$user->id == User::current()->id ? 'bg-violet' : 'bg-green' }} score bg">
				<span class="rank">{{$key+1}}.</span> 
				<span class="text-right">
				{{ number_format($score->score, 0, ',', '.') }}
				</span>
			</span>
		</a>
		<a href="{{$user->profileUrl()}}">
			<img src="{{$user->getAvatarUrl()}}" alt="{{$user->username}}" />
			<span class="bg bg-violet username">{{ $user->username }}</span>
		</a>
	</div>
	<div class="clear"></div>
@endforeach

@if($user_rank && $user_rank > $maxResults)
<?php 
	$score = $user_score[0];
	$user = User::current();
?>
<div class="highscore-single">
	<a href="{{ route('profile', array('user' => $user->username)) }}">
		<span class="bg-red score bg">
			<span class="rank">{{$user_rank}}.</span> 
			<span class="text-right">
			{{ number_format($score->score, 0, ',', '.') }}
			</span>
		</span>
	
		<img src="{{$user->getAvatarUrl()}}" alt="{{$user->username}}" />
		<span class="bg bg-violet username">{{ $user->username }}</span>
	</a>
</div>
@elseif(!$user_rank)
	@if(count($highscores) > 0)
	<hr />
	@endif
<p>You have no score on this list yet! Play the track now, and set a new highscore!</p>
@endif

@if(count($highscores) <= 0)
<p>There are no scores available for this selection :(</p>
@endif