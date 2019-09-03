<?php

class UserTwitter extends Eloquent {

	protected $table = 'users_twitter';

	protected $fillable = [
		'name',
		'screen_name',
		'location',
		'description',
		'url',
		'utc_offset',
		'time_zone',
		'verified',
		'lang',
	];

}
