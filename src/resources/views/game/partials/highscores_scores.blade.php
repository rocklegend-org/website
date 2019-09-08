<?php
	$maxResults = 15;

	if(!isset($where))
	{
		$where = 'YEARWEEK(created_at, 1) = YEARWEEK(NOW(), 1)';
	}
	
	$scoreIds = DB::select(
		DB::raw('select s.id as id from (
			select id, max(score) as score, user_id, created_at, track_id from scores where track_id = :trackId and '.$where.' group by user_id
		) as x inner join scores s on s.user_id = x.user_id and s.score = x.score and s.track_id = x.track_id'),
		['trackId' => $track->id]
	);

	$scores = Score::whereIn('id', array_column($scoreIds, 'id'));

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

	$scores = $scores->orderBy('score', 'DESC')
				->get();

	$user_score = null;

	$userId = User::current()->id;
	foreach ($scores as $score) {
		if ($score->user_id === $userId) {
			$user_score = $score;
			exit;
		}
	}

	$user_rank = array_search(User::current()->id, array_column((array) $scores, 'user_id'));

	if($user_rank !== false){
		$user_rank +=1;
	}

?>
<h3 class="bg-violet">{{isset($heading) ? $heading : 'Global'}}</h3>

@if($noCountry)
<p>Please update the country information in <a href="{{route('profile.edit')}}">your profile</a> to see highscores for your country.<br /><br />
Until then, we'll show the global highscore list under this tab too.</p>
@endif

@foreach($scores as $key => $score)
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
	@if(count($scores) > 0)
	<hr />
	@endif
<p>You have no score on this list yet! Play the track now, and set a new highscore!</p>
@endif

@if(count($scores) <= 0)
<p>There are no scores available for this selection :(</p>
@endif