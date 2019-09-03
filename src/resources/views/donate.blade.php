@extends('layout')

@section('content')

<div class="small-12 medium-8 medium-offset-2 columns text-center">
	@if(isset($thanks))
		<h1 class="bg-violet">THANK YOU FOR YOUR DONATION!</h1>
		<p>We'll unlock your donator badge manually soon! :)</p>
		<p>Cheers,<br /><b>Patrick & Michael</b></p>
		<hr />
	@endif
	<h1>Hey!</h1>
	<p><i>THANK YOU</i> for joining us on our way to <b>building a great online music game.</b></p>
	<h1 class="bg-green">How you can help:</h1>
	<p>There are a few ways you can help.<br /><br />
	<strong>1. Donate:</strong><br />
	We, <a href="/imprint">Patrick and Michael</a>, have to pay for server and domain costs.<br /><b>We don't get or make any money from rocklegend yet.</b><br /><i>We work on this project in our spare time.</i></p>
	<form action="https://www.paypal.com/cgi-bin/webscr" id="paypal-form" method="post" target="_top">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="ZJY7JCNM4YA8N">
	<input type="image" src="http://rocklegend.org/assets/images/frontend/donation-teaser.png" style="width: 250px; border:1px solid #ccc" border="0" name="submit" alt="Donate with PayPal." id="image-donate">
	<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
	</form>
	<p>Donations help us pay for <b>server & domain costs</b>, and depending on how many donations we get, we might even be able to <b>give our trackers a little motivation boost</b>, or buy <b>licenses for songs you want</b> (and are not available without the license).
	<br /><br />
	If you are already a registered user, please make sure to <i>provide your username in the message field on paypal so we can unlock the <b>"Donator" badge</b> for your account.</i></p>

	<p><strong>2. Spread the word:</strong><br />
		<br />
	<fb:share-button href="http://rocklegend.org" layout="button"></fb:share-button><br /><br />
	<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://rocklegend.org" data-text="Free online music game! Play right now, in your browser!" data-via="rocklegendorg" data-hashtags="thisisrocklegend">Tweet</a>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

	<p><strong>3. Tell & ask artists:</strong><br />
		Want to play an artist you like on rocklegend.org?<br />
		Make sure to tell us about it in our <a href="/forum">Forum</a>.<br /><br />
		Also make sure to <b>try contacting the artist - via twitter, facebook, mail, or whatever channel you want</b>. If more people talk about rocklegend, and artists get asked by their fans to join, it gets more likely that they allow us to use their material on <a href="http://rocklegend.org">rocklegend.org</a>.<br /><br />You can also  tell them that they can contact us via <a href="mailto:office@rocklegend.org">office@rocklegend.org</a> should they have any questions!</p>

	<p><strong>4. Be an active member of the community:</strong><br />
		rocklegend would be nothing without its users.<br />
		<b>We are grateful for every single one of you</b> who signed up, played or commented on a track, or posted something in the forum.<br /><br />You're the heart and soul of rocklegend, and we're thrilled to see where you lead us next.</p>
</div>
@stop

@section('footer-scripts')
<script type="text/javascript">
	$(function(){
		$('#image-donate').on('mouseenter', function(){
			$(this).css('border', '4px solid #ccc');
		}).on('mouseleave', function(){
			$(this).css('border', '1px solid #ccc');
		});
	});
</script>
@stop