<div class="medium-8 columns artist-meta text-left">
{{ $artist->genre }}{{ $artist->founded_date != '' ? ', since '.$artist->founded_date : '' }}&nbsp;
</div>
<div class="medium-4 columns artist-more text-right">
	<a href="{{ route('artist.show', array('artist' => $artist->slug)) }}">show profile</a>
</div>
<div class="clear"></div>