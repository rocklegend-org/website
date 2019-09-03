<?php

class TrackHistory extends Eloquent {

	protected $table = 'tracks_history';

	public function track()
	{
		return $this->belongsTo('Track');
	}
}