<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>{{ 'rocklegend :: '.(isset($pageTitle) ? $pageTitle : 'dashboard') }}</title>

		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=PT+Sans:700,400' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Pontano+Sans' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>

		<!-- Styles -->
		{!! HTML::style('assets/css/dashboard/_vendors/font_awesome/font-awesome.css') !!}
		{!! HTML::style('assets/css/dashboard/_vendors/various/bootstrap.min.css') !!}
		{!! HTML::style('assets/js/dashboard/datepicker/css/datepicker.css') !!}

		{!! HTML::style('assets/css/dashboard/main.css') !!}<!-- Style -->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		{!! HTML::script('assets/js/jquery.form.js') !!}
		{!! HTML::script('assets/js/dashboard/Chart.min.js') !!}
		{!! HTML::script('assets/js/dashboard/rails.js') !!}
		{!! HTML::script('assets/js/dashboard/datepicker/js/datepicker.js') !!}

	</head>
	<body class="{{ $bodyClass or ''}}">

		@section('responsive.menu')

		<header>

			<div class="logo">
				<a href="{{ URL::route('dashboard') }}">
					<img src="{{ asset('assets/images/dashboard/logo_white.png') }}" alt="" />
				</a>
			</div>

			<div class="header-alert">
				<ul>
					@if( Sentinel::check() )
					<li><a href="{{ URL::route('dashboard.user.show', array('id' => Sentinel::getUser()->id)) }}" title=""><i class="fa fa-user"></i>{{ Sentinel::getUser()->username }}</a></li>
					@endif
					<li><a href="{{ URL::route('logout') }}" title=""><i class="fa fa-power-off"></i>Logout</a></li>
				</ul>
			</div>

		</header><!-- Header -->

		<div class="menu">
			<ul>
				<li>
					<a href="{{URL::route('dashboard')}}" title="Home" ><i class="fa fa-trophy"></i>Home</a>
				</li>
				<li>
					<a href="{{ URL::route('dashboard.song.index') }}" title="Songs" ><i class="fa fa-music"></i>Songs</a>
				</li>
				<li>
					<a href="{{ URL::route('dashboard.artist.index') }}" title="Artists" ><i class="fa fa-male"></i>Artists</a>
				</li>
				<li>
					<a href="{{ URL::route('dashboard.album.index') }}" title="Albums" ><i class="fa fa-list-alt"></i>Albums</a>
				</li>
				<li>
					<a href="{{ URL::route('dashboard.user.index') }}" title="Users" ><i class="fa fa-users"></i><!--<span><i>20+</i></span>-->Users</a>
				</li>
				<li>
					<a href="{{ URL::route('dashboard.signup-code.index') }}" title="Signup Codes" ><i class="fa fa-key"></i><!--<span><i>20+</i></span>-->Codes</a>
				</li>
			</ul>
		</div>

		@stop

		@yield('responsive.menu')

		<div class="wrapper">

			<div class="container">

			@include('dashboard/partials/alerts')

				@yield('content')

			</div><!-- Container -->

		</div><!-- Wrapper -->

	</body>
</html>