<?php

class UserGoogle extends Eloquent {

	protected $table = 'users_google';

	protected $fillable = [
		'email',
		'verified_email',
	];

}
