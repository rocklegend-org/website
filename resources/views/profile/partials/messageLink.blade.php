@if(User::current()->id != $user->id)
	<a href="{{route('conversation.start', array('recipient' => $user->username))}}" class="label bg-red t-white"><i class="fa fa-envelope"></i> Send a message</a>
@endif