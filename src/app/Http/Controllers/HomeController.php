<?php

use Michelf\Markdown;

class HomeController extends BaseController {
	public function index()
	{
		$lastHighscores = Highscore::latest(5);

		$newestTracks = Track::where('status', 2)
							->select('id', 'song_id', 'user_id', 'difficulty')
							->where('difficulty','>',0)
							->orderBy('updated_at', 'DESC')
							->with('song', 'song.artist', 'user')
							->take(5)
							->get();

		$hotTracks = Highscore::leftJoin('tracks','tracks.id','=','highscores.track_id')
							->select('track_id',DB::raw('count(*) as total'))
							->where('difficulty', '>', '0')
							->where(DB::raw('MONTH(highscores.created_at)'), '>=', DB::raw('MONTH(NOW())'))
							->where(DB::raw('YEAR(highscores.created_at)'), DB::raw('YEAR(NOW())'))
							->groupBy('highscores.track_id')
							->orderBy('total','DESC')
							->with('track.user', 'track.song', 'track.song.artist')
							->take(3)
							->get();

		return View::make('home')
			->with('lastScores', $lastHighscores)
			->with('newestTracks', $newestTracks)
			->with('hotTracks', $hotTracks->map(function($score) { return $score->track; }));
	}

	public function showImprint()
	{
		return view('imprint');
	}

	public function showTerms()
	{
		return view('tos');
	}

	public function showStatistics()
	{
		header('X-Frame-Options: GOFORIT');

		$user = Sentinel::getUser();

		if($user != null && $user->inRole('admin')){

			switch(Input::get('page')){
				case 'trackplaycount':
					switch(Input::get('timespan')){
						case 'today':
							$scores = Score::selectRaw('*, COUNT(*) as c')->where(DB::raw('DATE(created_at)'),'=',DB::raw('DATE(NOW())'))->groupBy('track_id')->orderBy(DB::raw('COUNT(*)'), 'DESC')->get();
							break;
						case 'month':
							$scores = Score::selectRaw('*, COUNT(*) as c')->where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'),'=',DB::raw('EXTRACT(YEAR_MONTH FROM NOW())'))->where(DB::raw('MONTH(created_at)'),'=',DB::raw('MONTH(NOW())'))->groupBy('track_id')->orderBy(DB::raw('COUNT(*)'), 'DESC')->get();
							break;
						case 'week':
							$scores = Score::selectRaw('*, COUNT(*) as c')->where(DB::raw('YEARWEEK(created_at, 1)'),'=',DB::raw('YEARWEEK(NOW(), 1)'))->groupBy('track_id')->orderBy(DB::raw('COUNT(*)'), 'DESC')->get();
							break;
						default:
							$scores = Score::selectRaw('*, COUNT(*) as c')->groupBy('track_id')->orderBy(DB::raw('COUNT(*)'), 'DESC')->get();
							break;
					}

					return view('stats.trackplaycount')
						->with('timespan', Input::get('timespan'))
						->with('scores', $scores);

				case 'users':
					$scores = Score::selectRaw('*, COUNT(*) as c')->groupBy('user_id')->orderBy(DB::raw('COUNT(*)'), 'DESC')->get();

					return view('stats.users')
						->with('scores', $scores);

				case 'analytics':

					return view('stats.analytics');

				case 'delete_comment':
					$comment = TrackComment::find(Input::get('comment_id'));
					$comment->delete();

					return Redirect::back();

				default:
					$songs = Song::count();
					$artists=Artist::count();
					$album = Album::count();
					$scores = Score::count();
					$users = User::count();
					$tracks = Track::count();
					$scoresByUsers = Score::count(DB::raw('DISTINCT user_id'));
					$comments = TrackComment::count();
					$latestComments = TrackComment::orderBy('created_at', 'desc')->take(20)->with('track.song.artist')->get();
					
					return view('stats.index')
						->with('songs',$songs)
						->with('artists',$artists)
						->with('albums',$album)
						->with('scores', $scores)
						->with('users',$users)
						->with('scoresByUsers', $scoresByUsers)
						->with('comments', $comments)
						->with('latestComments', $latestComments)
						->with('tracks',$tracks);
			}
		}
	}

}
