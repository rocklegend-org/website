<?php
/**
 * app/controllers/Dashboard/SongController.php
 * @author pne
 * @author lcs
 */

namespace Dashboard;
use Controller,
	View,
	Song,
	Artist,
	Album,
	Label,
	Track,
	Input,
	Lang,
	URL,
	Redirect,
	Session,
	Config,
	Sentinel,
	Validator,
	MidiParser,
	Helper\RLString;

/**
 * This class handles the dashboard functionalities for song actions
 *
 */
class SongController extends BaseController {

	/**
	 * Prints a list of songs associated with the current user
	 *
	 * @todo update this function to show permissionbased song list
	 * example: an artist should only see his songs, but admins should be able to see and edit all songs
	 *
	 * @author pne
	 * @return View with all songs
	 */
	public function index()
	{
		$view = View::make('dashboard.song.index')
					->with('songs', Song::all());

		return $view;
	}

	/**
	 * Shows the detail page for one song
	 *
	 * @param $id the song id
	 */
	public function show( $id )
	{
		$view = View::make('dashboard.song.show')
					->with('song', Song::find($id));

		return $view;
	}

	/**
	 * basic data form for song creation (wizard step 1)
	 */
	public function create()
	{
		$form = View::make('dashboard.song.forms.song');

		//return View::make('dashboard.song.wizard')
		return View::make('dashboard.song.create')
			->with('action', 'create')
			->with('step', 1)
			->with('stepTitle', 'Song Information')
			->with('form', $form)
			->with('formUrl', URL::route('dashboard.song.store'));
	}

	/**
	 * edit song details
	 */
	public function edit($id)
	{
		$song = Song::find($id);

		$form = View::make('dashboard.song.forms.song')
			->with('song', $song);

		//return View::make('dashboard.song.wizard')
		return View::make('dashboard.song.edit')
			->with('song', $song)
			->with('action', 'edit')
			->with('step', 1)
			->with('stepTitle', 'Song Information')
			->with('formUrl', URL::route('dashboard.song.update', array('id' => $song->id)))
			->with('form', $form);
	}

	public function notes($id)
	{
		$song = Song::find($id);

		$form = View::make('dashboard.song.forms.notes')
			->with('song', $song)
			->with('tracks', $song->tracks);

		//return View::make( 'dashboard.song.wizard' )
		return View::make( 'dashboard.song.notes' )
			->with('song', $song)
			->with('action', 'edit')
			->with('step', 2)
			->with('stepTitle', 'Midi Information')
			->with('form', $form)
			->with('formUrl', URL::route('dashboard.song.notes', array('id' => $song->id)));
	}

	public function updateNotes($id)
	{
		$song = Song::find($id);

		foreach(Input::get('status') as $track_id => $status){
			$track = Track::where('id', $track_id)->withTrashed()->first();
			if(is_object($track)){
				$track->status = $status;
				$track->save();
			}
		}

		return Redirect::route('dashboard.song.notes', array('id' => $song->id));
	}

	/**
	 * This function handles the song creation process.
	 *
	 * There are different modes how a song can be generated.
	 *
	 * midi: The user uploads a pretapped midi file
	 * In this case, we have to analyze the midi file and create our note data from the midi file
	 *
	 * editor: The user just uploads a mp3 file.
	 * In this case, the user is going to use the rocklegend note editor to create the notes for the song
	 *
	 * @todo make sure that existing files don't get overwritten
	 * @todo implement note editor functionality
	 * @todo "use artist's existing logo/artwork" or none
	 *
	 * @author pne
	 * @author lcs
	 * @return returns appropriate redirect for the next stage of the song creation process
	 */
	public function store( $song = null )
	{
		$errorReturnRoute = Redirect::route('dashboard.song.create');
		if(!is_null($song))
		{
			$errorReturnRoute = Redirect::route('dashboard.song.edit', array('id' => $song->id));
		}

		// validate all fields through combined validator beforehand to deliver meaningful error messages about which models were affected
		$validator = $this->getCombinedValidator( is_null($song) );
		if($validator->fails())
		{
			return $errorReturnRoute->withErrors($validator)->withInput(Input::get());
		}

		// create new song instance
		$song = !is_null($song) ? $song : new Song;
		$song->title = Input::get('song_title');

		$song->status = Input::get('status'); // see config/game.php for meaning
		$song->trackable = Input::has('trackable') ? true : false;

		// add artist
		$artist = Artist::firstOrCreate(array(
			'name' => Input::get('artist_name')
		));
		if($artist->hasErrors())
		{
			return $errorReturnRoute->withErrors($artist->getErrors());
		}
		$song->artist_id = $artist->id;

		// add album
		if(Input::get('album_title'))
		{
			$album = Album::firstOrCreate(array(
				'title' => Input::get('album_title'),
				'artist_id' => $artist->id)
			);
			if($album->hasErrors())
			{
				return $errorReturnRoute->withErrors($album->getErrors());
			}
			$song->album_id = $album->id;
		}

		// add label
		if(Input::get('label_name'))
		{
			$label = Album::firstOrCreate(array(
				'name' => Input::get('label_name')
			));
			if($album->hasErrors())
			{
				return $errorReturnRoute->withErrors($album->getErrors());
			}
			$song->label_id = $label->id;
		}

		// and save
		$song->save();

		// add mp3
		$song->addMusicFileFromUpload(Input::file('song_mp3'));

		// add midi
		if(Input::hasFile('song_midi'))
		{
			$midiFile = $song->addMidiFileFromUpload(Input::file('song_midi'));

			// load midifile and get xml data
			$midiParser = new MidiParser;
			$notes = $midiParser->midiToNotesArray($midiFile->getRealPath(), Config::get('game.difficulties'));

			if(!empty($notes) && isset($notes['difficulties']))
			{
				foreach($notes['difficulties'] as $difficulty_id => $difficulty_notes)
				{
					if(count($difficulty_notes,1)-5 > 1){
						$track = new Track;
						$track->status = 1;
						$track->song_id = $song->id;
						$track->difficulty = $difficulty_id;
						$track->lanes = 5;
						$track->setNotesFromArray($difficulty_notes);
						$track->user_id = Sentinel::getUser()->id;
						$track->save();
					}
				}
			}
		}

		if(Input::hasFile('song_artwork')){
			$song->addArtworkFileFromUpload(Input::file('song_artwork'));
		}

		return Redirect::route('dashboard.song.edit', array('id' => $song->id));
	}

	/**
	 * update song details
	 */
	public function update($id)
	{
		$song = Song::find($id);

		return $this->store($song);
	}

	/**
	 * @author lcs
	 */
	private function getCombinedValidator( $requireSongFile = false )
	{
		$inputs = Input::get();

		$rules = array(
        	'song_title' => 'required',
        	'artist_name' => 'required',
        );

		// add mp3 sound file to validator
	    $inputs['song_mp3'] = Input::file('song_mp3');
   		//TODO: http://stackoverflow.com/questions/21564029/file-upload-mime-type-validation-with-laravel-4
	    //$rules['song_mp3'] = 'required|mimes:mp3';
	    if($requireSongFile)
	    {
	    	$rules['song_mp3'] = 'required';
	    }

	    // TODO add midi sound file to validator (mime)

        return Validator::make( $inputs, $rules );
	}

    /**
     * deletes the given entity
     *
     * @todo show correct error message
     * @author pne
     * @return boolean
     */
    public function destroy($id)
    {
    	$song = Song::find($id);
    	$song->delete();

    	Session::flash('message', Lang::get('dashboard.song.delete.success'));
    	return Redirect::route('dashboard.song.index');
   	}

}