<footer class="row">

	<div class="hide-for-small medium-3 columns version-info">
		<a href="{{ URL::route('changelog') }}"><b>v0.9.6</b> | last update: 04.09.2019</a>
    <iframe
      src="https://ghbtns.com/github-btn.html?user=rocklegend-org&repo=website&type=star&count=true"
      frameborder="0"
      scrolling="0"
      width="170px"
      height="20px"
      style="margin-left: -2px;"
    ></iframe>
	</div>

	<div class="small-12 medium-6 main-column columns text-center">
		created with <i class="fa fa-heart t-red"></i> in austria
		<br />
		&copy; 2014 - {{date('Y')}} _ <a href="{{ URL::route('home') }}">rocklegend.org</a>
	</div>

	<div class="hide-for-small medium-3 columns text-right version-info">
		<a href="{{route('imprint')}}">imprint</a> | <a href="{{route('tos')}}">terms of service</a> | <a href="{{route('discover.songlist')}}">songlist</a> | <a href="/badges">badges</a>
	</div>
</footer>
