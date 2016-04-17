<?php

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
	Validator,
	MidiParser,
	Helper\RLString;

/**
 * @Resource("dashboard/track")
 */
class TrackController extends BaseController {

	/**
	 * Create new notes (only possible through song subroute)
	 *
	 * @param $id the notes id
	 */
	public function create( $song_id )
	{
		$song = Song::find($song_id);

		$view = View::make('dashboard.track.create')
					->with('song', $song);

		return $view;
	}

	/**
	 * Shows the notes
	 *
	 * @param $id the notes id
	 */
	public function show( $id )
	{
		$view = View::make('dashboard.track.show')
					->with('song', Song::find($id));

		return $view;
	}

	/**
	 * edit notes
	 */
	public function edit($id)
	{
		$notes = Note::where('id', $id)->with('song')->first();

		return View::make('dashboard.track.edit')
			->with('notes', $notes);
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
    	$track = Track::where('id',$id)->withTrashed()->first();

    	$song = $track->song;

    	$track->delete();

    	Session::flash('message', Lang::get('dashboard.track.delete.success'));
    	return Redirect::route('dashboard.song.notes', array('id' => $song->id));
   	}
}