<?php

namespace Dashboard;
use Controller,
	View,
	Artist,
	Session,
	Lang,
	Redirect,
	URL,
	Input;

/**
 * @Resource("dashboard/artist")
 */
class ArtistController extends BaseController {

	public function index()
	{
		$view = View::make('dashboard.artist.index')
					->with('artists', Artist::all());

		return $view;
	}

	public function show( $id )
	{
		$view = View::make('dashboard.artist.show')
					->with('artists', Artist::find($id));

		return $view;
	}

	/**
	 * edit song details
	 */
	public function edit($id)
	{
		$artist = Artist::find($id);

		$form = View::make('dashboard.artist.form')
			->with('artist', $artist);

		//return View::make('dashboard.song.wizard')
		return View::make('dashboard.artist.edit')
			->with('artist', $artist)
			->with('action', 'edit')
			->with('formUrl', URL::route('dashboard.artist.update', array('id' => $artist->id)))
			->with('form', $form);
	}

	/**
	 * update artist details
	 */
	public function update($id)
	{
		$artist = Artist::find($id);
		$artist->update(Input::all());
		//$artist->setUniqueSlug($artist, false)->save();	

		if(Input::hasFile('image')){
			$artist->addArtworkFileFromUpload(Input::file('image'));
		}
		if(Input::hasFile('headerImage')){
			$artist->addArtworkFileFromUpload(Input::file('headerImage'),'header');
		}

		return Redirect::route('dashboard.artist.edit', array('id' => $artist->id));
	}

	/**
     * deletes the given artist
     * 
     * @todo show correct error message
     * @author pne
     * @return boolean
     */
    public function destroy($id)
    {    	    	
    	$artist = Artist::find($id);
    	$artist->delete();

    	Session::flash('message', Lang::get('dashboard.artist.delete.success'));
    	return Redirect::route('dashboard.artist.index');
   	}
}