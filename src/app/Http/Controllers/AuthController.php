<?php

use Rocklegend\Http\Requests\LoginFormRequest;

class AuthController extends BaseController {
	public function login()
	{
		if(!is_null(Sentinel::getUser())){
			return Redirect::to('/');
		}

		return View::make('auth/register');
	}

	public function logout()
	{
		Sentinel::logout();

		return Redirect::to('');
	}

	public function postLogin(LoginFormRequest $request)
	{
		$credentials = array(
		  'login' => Input::get('username') ?: Input::get('username_login'),
      	  'password' => Input::get('password') ?: Input::get('password_login'),
		);

		try {
	    if (Sentinel::authenticate($credentials, true)) {
	    	$user = Sentinel::getUser();

				// cache user settings for later access
				User::current()->settingsMap();

	    	Session::flash('success', Lang::get('auth.logged_in'));

	    	return Redirect::intended('/');
	    } else {
				throw new Exception('Error during authenticate.');
			}
		}
		catch (Cartalyst\Sentinel\Checkpoints\ThrottlingException $e) {

		    $m = 'user_suspended';
		}
		catch (Exception $e) {
		    $m = 'wrong_password';
		}

		return Redirect::route('login')
						->withErrors(array($m => Lang::get('auth.' . $m)))
						->withInput();
	}

	public function passwordForgotten()
	{
		return view('auth.password_forgotten');
	}

	public function passwordForgottenProcess()
	{
		if(!Input::get('email')){
			return Redirect::route('password.forgotten')
				->withErrors(array('user_not_found' => Lang::get('auth.user_not_found')));
		}

		$user = User::where('email', Input::get('email'))->first();

		if(is_null($user)){
			return Redirect::route('password.forgotten')
						->withErrors(array('user_not_found' => Lang::get('auth.user_not_found')));
		}else{
			($reminder = Reminder::exists($user)) || ($reminder = Reminder::create($user));

			Mail::send(
				'emails.auth.password_reset',
				array('user' => $user, 'resetCode' => $reminder->code, 'url' => route('password.reset', array('code' => $reminder->code, 'id' => $user->id))),
				function($message) use ($user)
			{
			    $message->to($user->email, $user->email)
			    		->subject('Your rocklegend password.')
			    		->from('office@rocklegend.org');
			});

			return View::make('auth.password_forgotten')
					->with('success', 'sent_mail');
		}
	}

	public function passwordReset($code, $id)
	{
		$user = Sentinel::findById($id);

		if (is_null($user)) {
			return Redirect::route('password.forgotten')
						->withErrors(array('user_not_found' => Lang::get('auth.user_not_found')));
		}

		$reminder = Reminder::exists($user);

		if(!is_null($user) && $reminder->code === $code){
			return View::make('auth.password_reset')
						->with('id', $user->id)
						->with('code', $code);
		} else {
			return Redirect::route('password.forgotten')
						->withErrors(array('invalid_reset_code' => Lang::get('auth.invalid_reset_code')));
		}
	}

	public function passwordResetProcess()
	{
		$user = Sentinel::findById(Input::get('id'));

		if (is_null($user)) {
			return Redirect::route('password.forgotten')
				->withErrors(array('user_not_found' => Lang::get('auth.user_not_found')));
		}

		$validator = Validator::make(Input::all(), [
			'password_confirm' => 'same:password'
		]);

		if ($validator->fails()) {
			return Redirect::route('password.reset', ["id" => $user->id, "code" => Input::get('code')])
						->withInput()
						->withErrors($validator);
		}
		
		if(Reminder::complete($user, Input::get('code'), Input::get('password'))){
			return View::make('auth.password_reset_success');
		}else{
			return Redirect::route('password.forgotten')
					->withErrors(array('reset_wrong' => 'Something went wrong when trying to reset your password.'));
		}
	}

	public function register()
	{		
		$errors = new Illuminate\Support\MessageBag();

		if(Request::method() === 'POST'){
			try{
				// check if user provided a code and if the code is valid
				if(Input::get('code') && !SignupCode::valid(Input::get('code'))){
					$m = 'invalid_code';
				}else{
					if(User::where('email',Input::get('email'))->count() >=1)
					{
						$m = 'email_exists';
					}
					else
					{
						$user = Sentinel::create(array(
							'username' => Input::get('username'),
							'password' => Input::get('password'),
							'email'	=> Input::get('email')
						));

						if(Input::get('code')){
							SignupCode::useCodeForUserId($user->id, Input::get('code'));
						}

						$role = Sentinel::findRoleByName('Player');
						$role->users()->attach($user);

						if($this->loginUserById($user->id) === TRUE){
							return Redirect::to('');
						}
					}
				}
			}
			catch (Illuminate\Database\QueryException $e){
				$errorCode = $e->errorInfo[1];

				if($errorCode == 1062){
					$m = 'user_exists';
				} else {
					$m = 'error';
				}
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

	private function loginUserByID($user_id)
	{
		$user = Sentinel::findUserById($user_id);

		if ($user) {
			$response = Sentinel::login($user, false);
			return true;
		} else {
			return false;
		}
	}

}
