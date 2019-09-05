<!DOCTYPE html>
<html>
	<head>

		<title>@yield('page_title', 'rocklegend | free online music game')</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

		<meta name="description" content="@yield('meta_description', 'a free online music game. play awesome songs for fun, beat highscores or compete against friends. do you have what it takes to be a rocklegend?')" />
		<meta charset="UTF-8">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta name="robots" content="index,follow" />
		<meta name="revisit-after" content="3 days" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="keywords" lang="en" content="online music game, jamlegend, rhythm game, rocklegend, find new bands, bored at school" />

		@section('facebook_meta')
			<meta property="og:title" content="rocklegend - a free online music game" />
			<meta property="og:site_name" content="rocklegend" />
			<meta property="og:description" content="rocklegend offers you a new way to discovery new music, re-experience your beloved favorite tracks and challenge your friends! do you have what it takes to be a rocklegend?" />
			<meta property="og:image" content="{{asset('assets/images/frontend/thisisrocklegend.jpg')}}" />
		@stop
		
		<meta property="fb:admins" content="100000020528590" />
		<meta property="fb:app_id" content="1510352382540804" />
		<meta name="google-site-verification" content="31refmPqZG3__4v8AGiWQXIds3F-f--dJVQ8Ftns7Wk" />

		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">

		{{-- css --}}		
		{!! HTML::style('assets/css/frontend/main.css?t='.time()) !!}

		{{-- fonts --}}
		<link href='//fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css' />
		<link href='//fonts.googleapis.com/css?family=Roboto:400,300italic,300,100,500,400italic,500italic,700' rel='stylesheet' type='text/css' />
	</head>
	<body class="{{ strtolower(preg_replace('/controller@[A-Za-z]*/i', '', Route::currentRouteAction())) }} {{isset($player) ? 'player' : ''}}">
		<div id="fb-root"></div>
		<script>
		var csrf = '{!!csrf_token()!!}';
		
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId={{trim(Config::get('services.facebook.client_id'))}}&version=v2.0";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<div id="rl-page-loading-overlay">
			<i class="fa fa-refresh fa-spin"></i>
		</div>
		<header class="row">
			<div id="header-container" class="clearfix" data-equalizer>
				<div class="columns small-12 hide-for-medium-up">
					<a href="{{ URL::route('home') }}" title="rocklegend home">
						<span class="logo hover-cursor {{ Request::is('/*') ? 'active' : ''}}">rocklegend</span>
					</a>

				</div>
				<div class="columns small-2 medium-6" data-equalizer-watch>
					<a href="{{ URL::route('home') }}" class="hide-for-small logo-container">
						<span class="logo hover-cursor {{ Request::is('/*') ? 'active' : ''}}">rocklegend</span>
					</a>

					@include('partials.header.notifications')
					<nav>
						<ul class="navigation main">
							<?php
								foreach(Config::get('page.navigation') as $text => $navItem):
							?>
								<li class="">
									<a 	href="{{ $navItem['url'] }}" 
										class="{{ $navItem['class'] }} 
										<?php
											$active = false;
											foreach($navItem['activeCheck'] as $route){
												if(Request::is($route))
													$active = true;
											}
											if($active)
												echo 'active'
										?>"
										title="{{$text}}"><i class="fa {{ $navItem['icon'] }}"></i> {{ $text }}</a>
								</li>
							<?php 
								endforeach;
							?>
						</ul>
					</nav>
				</div>

				<div class="small-10 medium-6 columns profile-box" data-equalizer-watch>
					<div class="row">
					@if (!Sentry::check())
						@include('partials.header.login')
					@else
						@include('partials.header.user')
					@endif
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</header>

		<div class="trenn">
			{{--http://www.shutterstock.com/video/clip-1935766-stock-footage-footage-of-a-crowd-partying-at-a-rock-concert.html?src=rel/1935535:0&download_comp=1--}}
			{{--<video width="100%" height="" autoplay="true" controls="false" loop="true">
			  <source src="/assets/images/frontend/crowd-movie.mp4" type="video/mp4">
			  <source src="/assets/images/frontend/crowd-movie.ogg" type="video/ogg">
				Your browser does not support the video tag.
			</video>--}}
			<div class="overlay"></div>
			@yield('trenn', '')
		</div>

		<div id="wrapper-content" class="row">
			@yield('content')
		</div>

		@include('partials.footer')

		<div id="rl-page-darken-overlay"></div>

		<div class="info-box info-box--bottom">
			<div class="badge-info columns small-12">
				<h5><i class="fa fa-trophy"></i> You earned a new badge!&nbsp;
				<i class="fa fa-close close"></i></h5>
				<div class="left" data-equalizer-watch>
					<img src="{{asset('assets/images/frontend/logo.png')}}" style="width: 50px;" class="left" />
				</div>
				<div style="margin-left: 60px;" data-equalizer-watch>
					<span class="badge-title">Badge Ttitle</span><br />
					<span class="badge-description">Badge Description</span>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
		@if(Config::get('realtime::enabled') && !is_null(Sentry::getUser()))
-			@if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']  != 'on')
-			@include('chat.base')
-			@endif
-		@endif
		
		{{-- javascripts --}}
		<script>
			{{-- google analytics --}}
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-48019740-1', 'auto');
			{{--ga('set', 'anonymizeIp', true);--}}
			{{--ga('require', 'displayfeatures');--}}
			
			@if(App::environment('live'))
				ga('send', 'pageview');
			@endif

    		{{--itunes affiliate--}}    		
    		var _merchantSettings=_merchantSettings || [];_merchantSettings.push(['AT', '11lMbn']);(function(){var autolink=document.createElement('script');autolink.type='text/javascript';autolink.async=true; autolink.src= ('https:' == document.location.protocol) ? 'https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js' : 'http://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(autolink, s);})();</script>

		<script type="text/javascript">
			var base_url = '{{url("")}}'; 
			var uid = {!! User::current()->id ? "'".User::current()->getUID()."'" : 'false' !!};
			window.user_id = {{User::current()->id ? User::current()->id : '0'}};
		</script>

		{!! HTML::script('assets/js-min/plugins.min.js') !!}

		{!! HTML::script('assets/js-min/rl.min.js') !!}

		@if(Session::has('jumpTo'))
			<script type="text/javascript">
				$(function(){
					rl.jumpTo('{{ Session::get('jumpTo') }}');
				});
			</script>
		@endif
		@yield('footer-scripts')
		<div class="clear"></div>
	</body>
</html>