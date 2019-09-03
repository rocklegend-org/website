@extends('layout')

@section('page_title')
{{ $artist->name }} | rocklegend
@overwrite

@section('meta_description')
{{str_replace('"',"'",$artist->shortBio(250, false))}}
@overwrite

@section('facebook_meta')
<meta property="og:title" content="{{ $artist->name }}" />
<meta property="og:site_name" content="rocklegend" />
<meta property="og:description" content="{{$artist->shortBio(255, false, true)}}" />
<meta property="og:image" content="{{$artist->getThumbnail(1200,800)}}" />
<meta property="og:type" content="profile"/>
<meta property="og:url" content="{{ route('artist.show', array('artist' => $artist->slug)) }}" />
@stop

@section('content')
	<div class="small-12 medium-10 medium-offset-1 end columns">
		<div class="row">
			@include('artist.partials.header', array('width' => 1000, 'height' => 275, 'youtube_subscribe' => true))
		</div>
	</div>
	<div class="clear"></div>
	<div class="small-12 medium-6 medium-offset-1 columns artist-data">
		<h3 class="bg-violet">Biography</h3><br />
		{!!$artist->biography!!}

		@if($artist->facebook_url != '')
		<hr />
		<iframe src="//www.facebook.com/plugins/likebox.php?href={{urlencode($artist->facebook_url)}}&amp;width=200&amp;height=558&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=true&amp;show_border=true&amp;appId={{Config::get('oauth-4-laravel::consumers.Facebook.client_id')}}" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:558px;" allowTransparency="true"></iframe>
		@endif
	</div>
	<div class="small-12 medium-4 columns end artist-data">
		<h3 class="bg-red">Links</h3><br />

		@if($artist->website_url != '')
		<a href="{{$artist->website_url}}" target="_blank" title="{{$artist->name}} official website"><i class="fa fa-home"></i> Official Website</a>
		<br />
		@endif

		@if($artist->facebook_url != '')
		<a href="{{$artist->facebook_url}}" target="_blank" title="{{$artist->name}} on facebook"><i class="fa fa-facebook-square"></i> facebook</a>
		<br />
		@endif

		@if($artist->twitter_url != '')
		<a href="{{$artist->twitter_url}}" target="_blank" title="{{$artist->name}} on twitter"><i class="fa fa-twitter-square"></i> twitter</a>
		<br />
		@endif

		@if($artist->youtube_url != '' || $artist->youtube_id != '')
		<a href="{{$artist->youtube_url != '' ? $artist->youtube_url : 'https://youtube.com/channel/'.$artist->youtube_id }}" target="_blank" title="{{$artist->name}} on YouTube"><i class="fa fa-youtube-square"></i> YouTube</a>
		<br />
		@endif

		@if($artist->itunes_url != '')
		<a href="{{$artist->itunes_url}}" target="_blank" title="{{$artist->name}} on iTunes">
		  <i class="fa fa-music"></i> iTunes</a>
		<br />
		@endif

		<h3 class="bg-green">Songs on rocklegend</h3><br />
		@include('artist.partials.songs', array('autoopen' => false))
	</div>
@stop