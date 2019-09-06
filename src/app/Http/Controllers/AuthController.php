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

		return View::make('auth/register');
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

				// cache user settings for later access
				User::current()->settingsMap();

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
	 * Show / Handle Registration via Form
	 *
	 * @Any("register", as="register")
	 */
	public function register()
	{		
		$errors = new Illuminate\Support\MessageBag();

		if(Request::method() === 'POST'){
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

			if (isset($m)) {
				$errors->add($m, Lang::get('auth.' . $m));
			}
		}

		return View::make('auth/register')
			->withErrors($errors);
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
