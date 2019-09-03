<?php

class UserGithub extends Eloquent {

	protected $table = 'users_github';

	protected $fillable = [
		'login',
		'url',
		'type',
		'name',
		'company',
		'blog',
		'location',
		'email',
		'hireable',
		'bio',
		'public_repos',
		'followers',
		'following',
	];

}
