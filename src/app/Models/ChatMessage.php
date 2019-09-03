<?php

class ChatMessage extends Eloquent {

	protected $table = 'chat_messages';

    protected $softDelete = false;

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function channel()
	{
		return $this->belongsTo('ChatChannel');
	}
}