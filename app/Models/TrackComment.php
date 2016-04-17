<?php

class TrackComment extends Eloquent {

	protected $table = 'tracks_comments';

    protected $softDelete = false;

	public function track()
	{
		return $this->belongsTo('Track');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function flags()
	{
		return $this->hasMany('TrackCommentFlag');
	}

	public function parent()
	{
		return $this->belongsTo('TrackComment', 'parent_id');
	}

	public function replys()
	{
		return $this->hasMany('TrackComment', 'parent_id');
	}
}