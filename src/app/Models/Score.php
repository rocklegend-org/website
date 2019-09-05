<?php

class Score extends Eloquent {

	protected $table = 'scores';

    protected $softDelete = false;

	protected $fillable = array('track_id', 'user_id', 'score', 'max_streak', 'max_multiplier', 'notes_hit', 'notes_missed', 'performance_data', 'play_mode', 'keylog', 'reload_count', 'tracked_score');

	public function track()
	{
		return $this->belongsTo('Track');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function scopeForTrack($query, $track)
	{
		return $query->where('track_id', $track);
	}

	public function scopeForUser($query, $user)
	{
		return $query->where('user_id', $user);
	}

	public function scopeDate($query, $timespan = "today")
	{
		switch($timespan)
		{
			case "today":
				return $query->where('created_at', '>', DB::raw('DATE_SUB(NOW(), INTERVAL 1 DAY)'));
			case "week":
				return $query->where('created_at', '>', DB::raw('DATE_SUB(NOW(), INTERVAL 1 WEEK)'));
			default:
			case "month":
				return $query->where('created_at', '>', DB::raw('DATE_SUB(NOW(), INTERVAL 1 MONTH)'));
		}
	}

	public function uniqueScores()
	{
		$res = Score::where('track_id', $this->track_id)
				->groupBy('user_id')
				->count();

		return $res;
	}

	public static function latest($count = 100)
	{
		$latest_scores_ids = LRedis::connection()->lrange('last_scores_ids',0,$count-1);

		if(count($latest_scores_ids) >= $count)
		{
			return Score::whereIn('id', $latest_scores_ids)
					->with('user')
					->with(
						array(
							'track' => function($query)
							{
								$query->with(
									array(
										'song' => function($query)
										{
											$query->with('artist');
										}
									));
							})
					)
					->get();
		}
		else
		{
			return Score::with('user','track','track.song','track.song.artist')
					->orderBy('id','DESC')
					->take(5)
					->get();
		}
	}

	public function extendedSave(array $options = array())
	{
		parent::save();

		$highestScore = Highscore::where('track_id', $this->track_id)
						->where('user_id', $this->user_id)
						->orderBy('score', 'DESC')
						->first();

		$data = $this->replicate();
		$data = $data->toArray();
		$data['score_id'] = $this->id;
		unset($data['id']);

		if($highestScore && $highestScore->score <= $this->score)
		{
			$highestScore->delete();

			Highscore::create($data);
		}else if(!$highestScore || $highestScore == null)
		{
			Highscore::create($data);
		}

		try{
			$redis = LRedis::connection();

			$redis->lpush('last_scores_ids', $this->id);
			$redis->ltrim('last_scores_ids', 0,99);

			Cache::forget($this->track_id.'.cache');
		}catch(Exception $e)
		{
			// Redis problems!
		}

		return $this;
	}
}