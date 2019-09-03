<?php

namespace Rocklegend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class RegistrationFormRequest extends FormRequest
{
	public function rules()
	{
		$provider = Session::get('provider');
		$result = (array) Session::get('result');
		
		if(Input::get('provider') == 'form')
		{
			return [
				'email'		=> 'required',
				'username' => 'required',
				'password' => 'required',
				'password_confirm' => 'same:password',
				'password' 	=> 'min:5'
			];
		}

		if(is_null($provider) || is_null($result))
		{
			return Redirect::to('login');
		}

		if($provider == 'facebook')
		{
			return [];
		}

		return [];
	}

	public function authorize()
	{
		// Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
	}
}