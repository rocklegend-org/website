<?php

class ArtistController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}
	
	function show($artist)
	{
		$artist = Artist::where('slug', $artist)->first();

		if(is_object($artist))
		{
			return View::make('artist.show')
					->with('artist', $artist);
		}
		
		App::abort(404);
	}

}