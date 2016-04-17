<?php

class Notification extends Eloquent{

	protected $table = 'notifications';

	public function user()
	{
		return $this->belongsTo('User', 'recipient_id');
	}

	public function scopeMe()
	{
		return $query->where('recipient_id', User::current()->id);
	}

	public function scopeActive()
	{
		return $query->where('active',1);
	}

	public function scopeType($type)
	{
		return $query->where('type', $type);
	}

	public function save(array $options = array())
	{
		parent::save();

		Event::fire('emit.user', array('notification', 'new.notification', $this->recipient_id, array()));
	}
}