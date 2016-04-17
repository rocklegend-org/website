<?php

class ChatUser extends Eloquent {

	protected $table = 'chat_users';

    protected $softDelete = false;

	public function user()
	{
		return $this->belongsTo('User', 'creator_id');
	}

	public function channel()
	{
		return $this->belongsTo('ChatChannel', 'channel_id');
	}
}