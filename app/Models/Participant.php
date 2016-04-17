<?php

use Cmgmyr\Messenger\Models\Participant as MessengerParticipant;

class Participant extends MessengerParticipant {
	public function scopeMe($query, $user = null)
	{
		$user = $user ?: Sentry::getUser()->id;

		return $query->where('user_id', '=', $user);
	}

	public function scopeNotMe($query, $user = null)
	{
		$user = $user ?: Sentry::getUser()->id;

		return $query->where('user_id', '!=', $user);
	}

	public function removeParticipant()
	{
		$this->delete();
	}

}