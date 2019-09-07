<footer class="row">

	<div class="hide-for-small medium-3 columns version-info">
		<a href="{{ URL::route('changelog') }}"><b>v0.9.11</b> | last update: 07.09.2019</a>
		<a href="https://reddit.com/r/rocklegendorg" target="_blank">
				<img alt="Subreddit subscribers" src="https://img.shields.io/reddit/subreddit-subscribers/rocklegendorg?style=social" />
			</a>
	</div>

	<div class="small-12 medium-5 main-column columns text-center">
		created with <i class="fa fa-heart t-red"></i> in austria
		<br />
		&copy; 2014 - {{date('Y')}} _ <a href="{{ URL::route('home') }}">rocklegend.org</a>
	</div>

	<div class="hide-for-small medium-4 columns text-right version-info">
		<a href="https://www.patreon.com/bePatron?u=3916023" target="_blank">donate</a> | <a href="{{route('imprint')}}">imprint</a> | <a href="{{route('tos')}}">terms of service</a> | <a href="{{route('discover.songlist')}}">songlist</a> | <a href="/badges">badges</a>
	</div>
</footer>
