<?php

class ChatChannel extends Eloquent {

	protected $table = 'chat_messages';

    protected $softDelete = false;
    
	public function messages()
	{
		return $this->hasMany('ChatMessage');
	}
}