<?php

namespace Rocklegend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class LoginFormRequest extends FormRequest
{
	public function rules()
	{
		return [
			'username' => 'required',
			'password' => 'required'
		];
	}

	public function authorize()
	{
		// Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
	}
}