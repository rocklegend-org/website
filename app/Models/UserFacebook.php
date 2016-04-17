<?php

class UserFacebook extends Eloquent {

	protected $table = 'users_facebook';

	protected $fillable = [
		'name',
		'first_name',
		'last_name',
		'link',
		'username',
		'gender',
		'email',
		'timezone',
		'locale',
		'verified',
	];

}
