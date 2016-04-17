<div class="realtime-chat-container {{ Session::has('chat.open') ? (Session::get('chat.open') == 'true' ? 'active' : '') : 'active' }}">
	<div class="handle">
		<span class="left unread-container"><span class="unread-count">0</span> <i class="fa fa-envelope new-message-indicator"></i></span>
		Chat (<span class="user-count">0</span> online) 
		<span class="close">x</span>
	</div>
	<div class="messages row">
		<?php 
			$lastMessages = ChatMessage::orderBy('created_at', 'DESC')
							->with('user')
							->take(20)
							->get();

			$lastMessages->sortBy(function($d){
				return $d->created_at;
			});
		?>
		@each('chat.message', $lastMessages, 'message', 'raw|<p>No messages...</p>')
	</div>
	<div class="toolbar row">
		<form action="{{ url('/chat/send-message') }}" method="post" class="ws chat-message">
			<div class="small-12 columns">
				<input type="hidden" value="{{User::current()->id}}" name="user_id" />
				<input type="text" value="" placeholder="Your message..." name="chat-message" />
				<input type="submit" class="bg-green" value="Send" />
				<div class="clear"></div>
			</div>
		</form>
	</div>
</div>