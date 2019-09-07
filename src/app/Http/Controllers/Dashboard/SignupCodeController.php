<?php

namespace Dashboard;
use Controller,
	View,
	Request,
	User,
	Input,
	Hash,
	Lang,
	Redirect,
	DB,
	Route,
	SignupCode,
	Mail;
use Illuminate\Database\QueryException;

class SignupCodeController extends BaseController {
	public function index()
	{
		$view = View::make('dashboard.signupcodes.index')
					->with('codes', SignupCode::all());

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
		return View::make('dashboard.signupcodes.create');
	}

	public function store()
	{
		$code = new SignupCode;
		$code->code = Input::get('code');
		$code->used = false;
		$code->amount = Input::get('amount');
		$code->active_from = Input::get('active_from');
		$code->active_to   = Input::get('active_to');
		$code->save();

		return Redirect::route('dashboard.signupcodes');
	}

	public function edit( $id )
	{

	}

	public function update( $id )
	{
		
	}

	public function destroy($id)
	{
		SignupCode::find($id)->delete();

		return Redirect::route('dashboard.signupcodes');
	}


}