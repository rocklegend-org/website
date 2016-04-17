<?php

class DiscoverController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @Get("discover", as="discover")
	 */
	public function index($artist = false, $song = false)
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

	/**
	 * @Get("discover/songlist", as="discover.songlist")
	 */
	public function songlist()
	{
		return View::make('discover.songlist');
	}
}