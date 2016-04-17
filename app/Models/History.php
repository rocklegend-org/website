<?php

class History extends Eloquent {

	protected $table = 'history';

    protected $softDelete = false;

	public function user()
	{
		return $this->belongsTo('User');
	}
}