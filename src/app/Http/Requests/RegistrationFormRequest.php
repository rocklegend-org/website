<?php

namespace Rocklegend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class RegistrationFormRequest extends FormRequest
{
	public function rules()
	{
		$result = (array) Session::get('result');
	
		return [
			'email'		=> 'required',
			'username' => 'required',
			'password' => 'required',
			'password_confirm' => 'same:password',
			'password' 	=> 'min:5'
		];

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