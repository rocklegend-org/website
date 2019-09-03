<?php

class UserBadge extends Eloquent{
	protected $table = 'user_badges';

	public function badge()
	{
		return $this->belongsTo('Badge');
	}
}