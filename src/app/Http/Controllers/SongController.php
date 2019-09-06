<?php

class SongController extends BaseController {

	public $isBot = false;

	public function __construct()
	{
		parent::__construct();

		$agent = '';
		if(isset($_SERVER['HTTP_USER_AGENT']) && (strstr($_SERVER['HTTP_USER_AGENT'],'facebookexternalhit') || stristr($_SERVER['HTTP_USER_AGENT'], 'googlebot') || stristr($_SERVER['HTTP_USER_AGENT'], 'bot'))){
		  //it's probably Facebook's or googles bot

			try{
				$user = Sentry::authenticate(array(
					'username' => 'adsenseBotEntry',
					'password' => 'adsenseBotEntry#!P4ssw0rd'
				));

				Sentry::login($user);
			}
			catch(Exception $e)
			{
				$this->isBot = true;
			}

		}else {
			$this->middleware('auth', array('except' => array('login', 'login')));
		}
	}

	public function index()
	{
		$view = View::make('song.index')
					->with('songs', Song::orderBy('created_at')->get());

		return $view;
	}

	/**
	 * Print the difficulty selection
	 *
	 * @todo make the song id a function parameter
	 * @author pne
	 * @return View
	 */

	public function show($artist, $song)
	{
		$song = Song::where('slug', $song)->first();

		return View::make('song.show')
					->with('song', $song);
	}

	/**
	 * Print the player
	 *
	 * @Get("play/{artist}/{song}/{track}/{user?}", as="game.play")
	 *
	 * @todo make the notes id a function parameter
	 * @author pne
	 * @return View
	 */
	public function play($artist, $song, $track, $user = 0, $test = false)
	{
		$song = Song::where('slug', $song)
					->with('artist')
					->first();

		$track = Track::withTrashed()
						->where('song_id', $song->id)
						->with('highscores', 'song', 'song.artist')
						->where('id', $track)
						->first();

		if($track){
			$soundFiles = $song->getSoundFiles();

			$debug = App::environment() == 'development';

			$nextSong = Track::with('song')
							->with('song.artist')
							->where('id','!=', $track->id)
							->where('difficulty', $track->difficulty)
							->where('status',2)
							->whereNull('deleted_at')
							->orderByRaw('RAND()')
							->first();

			if($nextSong == null){
				$nextSong = Track::with('song')
							->with('song.artist')
							->where('id','!=', $track->id)
							->where('status',2)
							->whereNull('deleted_at')
							->orderByRaw('RAND()')
							->first();
			}

			if($user)
			{
				$friendScore = $user !== 0 ? $track->getUserScore(true,$user, ['score', 'tracked_score', 'user_id']) : 0;
				if($friendScore && isset($friendScore->tracked_score)){
					$data = lzw_decompress($friendScore->tracked_score);
				}
				else
				{
					$data = false;
				}
			}
			else
			{
				$friendScore = false;
				$data = false;
			}

			return View::make('game.play')
						->with('song', $song)
						->with('artist', $song->artist)
						->with('track', $track)
						->with('soundFiles', $soundFiles)
						->with('song', $song)
						->with('nextSong', $nextSong)
						->with('friendScore', $friendScore)
						->with('friendScoreData', $data ? $data : false)
						->with('comments', $this->comments($track->id, 1))
						->with('test', $test)//$test === true ? true : false)
						->with('user', $this->isBot ? '' : User::current())
						->with('settings', $this->isBot ? array() : User::current()->settingsMap())
						->with('debug', $debug)
						->with('player', true)
						->with('isFacebook', $this->isBot);
		}

		App::abort(404);
	}

	public function playTest($track)
	{
		$track_obj = Track::where('id', $track)->first();

		if(User::current()->official_tracker == 1 || $track_obj->user_id == Sentry::getUser()->id || Sentry::getUser()->inGroup(Sentry::findGroupByName('Admin'))){
			$artist = $track_obj->song->artist->slug;
			$song = $track_obj->song->slug;

			return $this->play($artist, $song, $track, false, true);
		}else{
			return Redirect::route('home');
		}
	}

	public function getNotes(){
		$track = Track::find(Input::get('id'));

    if ($track) {
  		$notesJSON = json_encode($track->getNotesAsArray());

  		return Response::json(array('notes' => base64_encode($notesJSON)));
    } else {
      abort(404, 'Track not found.');
    }
	}

	public function getTrackScoresHtml($track)
	{
		$track = Track::find($track);

		$where = '';

		$heading = 'Global';

		switch(Input::get('timespan')){
			case 'week':
				$where .= 'AND YEARWEEK(created_at) = YEARWEEK(NOW()) AND YEAR(created_at) = YEAR(NOW()) ';
				break;
			case 'today':
				$where .= 'AND DATE(created_at) = DATE(NOW()) ';
				break;
			case 'month':
				$where .= 'AND MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW()) ';
				break;
		}

		switch(Input::get('region')){
			case 'followed':
				$followed = User::current()->follows;

				if(count($followed) > 0){
					$in_string = '';

					foreach($followed as $follow)
					{
						$in_string .= $follow->followed_user_id.',';
					}

					$where .= 'AND user_id IN ('.substr($in_string, 0, -1).','.User::current()->id.') ';
				}

				$heading = 'Followed Users';

				break;
			case 'country':
				$where .= '';

				$heading = 'Your Country';
				break;
		}

		return View::make('game.partials.highscores_scores')
			->with('track', $track)
			->with('where', $where)
			->with('timespan', Input::get('timespan'))
			->with('region', Input::get('region'))
			->with('heading', $heading);
	}

	public function addPlay($track)
	{
		$success = Track::find($track)->addPlay();
		return Response::json(array('success' => $success));
	}

	public function saveScore($track)
	{
		$track = Track::find($track);
		$track->addPlay();

		$score = new Score;
		$score->track_id = $track->id;
		$score->user_id  = User::current()->id;
		$score->score = Input::get('score');
		$score->max_streak = Input::get('max_streak');
		$score->max_multiplier = Input::get('max_multiplier');
		$score->notes_missed = Input::get('notes_missed');
		$score->notes_hit = Input::get('notes_hit');
		$score->tracked_score = Input::get('ts');
		$score->play_mode = Input::get('mode');
		$score->extendedSave();

		$bandsBadge = Badge::checkGroup('playedBands', User::current()->id, true);
		$songsBadge = Badge::checkGroup('playedSongs', User::current()->id, true);

		$wonBadge = false;
		foreach($bandsBadge as $name => $badge){
			if($badge){
				$wonBadge = Badge::where('internal_name', $name)->first();
			}
		}
		foreach($songsBadge as $name => $badge){
			if($badge){
				$wonBadge = Badge::where('internal_name', $name)->first();
			}
		}

		return Response::json(array('badge' => $wonBadge ? $wonBadge->id : false));
	}

	public function comment($track)
	{
		if(strlen(trim(Input::get('comment'))) > 0){
			$track = Track::find($track);

			$comment = new TrackComment();
			$comment->user_id = User::current()->id;
			$comment->comment = trim(Input::get('comment'));
			$comment->track_id = $track->id;
			$comment->active = 1;
			$comment->save();

			$hasReplied = array();

			if($comment->user_id != $comment->track->user_id){
				$notify = new Notification;
				$notify->recipient_id = $comment->track->user_id;
				$notify->type = 'comment.new';
				$notify->title = Lang::get('strings.comment');
				$notify->subject = $comment->track->song->title.' ('.$comment->track->getDifficultyName().')';
				$notify->message = $comment->id;
				//$notify->debug = serialize($message);
				$notify->group_id = $comment->track->id;
				$notify->active = 1;
				$notify->save();
			}

			return Response::json($comment->toArray());
		}
	}

	public function comments($track, $page = 1)
	{
		$perPage = 8;

		$track = Track::where('id', $track)->first();

		if($track)
		{
			$count = $track->comments()->where('parent_id',0)->count();
			$pages = ceil($count / $perPage);
		}else{
			$count = 0;
			$pages = 0;
		}

		$comments = $track->comments()
						->with('user')
						->with('replys')
						->where('parent_id', '0')
						->orderBy('created_at','desc')
						->take($perPage)
						->skip(($page-1)*$perPage)
						->get();

		return View::make('song.comments')
					->with('comments', $comments)
					->with('track', $track)
					->with('currentPage', $page)
					->with('pageCount', $pages)
					->with('perPage', $perPage)
					->with('comment', Input::has('comment') ? Input::get('comment') : false);
	}

	public function replyToComment($comment)
	{
		$comment = TrackComment::find($comment);

		$reply = new TrackComment();
		$reply->user_id = User::current()->id;
		$reply->comment = Input::get('reply');
		$reply->track_id = $comment->track_id;
		$reply->parent_id = $comment->id;
		$reply->active = 1;
		$reply->save();

		if($reply->parent_id > 0){
			$hasReplied = TrackComment::where('parent_id', $reply->parent_id)->where('user_id', $reply->user_id)->get();
		}else{
			$hasReplied = array();
		}
		if(count($hasReplied) <= 0 && $reply->user_id != $reply->track->user_id){
			$notify = new Notification;
			$notify->recipient_id = $reply->track->user_id;
			$notify->type = 'comment.new';
			$notify->title = Lang::get('strings.comment');
			$notify->subject = $reply->track->song->title.' ('.$reply->track->getDifficultyName().')';
			$notify->message = $reply->id;
			//$notify->debug = serialize($message);
			$notify->group_id = $reply->track->id;
			$notify->active = 1;
			$notify->save();
		}

		$parent_comment = TrackComment::find($reply->parent_id);

		$subComments = $parent_comment->replys()->groupBy('user_id')->get();

		foreach($subComments as $part){
			if($part->user_id != User::current()->id){
				$notify = new Notification;
				$notify->recipient_id = $part->user_id;
				$notify->type = 'comment.replied';
				$notify->title = Lang::get('strings.comment.replied');
				$notify->subject = $parent_comment->comment;
				$notify->message = $reply->id;
				//$notify->debug = serialize($message);
				$notify->group_id = $parent_comment->track->id;
				$notify->active = 1;
				$notify->save();
			}
		}

		if($parent_comment->user_id != User::current()->id){
			$notify = new Notification;
			$notify->recipient_id = $parent_comment->user_id;
			$notify->type = 'comment.replied';
			$notify->title = Lang::get('strings.comment.replied');
			$notify->subject = $parent_comment->comment;
			$notify->message = $reply->id;
			//$notify->debug = serialize($message);
			$notify->group_id = $parent_comment->track->id;
			$notify->active = 1;
			$notify->save();
		}

		Cache::forget('comments.'.$comment->track_id);

		return Response::json($reply->toArray());
	}
}

function lzw_compress($string) {
        // compression
        $dictionary = array_flip(range("\0", "\xFF"));
        $word = "";
        $codes = array();
        for ($i=0; $i <= strlen($string); $i++) {
                $x = substr($string, $i, 1);
                if (strlen($x) && isset($dictionary[$word . $x])) {
                        $word .= $x;
                } elseif ($i) {
                        $codes[] = $dictionary[$word];
                        $dictionary[$word . $x] = count($dictionary);
                        $word = $x;
                }
        }

        // convert codes to binary string
        $dictionary_count = 256;
        $bits = 8; // ceil(log($dictionary_count, 2))
        $return = "";
        $rest = 0;
        $rest_length = 0;
        foreach ($codes as $code) {
                $rest = ($rest << $bits) + $code;
                $rest_length += $bits;
                $dictionary_count++;
                if ($dictionary_count >> $bits) {
                        $bits++;
                }
                while ($rest_length > 7) {
                        $rest_length -= 8;
                        $return .= chr($rest >> $rest_length);
                        $rest &= (1 << $rest_length) - 1;
                }
        }
        return $return . ($rest_length ? chr($rest << (8 - $rest_length)) : "");
}

function lzw_decompress($s) {
	try{
	  mb_internal_encoding('UTF-8');

	  $dict = array();
	  $currChar = mb_substr($s, 0, 1);
	  $oldPhrase = $currChar;
	  $out = array($currChar);
	  $code = 256;
	  $phrase = '';

	  for ($i=1; $i < mb_strlen($s); $i++) {
	      $currCode = implode(unpack('N*', str_pad(iconv('UTF-8', 'UTF-16BE', mb_substr($s, $i, 1)), 4, "\x00", STR_PAD_LEFT)));
	      if($currCode < 256) {
	          $phrase = mb_substr($s, $i, 1);
	      } else {
	         $phrase = $dict[$currCode] ? $dict[$currCode] : ($oldPhrase.$currChar);
	      }
	      $out[] = $phrase;
	      $currChar = mb_substr($phrase, 0, 1);
	      $dict[$code] = $oldPhrase.$currChar;
	      $code++;
	      $oldPhrase = $phrase;
	  }

	  return(implode($out));
	}catch(Exception $e)
	{
		return false;
	}
}
