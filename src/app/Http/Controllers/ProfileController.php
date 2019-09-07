<?php

class ProfileController extends BaseController {

	public function __construct()
	{		
		parent::__construct();
		
		if(strpos(Route::currentRouteAction(), 'show') <= -1)
		{
			$this->middleware('auth', array('except' => array('login', 'login')));
		}
	}

	public function show($username = false)
	{
		if(!$username && User::current()->id){
			$user = User::current();
		}else if($username){
			$user = User::where('username',$username)->first();
		}

		if(!is_null($user)){
			return View::make('profile.show')
						->with('user', $user);
		}

		return Redirect::to('/');
	}

	public function badges($username = false){
		if(!$username && User::current()->id)
		{
			$user = User::current();
		}else if($username){
			$user = User::where('username', $username)->with('badges')->first();
		}

		if(!is_null($user)){
			return View::make('profile.badges')
						->with('user', $user);
		}

		return Redirect::to('/');
	}

	public function getBox($username){
		$user = User::where('username',$username)->first();

		if(!is_null($user)){
			return View::make('profile.box')
						->with('user', $user);
		}

		return Redirect::to('/');
	}

	public function edit()
	{
		if(Request::isMethod('get'))
		{
			// show edit screen 
			return View::make('profile.edit')
				->with('user', User::find(User::current()->id));
		}else{
			// save data
			$user = User::current();

			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->bio = Input::get('bio');
			$user->country = Input::get('country');
			$user->city = Input::get('city');
			$user->instruments_played = Input::get('instruments_played');
			$user->favorite_bands = Input::get('favorite_bands');

			$user->save();

			return Redirect::route('profile', array('username' => $user->username));
		}
	}

	public function settings(Illuminate\Http\Request $request)
	{
		if(Request::isMethod('get')){
			return View::make('profile.settings')
						->with('user', User::current());
		}else{
			$validator = Validator::make($request->all(), [
				'password_confirm' => 'required_with:password,|same:password'
			]);

			if(!$validator->fails()){
				$user = User::where('id', Sentinel::getUser()->id)->first();

				if(!is_null(Input::file('profile_image'))){
					if(in_array(Input::file('profile_image')->getClientOriginalExtension(),
							array('jpg', 'jpeg', 'png', 'gif'))){
						$user->addAvatarFromUpload(Input::file('profile_image'));
					}else{
						Session::flash('error', 'image-upload');
						return Redirect::route('profile.settings');
					}
				}

				if(!is_null(Input::get('password')) && Input::get('password') != ''){
					$sentinelUser = Sentinel::getUser();
					$sentinelUser->password = Input::get('password');
					$sentinelUser->save();
				}

				for($i = 1; $i <= 5; $i++){
					$user->setting('key_lane'.$i, Input::get('key_lane'.$i));
				}

				for($i = 1; $i <= 5; $i++){
					$user->setting('key_alt_lane'.$i, Input::get('key_alt_lane'.$i));
				}

				$user->setting('play_mode', Input::get('play_mode'));
				$user->setting('quick_restart', Input::get('quick_restart'));

				$user->save();

				Session::flash('success', Lang::get('strings.profile.settings.saved'));

				return Redirect::route('profile.settings');
			}else{
				return Redirect::route('profile.settings')
								->withErrors($validator)
								->withInput();
			}
		}
	}

	public function settingsEditor()
	{
		if(Request::isMethod('get')){
			return View::make('profile.settings')
						->with('user', User::where('id',Sentinel::getUser()->id)->first());
		}else{
			$validator = Validator::make(
				array(
					'autosave_interval' => Input::get('autosave_interval')
				), 
				array(
					'autosave_interval' => 'required'
				));

			if(!$validator->fails()){
				$user = User::where('id', Sentinel::getUser()->id)->first();

				$user->setting('autosave_interval', Input::get('autosave_interval'));

				$user->setting('autosave', Input::has('autosave') ? 1 : 0);

				$user->save();

				Session::flash('success', Lang::get('strings.profile.settings.saved'));

				return Redirect::route('profile.settings');
			}else{
				return Redirect::route('profile.settings')
								->withErrors($validator);
			}
		}
	}

	public function settingsDiscover()
	{
		if(Request::isMethod('get')){
			return View::make('profile.settings')
						->with('user', User::where('id',Sentinel::getUser()->id)->first());
		}else{
			$user = User::current();

			$user->setting('show_trackable_songs', Input::has('show_trackable_songs') ? 1 : 0);
			$user->setting('show_requested_songs', Input::has('show_requested_songs') ? 1 : 0);

			$user->save();

			Session::flash('success', Lang::get('strings.profile.settings.saved'));

			return Redirect::route('profile.settings');
		}
	}

	public function savePlayerSettings()
	{
		$user = User::current();

		$user->setting('player_max_notes', Input::get('player_max_notes'));
		$user->setting('player_burst_count', Input::get('player_burst_count'));
		$user->setting('player_enable_cheering', Input::has('player_enable_cheering') ? 1 : 0);
		$user->setting('player_cheering_volume', Input::get('player_cheering_volume'));
		$user->setting('player_display_mode', Input::get('player_display_mode'));

		$user->save();

		return Response::json(array('save' => 1));
	}

	/** FOLLOW **/
	public function follow()
	{
		$follow = new Follower;
		$follow->stalker_user_id = User::current()->id;
		$follow->followed_user_id = Input::get('user_id');
		$follow->save();

		return Response::json($follow);
	}

	public function unfollow()
	{
		$follow = Follower::where('stalker_user_id', User::current()->id)->where('followed_user_id', Input::get('user_id'))->delete();
		return Response::json($follow);
	}

	/** NOTIFICATIONS **/
	public function getNotificationHtml()
	{
		return View::make('partials.header.notifications');
	}

	public function dismissNotification()
	{
		$notification = Notification::find(Input::get('id'));
		$notifications = Notification::where('group_id', $notification->group_id)->where('recipient_id', User::current()->id)->get();
		
		foreach($notifications as $notif){
			$notif->active = 0;
			$notif->save();
		}
	}
}