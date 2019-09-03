<div class="message small-12 columns">
	<a href="{{ route('profile', array('username' => $message->user->username)) }}">
		<img src="{{ $message->user->getAvatarUrl() }}" alt="{{ $message->user->username }}" class="profile" /> <strong>{{$message->user->username}}: </strong>
	</a>
	{{Helper\RLString::beautify($message->message)}}
</div>