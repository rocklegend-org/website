<?php

use Rocklegend\Http\Requests\LoginFormRequest;

class AuthController extends BaseController {

	/**
	 * Show Register page
	 *
	 * @Get("login", as="login")
	 */
	public function login()
	{
		if(!is_null(Sentry::getUser())){
			return Redirect::to('/');
		}

		Session::set('provider', 'form');

		return View::make('auth/register')
			->with('provider', 'form');
	}

	/**
	 * Logout currently logged in user
	 *
	 * @Get("logout", as="logout")
	 */
	public function logout()
	{
		Sentry::logout();

		return Redirect::to('');
	}

	/**
	 * Process login data
	 *
	 * @Post("login", as="login.process")
	 *
	 */
	public function postLogin(LoginFormRequest $request)
	{
		$credentials = array(
		  'username' => Input::get('username'),
      'password' => Input::get('password'),
		);

		try {
	    if (Sentry::authenticate($credentials, false)) {
	    	$user = Sentry::getUser();

	    	Session::flash('success', Lang::get('auth.logged_in'));

	    	return Redirect::intended('/');
	    }
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
		    //$m = $this->handleThrottle(Input::get('username')) ?: 'wrong_password';
		    $m = "wrong_password";
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {

		    $m = 'user_not_found';
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {

		    $m = 'user_not_activated';
		}
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {

		    $m = 'user_suspended';
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {

		    $m = 'user_banned';
		}

    	return Redirect::route('login')
    					->withErrors(array($m => Lang::get('auth.' . $m)))
    					->withInput();
	}

	/**
	 * Show "Forgot Password" screen
	 *
	 * @Get("forgot-password", as="password.forgotten")
	 */
	public function passwordForgotten()
	{
		return view('auth.password_forgotten');
	}

	/**
	 * Process "Forgot Password"
	 *
	 * @Post("forgot-password", as="password.forgotten")
	 */
	public function passwordForgottenProcess()
	{
		if(!Input::has('email')){
			return Redirect::route('password.forgotten')
				->withErrors(array('user_not_found' => Lang::get('auth.user_not_found')));
		}

		$user = User::where('email', Input::get('email'))->first();

		if(is_null($user)){
			return Redirect::route('password.forgotten')
						->withErrors(array('user_not_found' => Lang::get('auth.user_not_found')));
		}else{
			$resetCode = Sentry::findUserById($user->id)->getResetPasswordCode();

			Session::flash('user-email', $user->email);
			Mail::send('emails.auth.password_reset', array('user' => $user, 'resetCode' => $resetCode, 'url' => route('password.reset', array('code' => $resetCode))), function($message)
			{
			    $message->to(Session::get('user-email'), Session::get('user-email'))
			    		->subject('Your rocklegend password.')
			    		->from('office@rocklegend.org');
			});

			return View::make('auth.password_forgotten')
					->with('success', 'sent_mail');
		}
	}

	/**
	 * Process "Forgot Password"
	 *
	 * @Get("reset-password/{code}", as="password.reset")
	 */
	public function passwordReset($code)
	{
		try{
			$user = Sentry::findUserByResetPasswordCode($code);
		}catch(Exception $e){
			var_dump($code);
			die('notfound');
			return Redirect::route('password.forgotten')
						->withErrors(array('user_not_found' => Lang::get('auth.user_not_found')));
		}

		if(!is_null($user)){
			return View::make('auth.password_reset')
						->with('username', $user->username)
						->with('code', $code);
		}else{
			return Redirect::route('password.forgotten')
						->withErrors(array('user_not_found' => Lang::get('auth.user_not_found')));
		}
	}

	/**
	 * Process "Forgot Password"
	 *
	 * @Post("reset-password/process", as="password.reset.process")
	 */
	public function passwordResetProcess()
	{
		try{
			$user = Sentry::findUserByResetPasswordCode(Input::get('code'));
		}catch(Exception $e){
			return Redirect::route('password.forgotten')
						->withErrors(array('user_not_found' => Lang::get('auth.user_not_found')));
		}

		if(!is_null($user)){
			if($user->attemptResetPassword(Input::get('code'), Input::get('password'))){
				return View::make('auth.password_reset_success')
							->with('username', $user->username);
			}else{
				return Redirect::route('password.forgotten')
						->withErrors(array('reset_wrong' => 'Something went wrong when trying to reset your password.'));
			}
		}else{
			return Redirect::route('password.forgotten')
						->withErrors(array('user_not_found' => Lang::get('auth.user_not_found')));
		}
	}

	/**
	 * Redirect to facebook login
	 *
	 * @Get("login/facebook", as="login.facebook")
	 */
	public function facebook()
	{
		return Socialite::driver('facebook')->redirect();
	}


	/**
	 * Login with facebook
	 *
	 * @Get("login/facebook/process", as="login.facebook.process")
	 */
	public function handleFacebookCallback()
	{
		$user = Socialite::driver('facebook')->user();

		$token = $user->token;

		$user_facebook = UserFacebook::where('facebook_id', $user->id)->first();

		if(is_null($user_facebook))
		{
			// if the user is currently logged in, connect this facebook account with his rocklegend account
			if(!is_null(Sentry::getUser())){
				$user = User::where('id', Sentry::getUser()->id)->first();

				$provider_user = new UserFacebook;

				$provider_user->facebook_id = $user->getId();
				$provider_user->email = $user->getEmail();
				$provider_user->name = $user->getName();
				$provider_user->first_name = $user->first_name;
				$provider_user->last_name = $user->last_name;
				$provider_user->link = $user->link;
				$provider_user->gender = isset($user->gender) ? $user->gender : 'n/a';
				$provider_user->locale = isset($user->locale) ? $user->locale : 'n/a';
				$provider_user->timezone = isset($user->timezone) ? $user->timezone : 'n/a';
				$provider_user->verified = isset($user->verified) ? $user->verified : 'n/a';

				$provider_user->user_id = $user->id;
				$provider_user->save();

				$user->provider = 'facebook';
				$user->save();

				return Redirect::to('profile/settings');
			}

			// user logs in first time -> let him register his account
			Session::put('provider', 'facebook');
			Session::put('facebook_user', $user);

			return Redirect::to('register');
	    }
	    else
	    {
	    	// log in existing user
			$this->loginUserById($user_facebook->user_id);
	    }

		return Redirect::intended('/');
	}

	/**
	 * Show / Handle Registration via Facebook & Form
	 *
	 * @Any("register", as="register")
	 */
	public function register()
	{
		$provider = Session::get('provider');

		if(Input::get('provider') == 'form'){

			try{
				// check if user provided a code and if the code is valid
				if(Input::has('code') && !SignupCode::valid(Input::get('code'))){
					$m = 'invalid_code';
				}else{
					if(User::where('email',Input::get('email'))->count() >=1)
					{
						$m = 'email_exists';
					}
					else
					{
					    $user = Sentry::createUser(array(
							'username' => Input::get('username'),
							'password' => Input::get('password'),
							'email'	=> Input::get('email'),
							'activated' => 1
						));

					    if(Input::has('code')){
					    	SignupCode::useCodeForUserId($user->id, Input::get('code'));
					    }

						$user->addGroup(Sentry::findGroupByName('Player'));

						if($this->loginUserById($user->id) === TRUE){
							return Redirect::to('');
						}
					}
				}
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
			    $m = 'user_exists';
			}
			catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
			{
				$m = 'internal_error_301';
			}
			catch(Exception $e){
				$m = $e->getMessage();
			}
		}

		if(is_null($provider))
		{
			return Redirect::to('login');
		}

		if($provider == 'facebook')
		{
			$user = (array) Session::get('facebook_user');

			$provider_user = new UserFacebook;
			$provider_id = $user['id'];
			$provider_user->facebook_id = $user['id'];
			$provider_user->email = isset($user['email']) ? $user['email'] : (isset($user['user']['email']) ? $user['user']['email'] : '');
			$provider_user->name = $user['name'];
			$provider_user->first_name = $user['user']['first_name'];
			$provider_user->last_name = $user['user']['last_name'];
			$provider_user->link = $user['user']['link'];
			$provider_user->gender = $user['user']['gender'];
			$provider_user->locale = $user['user']['locale'];
			$provider_user->timezone = $user['user']['timezone'];
			$provider_user->verified = $user['user']['verified'];

			$has_user = $provider_user->email != '' ? User::where('email', $provider_user->email)->first() : false;

			if($has_user){
				$provider_user->user_id = $has_user->id;
				$provider_user->save();

				$has_user->provider = 'facebook';
				$has_user->save();

				if($this->loginUserById($has_user->id) === TRUE){
					return Redirect::intended('/');
				}
			}
		}

		if (Input::has('username'))
		{
			$user = (array) Session::get('facebook_user');

			$provider_user->fill($user);

			try
			{
				// check if user provided a code and if the code is valid
				if(Input::has('code') && !SignupCode::valid(Input::get('code'))){
					$m = 'invalid_code';
				}else{
					if(User::where('email', $provider_user->email)->count() >=1)
					{
						$m = 'user_exists';
					}
					else
					{
						// Create the user
						$user = Sentry::createUser(array(
							'password' => 'legendrock5_'.$provider_id.'_'.time(),
							'username' => Input::get('username'),
							'email' => $provider_user->email,
							'provider' => $provider,
							'activated' => 1,
						));

					    if(Input::has('code')){
					    	SignupCode::useCodeForUserId($user->id, Input::get('code'));
					    }

						// Find the group using the group id
						$memberGroup = Sentry::findGroupByName('Player');

						// Assign the group to the user
						$user->addGroup($memberGroup);

						$provider_user->user_id = $user->id;
				    	$provider_user->save();

				    	if($this->loginUserById($user->id) === TRUE)
				    	{
				    		return Redirect::intended('/');
				    	}
				    }
				}
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
			    $m = 'user_exists';
			}
			catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
			{
				$m = 'internal_error_301';
			}
			catch(Exception $e){
				$m = $e->getMessage();
			}

			return Redirect::route('register')
							->withErrors(array($m => Lang::get('auth.' . $m)))
							->withInput();
		}

		return View::make('auth/register')
			->with('provider', $provider)
			->with('name', $provider != 'form' ? $provider_user->first_name : '');
	}

	/* HELPER */

	private function loginUserByID($user_id)
	{
		try
		{
			$user = Sentry::findUserById($user_id);

			// Log the user in
			$response = Sentry::login($user, false);

			return true;
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			return 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			return 'User not activated.';
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return 'User not found.';
		}
		catch(Exception $e)
		{
			var_dump($e->getMessage());
		}
	}

}
