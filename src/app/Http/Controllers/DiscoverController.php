<?php

class DiscoverController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{		
		$artists = Artist::with('songs')
					->orderBy('created_at')
					->get();

		$artists = $artists->sortBy(function($artist){
			return -$artist->playCount();
		});

		$view = View::make('discover.index')
					->with('artists', $artists);

		return $view;
	}

	public function songlist()
	{
		return View::make('discover.songlist');
	}
}