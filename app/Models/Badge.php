<?php

class Badge extends Eloquent {

	protected $table = 'badges';

	public function user()
	{
		return $this->hasMany('User');
	}

	public static function check($badgeName, $user_id = false, $autoAward = false, $awardComment = '')
	{
		if(!$user_id) $user_id = User::current()->id;
		$checkFunction = Config::get('badges.'.$badgeName)['checkFunction'];
		$target = Config::get('badges.'.$badgeName)['target'];
		
		$result = BadgeCheck::$checkFunction($target, $user_id);

		if($result && $autoAward){
			Badge::award($badgeName, $user_id, $awardComment);
		}

		return $result;
	}

	public static function checkGroup($groupName, $user_id = false, $autoAward = false, $awardComment = '')
	{
		if(!$user_id) $user_id = User::current()->id;

		$results = array();

		foreach(Config::get('badges') as $badgeName => $badge)
		{
			if($badge['group'] == $groupName){
				$oBadge = Badge::where('internal_name', $badgeName)->first();
				$hasBadge = UserBadge::where('user_id', $user_id)->where('badge_id', $oBadge->id)->first();
				if(!$hasBadge){
					$checkFunction = $badge['checkFunction'];
					$target = $badge['target'];
					
					$result = BadgeCheck::$checkFunction($target, $user_id);

					if($result && $autoAward){
						Badge::award($badgeName, $user_id, $awardComment);
					}

					$results[$badgeName] = $result;
				}
			}
		}

		return $results;
	}

	public static function award($badgeName, $user_id = false, $comment = '')
	{
		if(!$user_id) $user_id = User::current()->id;

		$badge = Badge::where('internal_name', $badgeName)->first();

		$hasBadge = UserBadge::where('user_id', $user_id)->where('badge_id', $badge->id)->first();

		if(is_null($hasBadge)){
			$awardedBadge = new UserBadge;
			$awardedBadge->badge_id = $badge->id;
			$awardedBadge->user_id = $user_id;
			$awardedBadge->comment = $comment;
			$awardedBadge->save();
			return $awardedBadge;
		}
		return false;
	}

	public static function withdraw($badgeName, $user_id = false, $comment = '')
	{
		if(!$user_id) $user_id = User::current()->id;

		$badge = Badge::where('internal_name', $badgeName)->first();

		$hasBadge = UserBadge::where('user_id', $user_id)->where('badge_id', $badge->id)->first();

		if(!is_null($hasBadge)){
			$hasBadge->delete();
			return true;
		}
		return false;
	}
}

class BadgeCheck{
	public static function donator($target, $user_id){
		return false;
	}
	public static function earlyAccess($n, $user_id)
	{
		return strtotime(User::find($user_id)->created_at) <= strtotime('30.11.2014');
	}
	public static function playedSongs($target, $user_id)
	{
		return Score::where('user_id', $user_id)->count() + OldScore::where('user_id', $user_id)->count() >= $target;
	}

	public static function playedBands($target, $user_id)
	{
		$scores = Score::where('user_id', $user_id)->with('track')->get();

		$bands = array();
		foreach($scores as $score){
			if(!in_array($score->track->song->artist->id, $bands)){
				$bands[] = $score->track->song->artist->id;
			}
		}

		$oldScores = OldScore::where('user_id', $user_id)->with('track')->get();
		foreach($oldScores as $score){
			if(!in_array($score->track->song->artist->id, $bands)){
				$bands[] = $score->track->song->artist->id;
			}
		}

		return count($bands) >= $target;
	}
}