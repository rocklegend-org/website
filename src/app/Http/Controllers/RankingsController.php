<?php

class RankingsController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function home($sortBy = 'score', $dir = 'desc')
	{
		if(!in_array($sortBy, array('score', 'max_streak', 'max_multiplier', 'notes_hit', 'notes_missed', 'play_mode')) || !in_array(strtoupper($dir), array('DESC', 'ASC'))){
			return Redirect::route('rankings');
		}
		$rankedUsers = DB::table('scores')
						->select('user_id', DB::raw('SUM('.$sortBy.') as total_score'), DB::raw('COUNT(*) as plays'))
						->groupBy('user_id')
						->orderBy('total_score', strtoupper($dir))
						->take(100)
						->get();
		
		return view('rankings.home')
			->with('rankedUsers', $rankedUsers)
			->with('sortBy', $sortBy)
			->with('dir', $dir);
	}

}