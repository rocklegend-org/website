<?php

namespace Dashboard;
use Controller,
	View,
	Request,
	User,
	Input,
	Hash,
	Lang,
	Sentry,
	Redirect,
	\Badge;
use Illuminate\Database\QueryException;

class UserController extends BaseController {

	public function index()
	{
		$view = View::make('dashboard.user.index')
					->with('users', User::all());

		return $view;
	}

	public function show( $id )
	{
		$view = View::make('dashboard.user.show')
					->with('user', User::find($id));

		return $view;
	}

	public function create()
	{
		return View::make('dashboard.user.create');
	}

	public function store()
	{
		$user = new User;
		$user->username = Input::get('username');
		$user->password = Hash::make(Input::get('password'));
		$user->email = Input::get('email');
		$user->save();

		if(Request::ajax())
		{
			return Response::json(array('user' => $user));
		}

		return Redirect::to('dashboard.user.index');
	}

	public function edit( $id )
	{
		$view = View::make('dashboard.user.edit')
					->with('user', User::find($id));

		return $view;
	}

	public function update( $id )
	{
		try {

			$user = User::find($id);
			$user->username = Input::get('username');
			if(!is_null(Input::get('password', null)) && !Input::get('password') == '')
			{
				$user->password = Hash::make(Input::get('password'));
			}
			
			$user->official_tracker = Input::has('official_tracker') ? 1 : 0;
			
			if(Input::has('donator_badge') && Input::get('donator_badge') == 1){
				Badge::award('donator', $user->id);
			}else{
				Badge::withdraw('donator', $user->id);
			}

			$throttle = Sentry::findThrottlerByUserId($user->id);

			if(Input::has('suspended')){
				$throttle->suspend();
			}else{
				$throttle->unsuspend();
			}

			if(Input::has('banned')){
				$throttle->ban();
			}else{
				$throttle->unban();
			}

			$user->email = Input::get('email');
			$user->save();
		}
		catch( QueryException $e )
		{
			return Redirect::route('dashboard.user.edit', $user->id )->withErrors(array(Lang::get('dashboard.user.update.error')));
		}

		if(Request::ajax())
		{
			return Response::json(array('user' => $user));
		}

		return Redirect::route('dashboard.user.edit', $user->id )->with('success', Lang::get('dashboard.user.updated'));
	}

	public function destroy()
	{
	}


}