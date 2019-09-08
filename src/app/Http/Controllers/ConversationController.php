<?php
use Carbon\Carbon;

class ConversationController extends BaseController {

	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth', array('except' => array('login', 'login')));
	}

	public function index()
	{
		$conversations = Conversation::forUser()->orderBy('updated_at', 'desc')->get();

		return View::make('conversation.list', compact('conversations'));
	}

	public function start($recipient = false)
	{
		if(Request::isMethod('get')){
	        $conversations = Conversation::forUser()->orderBy('updated_at', 'desc')->get();

			return View::make('conversation.start', compact('conversations'))
				->with('prefill', $recipient ? $recipient : '');
		}elseif(Request::isMethod('post')){
			$input = Input::all();

			$thread = Conversation::create([
			    'subject' => $input['subject'],
			]);

			$message = Message::create([
			    'thread_id' => $thread->id,
			    'user_id' => User::current()->id,
			    'body' => $input['message']
			]);

			$sender = Participant::create([
			    'thread_id' => $thread->id,
			    'user_id' => User::current()->id,
			    'last_read' => new Carbon
			]);

			if (Input::get('recipients'))
			{
				$recipients = explode(",", Input::get('recipients'));

				$recipientObjects = [];

				foreach($recipients as $recp){
					if($recp != ''){
						$user = User::where('username', $recp)->first();

						if(!is_null($user)){
							$recipientObjects[] = Participant::create(array(
								'thread_id' => $thread->id,
								'user_id' => $user->id,
			    				'last_read' => new Carbon
							));
						}
					}
				}
			}

			foreach($recipientObjects as $part){
				$notify = new Notification;
				$notify->recipient_id = $part->user_id;
				$notify->type = 'message.received';
				$notify->title = Lang::get('conversations.message.received');
				$notify->subject = $thread->subject;
				$notify->message = $message->id; //strlen($message->body) < 75 ? $message->body : substr($message->body, 0, 75).'...';
				//$notify->debug = serialize($message);
				$notify->group_id = $thread->id;
				$notify->active = 1;
				$notify->save();
			}

			return Redirect::route('conversation.read', array('conversation' => $thread->id));
		}
	}

	public function read($id)
	{
        $conversation  = Conversation::find($id);

        if(Participant::me()->where('thread_id', $id)->first() != null){
	        $me = Participant::me()->where('thread_id', $conversation->id)->first();
	        $me->last_read = new Carbon;
	        $me->save();

	        // TRIGGER EVENT: User read message
	        $resp = $this->messages($conversation->id, true);
	        return View::make('conversation.read', compact('conversation'))
	        	->with('messagesHtml', $resp['html']);
	    }
	}

	public function message()
	{
		$conversation = Conversation::find(Input::get('thread_id'));

		if(trim(Input::get('message')) != '' && Participant::me()->where('thread_id', Input::get('thread_id'))->first() != null){
	        $message = Message::create([
	            'thread_id' => $conversation->id,
	            'user_id' => User::current()->id,
	            'body' => Input::get('message'),
	        ]);

	        $participants = $conversation->participants()->where('user_id', '!=', User::current()->id)->get();
	        
			foreach($participants as $part){
				$notify = new Notification;
				$notify->recipient_id = $part->user_id;
				$notify->type = 'message.received';
				$notify->title = Lang::get('conversations.message.received');
				$notify->subject = $conversation->subject;
				$notify->message = $message->id; //strlen($message->body) < 75 ? $message->body : substr($message->body, 0, 75).'...';
				//$notify->debug = serialize($message);
				$notify->group_id = $conversation->id;
				$notify->active = 1;
				$notify->save();
			}

	        $ident = 0;

	        return $this->messages($conversation->id);
	    }
	}

	public function messages($id, $as_array = false)
	{
		if(!Request::ajax() && !$as_array){
			return Redirect::to('/');
		}

		$thread = Conversation::find($id);

		$start = 0;

		if(Input::get('limit') == 0){
			$limit = 250;
		}else{
			$limit = 25;
		}
	
		$countTotal = $thread->messages()->count();
		$messages = $thread->messages()->take($limit)->orderBy('created_at', 'DESC')->get();

		$messages = $messages->reverse();

		$ident = md5($messages);

		if(Participant::me()->where('thread_id', $id)->first() != null){
			$response = array();

			if(Input::get('ident') != $ident){
				$response['id'] = $thread->id;
	        	$response['html'] = View::make('conversation.partials.messages')
	        							->with('messages', $messages)
	        							->with('limit', $limit)
	        							->with('countTotal', $countTotal)
	        							->with('count', count($messages))
	        							->render();
	        }

	        if($as_array){
	        	return $response;
	        }

	        return Response::json($response);
	    }
	}

	public function leave($id)
	{
		$participant = Participant::me()->where('thread_id', $id)->first();
		$participant->removeParticipant();

		// TRIGGER EVENT: User left conversation

		return Redirect::route('conversation');
	}

	public function availableRecipients()
	{
		$q = Input::get('q');

		$users = User::where('username','LIKE',"%$q%")->where('username', '!=', User::current()->username)->get();

		$data = array();
		foreach($users as $user){
			$json = array(
				'value' => $user->username,
				'name' => $user->id
			);
			$data[] = $json;
		}

		return Response::json($data);
	}

}