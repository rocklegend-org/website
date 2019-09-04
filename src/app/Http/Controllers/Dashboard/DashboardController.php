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
		$this->middleware('auth', array('except' => array('login', 'processLogin')));
		$this->middleware('perm');

		$this->middleware('csrf', array('on' => 'post'));
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
		$scoresByUsers = Score::groupBy('user_id')->get();
		$comments = TrackComment::all();

		return View::make('dashboard.index')
			->with('songs',$songs)
			->with('artists',$artists)
			->with('albums',$album)
			->with('scoreCount', $scoreCount)
			->with('users',$users)
			->with('scoresByUsers', $scoresByUsers)
			->with('comments', $comments)
			->with('latestComments', TrackComment::orderBy('created_at', 'desc')->take(15)->get())
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