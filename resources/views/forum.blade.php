@extends('layout')

@section('page_title')
Forum | rocklegend
@overwrite

@section('content')

<div class="small-12 columns main-column">
	{{--<p>Please keep in mind that your forum profile is not completely linked to your rocklegend profile.<br />Changes on either side might not be synced.</p>
	<script type="text/javascript">
		var vanilla_forum_url = '{{ public_path() }}'; // The full http url & path to your vanilla forum
		var vanilla_sso = '{{ $vanilla_sso }}'; // Your SSO string.
		var timestamp = false;
		$(function(){
			timestamp = new Date().getTime();
		})
	</script>
	<script type="text/javascript" src="http://forum.rocklegend.org/js/embed.js"></script>--}}

	<h2>Sorry!</h2>
	<p>Our forum is not available at this moment. 
		<br />If you have anything to share, you can reach us via <a href="https://twitter.com/rocklegendorg" target="_blank">Twitter</a> or <a href="https://facebook.com/rocklegendgame" target="_blank">Facebook</a>!
		<br /><br />Thanks for checking in! <strong>You rock!</strong></p>
</div>

@stop