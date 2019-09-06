<?php
use Illuminate\Database\Eloquent\SoftDeletes;

class Track extends Eloquent {
	use SoftDeletes;

	protected $table = 'tracks';

    protected $softDelete = true;

	public function song()
	{
		return $this->belongsTo('Song');
	}

	public function artist()
	{
		return $this->belongsTo('Artist');
	}

	public function user()
	{
		return $this->belongsTo('User')->withTrashed();
	}

	public function difficulty()
	{
		return $this->belongsTo('Difficulty');
	}

	public function scores()
	{
		return $this->hasMany('Score');
	}

	public function highscores()
	{
		return $this->hasMany('Highscore');
	}

	public function comments()
	{
		return $this->hasMany('TrackComment');
	}

	public function delete()
	{
		Score::where('track_id', $this->id)->delete();

		return parent::delete();
	}

	public function url($user_id = false)
	{
		return route('game.play', array('artist' => $this->song->artist->slug, 'song' => $this->song->slug, 'track' => $this->id, 'user' => $user_id));
	}

	public function getUserScore($asObject = false, $user_id = false, $fields = ['score'])
	{
		if(Sentry::getUser() !== null){
			if($user_id){			
				$score = $this->highscores()
							->select($fields)
							->where('user_id', $user_id)
							->first();
			}else{
				$score =  $this->highscores()
							->select($fields)
							->where('user_id', User::current()->id)
							->first();
			}

			if($score != NULL)
			{
				return $asObject ? $score : $score->score;
			}
		}
		
		return '0';
	}

	public function getHighscore($timespan = false, $asObject = false)
	{
		if($timespan){
			$score = $this->highscores()
						->select('score', 'user_id')
						->with('user')
						->date($timespan)
						->orderBy('score', 'desc')
						->first();
		}else{
			$score = $this->highscores()
						->select('score', 'user_id')
						->with('user')
						->where('track_id',$this->id)
						->orderBy('score', 'desc')
						->first();
		}

		if(is_object($score)){
			return $asObject ? $score : $score->score;
		}

		return 0;
	}

	public function getDifficultyName()
	{
		return Lang::get('game.difficulties.'.Config::get('game.difficulties.'.$this->difficulty.'.name'));
	}

	public function getStatus()
	{
		return Config::get('game.trackstates.'.$this->status);
	}

	public function getNotesAsArray()
	{
		try
		{
			return unserialize($this->data);
		}
		catch( Exception $e)
		{
			return array();
		}
	}

	/**
	 * Serializes the given $notesData, depending on type it first decodes a json string.
	 *
	 * @param mixed        $notesData	can be (array) or (string)
	 *
	 * @return Note
	 */
	public function setNotesFromArray( $notesData )
	{
		if(is_array($notesData)){
			$this->data = serialize($notesData);
		}else if(is_string($notesData)){
			$this->data = serialize(json_decode($notesData));
		}else{
			throw new Exception("Expected $notesArray to be array or string, '".gettype($notesData)."' was given.");
		}

		return $this;
	}

	public function getCount()
	{
		return $this->getArrCount($this->getNotesAsArray(),1);
	}

	public function getArrCount ($array, $limit=1) { 
	    $count = 0; 

	    if(is_array($array)){
		    foreach ($array as $id => $_array) { 
		        if (is_array ($_array) && $limit > 0) { 
		            $count += $this->getArrCount ($_array, $limit - 1); 
		        } else { 
		            $count += 1; 
		        } 
		    } 
		}
		
	    return $count; 
	} 

	public function toBitBands()
	{
		$bitBands = array('','','','','');

		$notesArray = $this->getNotesAsArray();
		//$notesArray = json_decode($this->data);

		foreach($notesArray as $key => &$string)
		{
			foreach($string as &$note)
			{
				$note['start'] = round($note['start'],2);
				$note['end']   = round($note['end'], 2);
				$note['duration']   = round(($note['end']-$note['start']), 2);

				while($note['start'] > strlen($bitBands[$key-1])*0.01){
					$bitBands[$key-1] .= '0';
				}
				for($i = $note['start']; $i <= $note['end']; $i+=0.01){
					$bitBands[$key-1] .= '1';
				}
			}
		}

		return $bitBands;
	}

	public function addPlay()
	{
		$this->play_count++;
		$this->save();
	}

	public function getStatusName()
	{
		return Lang::get('game.trackstates.'.Config::get('game.trackstates.'.$this->status));
	}

	public function getPlayCount()
	{
		$meta = Track::withCount('scores')->where('id', $this->id)->first();
		return $meta['scores_count'];
	}

	public function getPlayCountHistory($format = false)
	{
		$scores = new Score;


		switch($format)
		{
			case 'js':
				$scores = $scores->where('track_id', $this->id)->date('month')->orderBy('created_at', 'asc')->get();
				break;
			default:
				$scores = $scores->where('track_id', $this->id)->orderBy('created_at', 'asc')->get();
				break;
		}

		$scoresByDate = array();

		foreach($scores as $score)
		{
			switch($format)
			{
				case 'js':
					$date = date('d/m', strtotime($score->created_at));
					break;
				default:
					$date = date('d.m.Y', strtotime($score->created_at));
					break;
			}

			if(!isset($scoresByDate[$date]))
			{
				$scoresByDate[$date] = 0;
			}

			$scoresByDate[$date]++;
		}

		switch($format)
		{
			case 'js':
				$arr = array(
					'labels' => array(),
					'datasets' => array(
						array(
							'label' => 'Plays',
							'fillColor' => 'rgba(255,204,0,0.2)',
				            'strokeColor' => 'rgba(220,220,220,1)',
				            'pointColor' => 'rgba(255,204,0,1)',
				            'pointStrokeColor' => '#fff',
				            'pointHighlightFill' => '#fff',
				            'pointHighlightStroke' => 'rgba(220,220,220,1)',
				            'data' => array()
						)
					)
				);

				foreach($scoresByDate as $date => $count)
				{
					$arr['labels'][] = $date;
					$arr['datasets'][0]['data'][] = $count;
				}

				return json_encode($arr);

			default: 
				return $scoresByDate;
		}
	}
}