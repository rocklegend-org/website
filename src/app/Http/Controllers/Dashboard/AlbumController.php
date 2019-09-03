<?php

namespace Dashboard;
use Controller,
	View,
	Album,
	Session,
	Lang,
	Redirect;

/**
 * @Resource("dashboard/album")
 */
class AlbumController extends BaseController {

	public function index()
	{
		$view = View::make('dashboard.album.index')
					->with('albums', Album::all());

		return $view;
	}

	public function show( $id )
	{
		$view = View::make('dashboard.album.show')
					->with('albums', Album::find($id));

		return $view;
	}

    /**
     * deletes the given album
     * 
     * @todo show correct error message
     * @author pne
     * @return boolean
     */
    public function destroy($id)
    {    	    	
    	$album = Album::find($id);
    	$album->delete();

    	Session::flash('message', Lang::get('dashboard.album.delete.success'));
    	return Redirect::route('dashboard.album.index');
   	}
}