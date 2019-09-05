<?php

namespace Dashboard;
use Controller,
	View,
	Album,
	Session,
	Lang,
	Input,
	URL, 
	Redirect;

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

	public function edit($id)
	{
		$album = Album::find($id);

		$form = View::make('dashboard.album.form')
			->with('album', $album);

		return View::make('dashboard.album.edit')
			->with('album', $album)
			->with('action', 'edit')
			->with('formUrl', URL::route('dashboard.album.update', array('id' => $album->id)))
			->with('form', $form);
	}

	public function update($id)
	{
		$album = Album::find($id);
		$album->update(Input::all());

		return Redirect::route('dashboard.album.edit', array('id' => $album->id));
	}

  public function destroy($id)
	{    	    	
		$album = Album::find($id);
			
		if (is_null($album)) {
			Session::flash('error', Lang::get('dashboard.album.delete.error'));
			return Redirect::route('dashboard.album.index');
		}
		
		$album->delete();

		Session::flash('message', Lang::get('dashboard.album.delete.success'));
		return Redirect::route('dashboard.album.index');
	}
}