<?php

use Illuminate\Database\Eloquent\Builder;

use Cmgmyr\Messenger\Models\Thread as MessengerConversation;

class Conversation extends MessengerConversation {
	public function messages()
	{
		return $this->hasMany('Message', 'thread_id');
	}
	public function participants()
	{
		return $this->hasMany('Participant', 'thread_id');
	}

	public function scopeForUser(Builder $query, $user = null)
	{
		$user = $user ?: Sentinel::getUser()->id;

		return $query->join('participants', 'threads.id', '=', 'participants.thread_id')
		->where('participants.user_id', $user)
		->where('participants.deleted_at', null)
		->select('threads.*');
	}

	public function scopeWithNewMessages($query, $user = null)
	{
		$user = $user ?: Sentinel::getUser()->id;

		return $query->join('participants', 'threads.id', '=', 'participants.thread_id')
		->where('participants.user_id', $user)
		->where('threads.updated_at', '>', \DB::raw('participants.last_read'))
		->select('threads.*');
	}

	public function participantsString($userId = NULL, $columns = array())
	{
		$user = $user ?: Sentinel::getUser()->id;

		$participantNames = \DB::table('users')
		->join('participants', 'users.id', '=', 'participants.user_id')
		//->where('users.id', '!=', $user)
		->where('participants.thread_id', $this->id)
		->select('username as name')
		->pluck('users.name');

		return implode(', ', $participantNames);
	}

	public function lastMessage()
	{
		return Message::where('thread_id', $this->id)->orderBy('created_at', 'DESC')->first();
	}
}