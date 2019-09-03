@extends('layout')

@section('content')

<div class="small-12 medium-3 hide-for-small columns">&nbsp;</div>
<div class="small-12 medium-6 columns">
	<div class="row">
		<h1 class="bg-green">Start a new conversation</h1>

		<a href="{{route('conversation')}}" style="float:right;"><i class="fa fa-arrow-circle-left"></i> my conversations</a>
		<br />
		<form id="start-conversation" action="{{route('conversation.start')}}" method="post">
			{!! csrf_field() !!}
			<h3 class="bg-red">Recipient(s):</h3>
			<br />
			<p>Type at least 2 characters of a username to get a list of possible recipients.</p>
			<input type="text" value="" name="recipients" />
			
			<div class="clear"></div>
			<p></p>

			<h3 class="bg-blue">Subject:</h3>
			<br />
			<input type="text" value="" required name="subject" placeholder="e.g. How did you create this track?" />

			<div class="clear"></div>
			<p></p>
			<h3 class="bg-yellow">Your message:</h3>
			<br />
			<p>You can use <a href="http://www.darkcoding.net/software/markdown-quick-reference/" target="_blank">Markdown syntax</a> to style your message.</p>
			<textarea name="message" rows="7" required></textarea>

			<div class="clear"></div>

			<button class="bg-green"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Send Message</button>
		</form>
	</div>
</div>
<div class="small-12 medium-3 hide-for-small columns">
	{{--<h3 class="bg-blue">Add Followed Users</h3>
	<ul>
	@foreach(User::current()->follows as $follow)
		<li>{{$follow->user->username}}</li>
	@endforeach
	</ul>--}}
</div>

@stop

@section('footer-scripts')
<script type="text/javascript">
var autoSuggestPrefill = '{{$prefill}}';
$(function(){
	window.conversations.init();
});
</script>
@stop