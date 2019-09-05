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
	TrackComment,
	DB;

class DashboardController extends BaseController {

	public function __construct()
	{
		$this->middleware('auth', array('except' => array('login', 'processLogin')));
		$this->middleware('perm');
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
		$scoreCount = Score::count();
		$users = User::all();
		$tracks = Track::all();
		$scoresByUsers = Score::count(DB::raw('DISTINCT user_id'));
		$comments = TrackComment::count();
		$latestComments = TrackComment::orderBy('created_at', 'desc')->with('user', 'track', 'track.song', 'track.song.artist')->take(15)->get();

		return View::make('dashboard.index')
			->with('songs',$songs)
			->with('artists',$artists)
			->with('albums',$album)
			->with('scoreCount', $scoreCount)
			->with('users',$users)
			->with('scoresByUsers', $scoresByUsers)
			->with('comments', $comments)
			->with('latestComments', $latestComments)
			->with('tracks',$tracks);
	}

	/**
	 * Flushes the cache
	 *
	 * @Get("dashboard/flush-cache", as="flush.cache")
	 *
	 */
	public function flushCache()
	{
		\Cache::flush();

		return \Redirect::to('/dashboard');
	}

}