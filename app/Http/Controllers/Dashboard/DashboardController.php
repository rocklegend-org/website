<?php

namespace Dashboard;
use View,
	Song,
	Artist,
	Album,
	Score,
	User,
	Invite,
	Track,
	TrackComment;

class DashboardController extends BaseController {

	public function __construct()
    {
		$this->beforeFilter('auth', array('except' => array('login', 'processLogin')));

        // Check if the user has the permissions
		$this->beforeFilter('perm');

        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function login()
	{
		return View::make('dashboard.login', array('bodyClass' => 'sign-in-bg'));
	}

	/**
	 * @Get("dashboard", as="dashboard")
	 *
	 */
	public function index()
	{
		$songs = Song::all();
		$artists=Artist::all();
		$album = Album::all();
		$scores = Score::all();
		$users = User::all();
		$tracks = Track::all();
		$scoresByUsers = Score::groupBy('user_id')->get();
		$comments = TrackComment::all();

		return View::make('dashboard.index')
			->with('songs',$songs)
			->with('artists',$artists)
			->with('albums',$album)
			->with('scores', $scores)
			->with('users',$users)
			->with('scoresByUsers', $scoresByUsers)
			->with('comments', $comments)
			->with('latestComments', TrackComment::orderBy('created_at', 'desc')->take(15)->get())
			->with('tracks',$tracks);
	}

	/**
	 * Flushes the cache
	 *
	 * @Get("dashboard/flush-cache", as="flush-cashe")
	 *
	 */
	public function flushCashe()
	{
		\Cache::flush();

		return \Redirect::to('/dashboard');
	}

}