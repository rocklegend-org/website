<?php

class Badge extends Eloquent {

	protected $table = 'badges';

	public function user()
	{
		return $this->hasMany('User');
	}

	public static function findByInternalName($internalName) {
		return Cache::remember('badge.'.$internalName, 30, function() use($internalName) {
			return Badge::where('internal_name', $internalName)->first();
		});
	}

	public static function check($badgeName, $user = false, $autoAward = false, $awardComment = '')
	{
		if(!$user) $user = User::current();

		$checkFunction = Config::get('badges.'.$badgeName)['checkFunction'];
		$target = Config::get('badges.'.$badgeName)['target'];
		
		$result = BadgeCheck::$checkFunction($target, $user);

		if($result && $autoAward){
			Badge::award($badgeName, $user, $awardComment);
		}

		return $result;
	}

	public static function checkGroup($groupName, $user = false, $autoAward = false, $awardComment = '')
	{
		if(!$user) $user = User::current();

		$results = array();

		foreach(Config::get('badges') as $badgeName => $badge)
		{
			if($badge['group'] == $groupName){
				$oBadge = Badge::findByInternalName($badgeName);
				$hasBadge = UserBadge::where('user_id', $user->id)->where('badge_id', $oBadge->id)->first();
				if(!$hasBadge){
					$checkFunction = $badge['checkFunction'];
					$target = $badge['target'];
					
					$result = BadgeCheck::$checkFunction($target, $user);

					if($result && $autoAward){
						Badge::award($badgeName, $user, $awardComment);
					}

					$results[$badgeName] = $result;
				}
			}
		}

		return $results;
	}

	public static function award($badgeName, $user = false, $comment = '')
	{
		if(!$user) $user = User::current();

		$badge = Badge::findByInternalName($badgeName);

		$hasBadge = UserBadge::where('user_id', $user->id)
			->where('badge_id', $badge->id)
			->first();

		if(is_null($hasBadge)){
			$awardedBadge = new UserBadge;
			$awardedBadge->badge_id = $badge->id;
			$awardedBadge->user_id = $user->id;
			$awardedBadge->comment = $comment;
			$awardedBadge->save();
			return $awardedBadge;
		}
	
		return false;
	}

	public static function withdraw($badgeName, $user = false, $comment = '')
	{
		if(!$user) $user = User::current();

		$badge = Badge::findByInternalName($badgeName);

		$hasBadge = UserBadge::select('id')
			->where('user_id', $user->id)
			->where('badge_id', $badge->id)
			->first();

		if(!is_null($hasBadge)){
			$hasBadge->delete();
			return true;
		}
		return false;
	}
}

class BadgeCheck {
	public static function donator($target, $user){
		return false;
	}

	public static function earlyAccess($n, $user)
	{
		return strtotime($user->created_at) <= strtotime('30.11.2014');
	}

	public static function playedSongs($target, $user)
	{
		$count = Cache::remember(
			'scoreCount.user.'.$user->id,
			5,
			function() use ($user) {
				return Score::where('user_id', $user->id)->count();
			}
		);
		
		return $count >= $target;
	}

	public static function playedBands($target, $user)
	{
		$scores = Score::select(DB::raw('count(DISTINCT artists.id) as count'))
			->where('scores.user_id', $user->id)
			->join('tracks', 'tracks.id', '=', 'scores.track_id')
			->join('songs', 'songs.id', '=', 'tracks.song_id')
			->join('artists', 'artists.id', '=', 'songs.artist_id')
			->value('count');

		return $scores >= $target;
	}
}