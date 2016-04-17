<?php

class BadgeController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Returns a list of all available badges
	 *
	 * @author pne
	 * @return View
	 **/
	public function showList()
	{
		return View::make('badges')
			->with('badges', Badge::all());
	}

	/**
	 * Returns the badge data as json
	 *
	 * @Post("badge/{badge}.json", as="badge.getjson")
	 *
	 * @author pne
	 * @return View
	 */
	public function getJson($badge)
	{
		$badge = Badge::where('id', $badge)->first();

		return Response::json($badge);
	}

}