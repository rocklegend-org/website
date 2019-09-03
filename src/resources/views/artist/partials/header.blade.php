<div class="medium-12 columns">
	<meta itemprop="url" content="{{route('artist.show', array('artist' => $artist->slug))}}" />
	<div class="artist-header">
		<a href="{{ route('artist.show', array('artist' => $artist->slug)) }}">
			<img src="{{ $artist->getThumbnail(isset($width) ? $width : 600, isset($height) ? $height : 115, 'header') }}" alt="{{ $artist->name }}" />
			<span class="artist-name">{{$artist->name}}</span>
			{{--@if(isset($song) && is_object($song))
				<span class="song-name">{{$song->title}}</span>
			@endif--}}
			<span class="social-buttons">
				@if($artist->facebook_url != '' && (!isset($facebook) || $facebook == true)))
					<iframe src="//www.facebook.com/plugins/like.php?href={{urlencode($artist->facebook_url)}}&amp;width=100&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=1510352382540804" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px; width:80px" allowTransparency="true"></iframe>
					<div style="height: 24px; width: 1px;"></div>
				@endif

				@if(isset($youtube_subscribe) && $artist->youtube_id != '')
					<script src="https://apis.google.com/js/platform.js"></script>
					<div class="g-ytsubscribe" data-channelid="{{$artist->youtube_id}}"></div>
					<div style="height: 28px; width: 1px;"></div>
				@endif
			</span>			
		</a>
	</div>
</div>
<div class="clear"></div>