<?php

class TrackCommentFlag extends Eloquent {

	protected $table = 'tracks_comments_flags';

    protected $softDelete = false;

	public function trackComment()
	{
		return $this->belongsTo('TrackComment', 'id', 'track_comment_id');
	}

	public function user()
	{
		return $this->belongsTo('User')->withTrashed;
	}
}