<?php

class ToolsController extends BaseController {

	public function __construct()
	{		
		parent::__construct();
		
		$this->middleware('auth', array('except' => array('login', 'login')));
	}

	public function index()
	{
		$myTracks = Track::where('user_id', Sentry::getUser()->id)
					->with('song', 'song.artist')
					->orderBy('updated_at', 'desc')
					->get();

		$view = View::make('tools.index')
					->with('myTracks', $myTracks);

		return $view;
	}

	public function trash()
	{
		$trashedTracks = Track::where('user_id', User::current()->id)
						->withTrashed()
						->with('song', 'song.artist')
						->whereNotNull('deleted_at')
						->orderBy('updated_at')
						->get();

		return View::make('tools.trashed')
			->with('tracks', $trashedTracks);
	}

	/**
	 * Print the "new song" formular
	 *
	 * This formular needs only the most basic information to make
	 * the creation of a new song as quick and easy as possible
	 * 
	 * @author pne
	 * @return View
	 */

	public function newSong()
	{
		if(Request::isMethod('get')){
			return View::make('tools.new_song');
		}else{
			$song = new Song;

			$song->title = Input::get('song_title');
			$song->status = 1; // TODO: deactivate!
			
			$artist = Artist::firstOrCreate(array(
				'name' => Input::get('artist_name')
			));

			if($artist->hasErrors())
			{
				return $errorReturnRoute->withErrors($artist->getErrors());
			}

			$song->artist_id = $artist->id;

			$song->save();

			$song->addMusicFileFromUpload(Input::file('audio_file'));

			return Redirect::route('create.editor', array('song' => $song->slug, 'lanes' => Input::get('lanes')));
		}	
	}

	/**
	 * Print the "new track" formular
	 *
	 * This formular prints a list of all available songs
	 * and redirects the user to the track editor for a new note highway for this song
	 * 
	 * @author pne
	 * @return View
	 */

	public function newTrack()
	{
		if(Request::isMethod('get')){
			$songs = new Song;
			$songs = $songs->where('trackable',1)->get();

			$song_list = array();

			foreach($songs as $song){
				if(!$song->hasAllTracks()){
					$song_list[$song->id] = $song->artist->name.' - '.$song->title;
				}
			}

			return View::make('tools.new_track')
						->with('song_list', $song_list);
		}else{
			$song = Song::find(Input::get('song_id'));

			return Redirect::route('create.editor', array('song' => $song->slug, 'difficulty' => Input::get('difficulty_id')));
		}	
	}

	public function missingDifficultiesSelect()
	{
		return View::make('tools.partials.available_difficulties')
				->with('missing',  Song::find(Input::get('song_id'))->missingDifficulties())
				->with('tracks', Track::where('song_id', Input::get('song_id'))->where('status', 2)->get());
	}

	/**
	 * Print the editor
	 *
	 * @author pne
	 * @return View
	 */

	public function editor($song = null, $difficulty_id = null, $track = null)
	{
		if(Request::isMethod('get')){
			if(is_null($song)){
				return Redirect::route('create.new_song');
			}

			$song = Song::where('slug', $song)->first();

			if($song->trackable != 1 && 
			   (is_null($track) || Track::where('id', $track)->first()->user_id != User::current()->id))
			{
				return Redirect::route('create.new_song');
			}

			$view = Input::has('old') ? 'tools.editor_old' : 'tools.editor';
			
			if(is_null($track)){
				$track = new Track;
				$track->name = $song->title.' tracked by '.User::current()->username;
				$track->lanes = 5;
				$track->setNotesFromArray([[],[],[],[],[]]);
				$track->user_id = User::current()->id;
				$track->px_per_second = 200;
				$track->difficulty = $difficulty_id;
				$track->song_id = $song->id;
				$track->save();

				return Redirect::route('create.editor', array('song' => $track->song->slug, 'track' => $track->id, 'difficulty_id' => $track->difficulty));
			}else{
				$track = Track::withTrashed()->find($track);

				if($track->song != $song)
				{
					return Redirect::route('tools');
				}
			}

			return View::make($view)
						->with('user', User::current())
						->with('song', $song)
						->with('soundFiles', $song->getSoundFiles())
						->with('lanes', $track->lanes)
						->with('track', $track);
		}else{
			$song = Song::where('slug', $song)->first();

			$date = new \DateTime;

			$track = Track::where('id', $track)->first();

			if($track->status != Input::get('status') && Input::get('status') == 1){
				$this->sendReviewMail($track);
			}

			$track->setNotesFromArray(Input::get('notes'));

			if($track->data == 'N;'){
				return Response::json(array('track_id' => $track->id, 'note_count' => $track->getCount(), 'status' => $track->status, 'error' => 'serialized.corrupt'));
			}

			if($track->status != 2 && Input::get('status') == 2 && User::current()->official_tracker == 1){
				$followers = Follower::where('followed_user_id', $track->user_id)->get();

				foreach($followers as $follower){
					$notify = new Notification;
					$notify->recipient_id = $follower->stalker_user_id;
					$notify->type = 'track.new';
					$notify->title = 'New track by '.$track->user->username;
					$notify->subject = $track->song->title;
					$notify->message = $track->id;
					$notify->group_id = 'track.new.'.$track->user_id;
					$notify->active = 1;
					$notify->save();
				}
			}	

			$track->name = $song->title.' tracked by '.User::current()->username;
			$track->lanes = 5;
			$track->updated_at = $date;
			$track->px_per_second = Input::get('px_per_second');
			$track->status = Input::get('status');
			$track->difficulty = Input::get('difficulty');
			$track->save();

			// Tracks under 100 notes should be reviewed before they are accepted
			if($track->status == 2 && ($track->getCount() < 100 || User::current()->official_tracker != 1)){
				$track->status = 1;
				$track->save();
				$this->sendReviewMail($track);
			}

			$countHistory = TrackHistory::where('track_id', $track->id)->count();

			if($countHistory >= 10){
				TrackHistory::where('track_id', $track->id)->first()->delete();
			}

			$version = $countHistory <= 0 ? 1 : $countHistory+1; 

			$history = new TrackHistory;
			$history->version = $version;
			$history->tracK_id = $track->id;
			$history->name = $song->title.' tracked by '.User::current()->username;
			$history->song_id = $song->id;
			$history->lanes = $track->lanes;
			$history->data = $track->data;
			$history->user_id = Sentry::getUser()->id;
			$history->px_per_second = Input::get('px_per_second');
			$history->status = Input::get('status');
			$history->save();

			Cache::forget('track.'.$track->id);

			return Response::json(array('track_id' => $track->id, 'note_count' => $track->getCount(), 'status' => $track->status));
		}
	}

	public function uploadMidi($track = 'new')
	{
		$song = Song::where('slug','=',Input::get('slug'))->first();

		$midiFile = $song->addMidiFileFromUpload(Input::file('midi'));

		if($track == 'new'){
			$track = new Track;
			$track->name = $song->title.' tracked by '.User::current()->username;
			$track->song_id = $song->id;
			$track->lanes = 5;
			$track->user_id = User::current()->id;
			$track->px_per_second = Input::get('px_per_second');
			$track->status = Input::get('status');
			$track->difficulty = Input::get('difficulty');
			$track->save();
		}else{
			$track = Track::find($track);
		}

		// load midifile and get xml data
		$midiParser = new MidiParser;
		$notes = $midiParser->midiToNotesArray($midiFile->getRealPath(), Config::get('game.difficulties'));

		$possible_tracks = array();

		if(!empty($notes) && isset($notes['difficulties']))
		{
			foreach($notes['difficulties'] as $difficulty_id => $difficulty_notes)
			{
				if($this->getArrCount($difficulty_notes,1) > 1){
					$possible_tracks[] = $this->getArrCount($difficulty_notes,1)-5;
				}
			}
		}

		return Response::json(array('success' => true, 'track' => $track->id, 'song' => $track->song->slug, 'lanes' => $track->lanes));
	}

	public function analyzeMidi($song)
	{
		$song = Song::where('slug', '=', $song)->first();

		// load midifile and get xml data
		$midiParser = new MidiParser;
		$notes = $midiParser->midiToNotesArray($song->getMidi(), Config::get('game.difficulties'));

		$possible_tracks = array();

		if(!empty($notes) && isset($notes['difficulties']))
		{
			foreach($notes['difficulties'] as $difficulty_id => $difficulty_notes)
			{
				if($this->getArrCount($difficulty_notes,1) > 1){
					$possible_tracks[] = $this->getArrCount($difficulty_notes,1)-5;
				}
			}
		}

		return Response::json(array('success' => true, 'possible_tracks' => $possible_tracks));
	}

	public function getArrCount ($array, $limit=1) { 
	    $count = 0; 
	    foreach ($array as $id => $_array) { 
	        if (is_array ($_array) && $limit > 0) { 
	            $count += $this->getArrCount ($_array, $limit - 1); 
	        } else { 
	            $count += 1; 
	        } 
	    } 
	    return $count; 
	} 

	public function selectMidiTrack($key, $track)
	{
		$track = Track::find($track);
		$song = $track->song;

		// load midifile and get xml data
		$midiParser = new MidiParser;
		$notes = $midiParser->midiToNotesArray($song->getMidi(), Config::get('game.difficulties'));

		$possible_tracks = array();

		if(!empty($notes) && isset($notes['difficulties']))
		{
			$counter = 0;
			foreach($notes['difficulties'] as $difficulty_id => $difficulty_notes)
			{
				if($this->getArrCount($difficulty_notes,1) > 1){
					if($counter == $key){
						$track->setNotesFromArray($difficulty_notes);
						$track->save();
					}
					$counter++;
				}
			}
		}

		return Redirect::route('create.editor', array('song' => $track->song->slug, 'track' => $track->id, 'lanes' => $track->lanes));
	}

	public function sendReviewMail($track)
	{
		Mail::send('emails.tracks.review', array('track' => $track, 'url' => route('game.play.test', array('track' => $track->id))), function($message) use ($track)
		{
		    $message->to('pne@rocklegend.org', 'Patrick Neschkudla')
		    		->subject('New track for review "'.$track->song->title.'"')
		    		->from('noreply@rocklegend.org');
		});
	}

	public function review($song, $track)
	{
		return View::make('tools.review')
					->with('song', Song::where('slug',$song)->first())
					->with('track', Track::where('id', $track)->first());
	}

	public function cloneTrack($track)
	{
		$track = Track::where('id',$track)->first();

		if($track->user_id == User::current()->id){

			$track = $track->replicate();
			$track->status = 0;
			$track->save();
			$track = Track::where('id', $track->id)->first();

			Session::flash(
				'success', 
				'You can edit your cloned track <a href="'.URL::route('create.editor', array('song' => $track->song->slug,
																 'lanes' => $track->lanes,
																 'track' => $track->id)).'">here</a>');
		}else{
			Session::flash(
				'error', 
				'You can\'t clone tracks from other users.');
		}
		
		return Redirect::route('tools');
	}

	public function deleteTrack($track, $force = false)
	{
		$track = Track::where('id',$track)->withTrashed()->first();

		if($track->user_id == User::current()->id){
			if($force){
				$track->forceDelete();
			}else{
				$track->delete();
			}

			Session::flash('success', 'Track deleted.');
			return Redirect::route('tools');
		}

		Session::flash('error', 'Permission denied.');
		return Redirect::route('tools');
	}

	public function reviveTrack($track)
	{
		$track = Track::where('id', $track)->withTrashed()->first();

		if($track->user_id == Sentry::getUser()->id){
			$track->restore();

			Session::flash('success','Track revived.');

			return Redirect::route('tools');
		}

		Session::flash('error', 'Permission denied.');
		return Redirect::route('tools');
	}

	public function getTrackById($track)
	{
		$track = Track::where('id',$track)->first()->getNotesAsArray();

		return Response::json($track);
	}

	/**
	 * Capture a canvas frame
	 *
	 * @author pne
	 * @return View
	 */

	public function captureFrame()
	{
			// split the data URL at the comma
	    $data = explode(',', Input::get('frame'));
	    // decode the base64 into binary data
	    $data = base64_decode(trim($data[1]));
	 
	    // create the numbered image file
	    $filename = Input::get('frame_id').'.png';
	    
	    if(!File::isDirectory(public_path().'/media/clips/'.Input::get('folderName'))){
	    	File::makeDirectory(public_path().'/media/clips/'.Input::get('folderName'), 0777, true);
	    }

	    File::put(public_path().'/media/clips/'.Input::get('folderName').'/'.$filename, $data);

	    return Response::json();
	}

}