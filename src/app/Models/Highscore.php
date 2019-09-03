<?php

class Highscore extends Score {

	protected $table = 'highscores';

    protected $softDelete = false;

	protected $fillable = array('score_id', 'track_id', 'user_id', 'score', 'max_streak', 'max_multiplier', 'notes_hit', 'notes_missed', 'performance_data', 'play_mode', 'keylog', 'reload_count', 'tracked_score');

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

	public function rank()
	{
		$rank = Highscore::where('track_id', $this->track_id)
					->where('score', '>', $this->score)
					->count();
		return $rank+1;
	}

	public static function latest($count = 100)
	{
		$latest_scores_ids = LRedis::connection()->lrange('last_highscores_ids',0,$count-1);

		if(count($latest_scores_ids) >= $count)
		{
			return Highscore::whereIn('id', $latest_scores_ids)
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
			return Highscore::with('user','track','track.song','track.song.artist')
					->orderBy('id','DESC')
					->take($count)
					->get();
		}
	}

	public function save(array $options = array())
	{
		parent::save();

		try{
			$redis = LRedis::connection();

			$redis->lpush('last_highscores_ids', $this->id);
			$redis->ltrim('last_highscores_ids', 0,99);
		}catch(Exception $e)
		{
			// Redis problems!
		}

		return $this;
	}
}