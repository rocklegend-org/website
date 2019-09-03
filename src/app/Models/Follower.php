<?php

class Follower extends Eloquent {

	protected $table = 'followers';

    protected $softDelete = false;

	public function stalker()
	{
		return $this->belongsTo('User', 'stalker_user_id');
	}

	public function user()
	{
		return $this->belongsTo('User', 'followed_user_id');
	}
}