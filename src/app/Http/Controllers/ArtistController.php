<?php

class ArtistController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Shows the artists detail page
	 *
	 * @author pne
	 * @return View
	 *
	 * @Get("artist/{artist}", as="artist.show")
	 */
	public function show($artist)
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