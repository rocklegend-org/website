<ul class="song-list" itemscope itemtype="http://schema.org/MusicGroup">
	<meta itemprop="name" content="{{$artist->name}}" />
	<meta itemprop="image" content="{{$artist->getArtwork()}}" />
<?php 
	$i = 0; 
	 $default_song = isset($song) ? $song : false;
?>

@foreach($artist->songs as $song)
	@if($song->tracks()->where('status',2)->whereNull('deleted_at')->count() > 0)
	<?php $i++; ?>
	<li data-song-id="{{ $song->id }}" data-song-slug="{{$song->slug}}" {{ ($default_song && $default_song == $song) || ($i == 1 && (!isset($autoopen) || $autoopen))? 'class="active"' : '' }} itemscope itemprop="track" itemtype="http://schema.org/MusicRecording">
		<meta itemprop="image" content="{{$song->getArtwork()}}" />
		<meta itemprop="genre" content="{{$artist->genre}}" />
		<meta itemprop="url" content="{{route('artist.show', array('artist' => $artist->slug))}}" />
		<meta itemprop="duration" content="{{$song->getDuration()}}" />
		@if($song->album)
			<meta itemprop="inAlbum" content="{{$song->album->title}}" />
		@else
			<meta itemprop="inAlbum" content="{{$song->title}}" />
		@endif
		<a href="javascript:;" class="song" itemprop="name">
			{{$i.'. '.$song->title}}
		</a>
		<ul class="track-list headline">
			<li>
				<div class="row">
					<div class="small-6 columns track-name">
						Difficulty
					</div>
					<div class="small-3 columns score">
						your best
					</div>
					<div class="small-3 columns score">
						todays best
					</div>
					<div class="clear"></div>
				</div>
			</li>
		</ul>
		<ul class="track-list">
		@foreach($song->getTracks() as $track)
			@php
				$userScore = $track->getUserScore();
				$highScore = $track->getHighscore("today");
			@endphp
			<li class="track">
				<a href="{{ $track->url() }}?ref=discovery" title="Play {{ $song->title }} by {{ $artist->name }} | {{$track->getDifficultyName()}}">
					<div class="row">
						<div class="small-6 columns track-name">
							{{ $track->getDifficultyName() }} <small>by {{ $track->user->username }}</small>
						</div>
						<div class="small-3 columns score">
							@if(!is_null(User::current()))	
								{{number_format($userScore, 0, ',', '.')}} 
								@if($userScore > 0 && $userScore >= $highScore)
									<i class="fa fa-trophy t-green"></i>
								@endif
							@else
								-
							@endif
						</div>
						<div class="small-3 columns score">
							{{number_format($highScore, 0, ',', '.')}}
							@if($highScore > 0 && $userScore <= $highScore)
								<i class="fa fa-trophy t-green"></i>
							@endif
						</div>
						<div class="clear"></div>
					</div>
				</a>
			</li>
		@endforeach
		</ul>
	</li>
	@endif
@endforeach
</ul>

@if($i <= 0)
<p>This artist doesn't have any tracked songs on rocklegend yet.</p>
@endif

{{-- If trackable songs exist, show them --}}
@if($artist->songs()->where('trackable',true)->get()->count() > 0)
	<h3 class="bg-blue">Track a song</h3>
	<ul class="song-list blue">
		@foreach ($artist->songs()->where('trackable',true)->get() as $track_song)
			<li>
				<a href="{{ URL::route('create.editor', array('song' => $track_song->slug, 'lanes' => 5))}}">
					{{ $track_song->title }}
				</a>
			</li>
		@endforeach
	</ul>
@else
 <p>There are currently no tracks for tracking available...</p>
@endif

{{-- If there are requested songs in the database, show them --}}
@if($artist->songs()->where('status',4)->get()->count() > 0)
<h3 class="bg-red tooltip" title="These are songs which were requested by other rocklegend users.">Requested Songs</h3>
	<ul class="song-list red">
		@foreach($artist->songs()->where('status',4)->get() as $req_song)
			<li>
				<a href="javascript:void(0)" class="force-reload">{{$req_song->title}}</a>
			</li>
		@endforeach
	</ul>
@endif

@section('footer-scripts')
	@parent
	<script type="text/javascript">
		jQuery(function($) {
			// handle song list toggling
			$('ul.song-list > li').on('click', function(e) {
				if (!$(this).hasClass('active')) {
					$('ul.song-list li.active').removeClass('active');
				}

				$(this).toggleClass('active');
			});
		});
	</script>
@stop