@extends('layout')

@section('content')
<div class="small-6 columns">
	<h1 class="bg-green">Discover</h1>
		<input type="text" value="" name="search_text" placeholder="Search for artist or song..." style="display: inline-block; width: 200px; height: 34px;"/>
		{{--<div class="small-6 medium-9 columns">
			@for($i = 2; $i<=5; $i++)
			<a href="#" class="btn difficulty-filter bg-{{Config::get('game.difficulty_colors.'.$i)}}" data-difficulty-id="{{$i}}">{{Lang::get('game.difficulties.'.$i)}}</a>
			@endfor
		</div>--}}
</div>

<div class="small-6 columns text-right sort-by">
	<label for="sort-by" class="label">Sort by:</label>
	<a href="#" class="btn bg-blue js-discover-sort" data-sort="plays">total plays</a>

	<a href="#" class="btn bg-green inactive js-discover-sort" data-sort="name">name</a>

	<a href="#" class="btn bg-yellow inactive js-discover-sort" data-sort="artist_added">artist added</a>
</div>

<div class="small-12 columns">
	<hr style="margin-top:2px;"/>
</div>

<div class="artist-container">
<?php $clearCounter = 1; ?>
	@foreach($artists as $artist)
		<div class="small-12 medium-6 columns artist-box-big visible" data-artist="{{str_replace("  "," ",$artist->name)}}" data-artist-plays="{{$artist->playCount()}}" data-artist-added="{{strtotime($artist->created_at)}}">	
			<div class="row">
				@include('artist.partials.header', array('facebook'=>false))
			</div>
			<p class="short-bio">{!!$artist->shortBio(200)!!}</p>
		
			<div class="row">
			<?php $songsForArtist = 0; ?>
			@foreach($artist->songs as $song)

				@if(count($song->availableDifficulties()) > 0)
					<?php $songsForArtist++; 
						$soundFiles = $song->getSoundFiles();
					?>
					<div class="small-4 medium-5 columns big-text v-middle">
						<span class="song-title">{{$song->title}}</span>
						<br />
						<small>{{number_format($song->playCount(), 0, ",", ".")}} plays</small>
					</div>
					<div class="small-8 medium-7 columns text-right tracks" data-equalizer-watch>
					@for($i = 2; $i <= 5; $i++)
						<?php 
							$track = $song->getTrackForDifficulty($i);
						?>

						@if($track)
							<a href="{{route('game.play', array('track' => $track->id, 'song' => $song->slug, 'artist'=>$artist->slug))}}" class="btn bg-{{Config::get('game.difficulty_colors.'.$track->difficulty)}}" data-difficulty-id=="{{$i}}">{{Lang::get('game.difficulties.'.$track->difficulty)}}</a>
						@else
							<a href="#" class="btn bg-{{Config::get('game.difficulty_colors.'.$i)}} disabled trackable">{{Lang::get('game.difficulties.'.$i)}}</a>
						@endif
					@endfor
					</div>
					<div class="clear"></div>
				@endif
			@endforeach
				@if($songsForArtist <= 0)
				<div class="small-12 columns">
					<p>There are no tracks for this artist available yet :(</p>
				</div>
				@endif
			</div>
		</div>

		@if($clearCounter%2==0)
		<div class="clear"></div>
		@endif
		<?php $clearCounter++; ?>
	@endforeach
</div>
	<div class="clear"></div>
@stop

@section('footer-scripts')
<script type="text/javascript">
$(function(){
	discover.init();
});
</script>
@stop