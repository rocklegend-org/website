@extends('layout')

@section('facebook_meta')
<meta property="og:title" content="{{ $song->title }} by {{ $song->artist->name }} ({{$track->getDifficultyName()}}) | rocklegend" />
<meta property="og:site_name" content="rocklegend" />
<meta property="og:description" content="Play '{{$song->title}}' by {{$artist->name}} ({{$track->getDifficultyName()}}) now! Do you have what it takes to be a rocklegend?" />
<meta property="og:image" content="{{$song->artist->getThumbnail(1200,800)}}" />
<!-- {{url('')}}/assets/images/frontend/logo.png -->
<meta property="og:type" content="music.song"/>
<meta property="og:url" content="{{ route('game.play', array('artist' => $song->artist->slug, 'song' => $song->slug, 'track' => $track->id)) }}" />
@stop

@section('page_title')
{{ $song->title }} by {{ $song->artist->name }} ({{$track->getDifficultyName()}}) | rocklegend @overwrite

@section('meta_description')
Play '{{$song->title}}' by {{$artist->name}} ({{$track->getDifficultyName()}}) now! Do you have what it takes to be a rocklegend?
@overwrite

@section('content')
	@if(!$isFacebook)
	</div> <!-- wrapper content -->
<div ng-app="app" class="full play-wrapper">
	<div class="large-player-background" style="background-image:url({{$song->getThumbnail(1200,900)}})">
		<div class="overlay"></div>
	</div>

	<div class="large-player-loading-overlay"></div>

	<div class="row">
		<div class="hide-for-small medium-4 columns text-right">
			<br />
			<br />
			<br />
			<br />
			<br />
			<div class="score-display">
				<div class="score-points-wrap">
					<h1 class="bg-green">Score</h1>
					<h1 class="score" id="score-num">0</h1>
				</div>
				<br />
				<div class="score-streak-wrap">
					<h1 class="bg-red">Streak</h1>
					<h1 class="streak" id="streak-num">0</h1>
				</div>
				<br />
				<div class="score-multiplier-wrap">
					<h1 class="bg-blue">Multiplier</h1>
					<h1 class="multiplier" id="multiplier-num">x1</h1>
				</div>
				<div>
					<a href="javascript:void(0);" onclick="rl.toggleFocus();return false;" class="force-reload focusToggle">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x t-black"></i>
							<i class="fa fa-lightbulb-o fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				</div>
				<div>
					<a href="javascript:void(0);" onclick="this.style.display = 'none'; RL.init(); return false;" class="force-reload reloadSong" style="display: none;">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x t-yellow"></i>
							<i class="fa fa-repeat fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				</div>

				<h3 class="bg-black t-white">
					<b>Quick Restart:</b> Press <b>{{ chr($settings['quick_restart']) }}</b> twice<br />
				</h3>

				<h4 class="bg-white t-black">
@if($track->status != 2)
<b>UNPUBLISHED TRACK!</b><br />
@endif
					This track is brought to you by <a href="{{$track->user->profileUrl()}}" class="t-violet"><b>{{$track->user->username}}</b></a><br />It has been played <b>{{$track->getPlayCount()}}</b> times!<br /><br />
				<b>Duration:</b> {{$track->song->getDuration(false)}}</h3>
			</div>
		</div>

		<div class="small-12 medium-4 columns text-center">
			<div class="row">
				<div id="main-canvas">
					<div class="gradient-top"></div>
					<div class="gradient-bottom"></div>
					<div id="progress-bar"></div>
					<div class="bar bar-highscore">
						<label for="highscore">Highscore</label>
					</div>
					<div class="bar bar-user-highscore">
						<label for="highscore">Your Highscore</label>
					</div>
					<div class="bar bar-friend-score" id="bar-score-friend">
						<label for="highscore">{{ is_object($friendScore) ? $friendScore->user->username : 'Friend' }}s Score</label>
					</div>
					<div class="bar bar-current-score" id="bar-score-current">
						<label for="highscore">Current Score</label>
					</div>
					<div class="button-overlay">
						@for($i = 1; $i <= 5; $i++)
							<span class="button-{{$i}}">
								{{chr($settings['key_lane'.$i])}}
							</span>
						@endfor
					</div>
					<div class="loading-overlay">
						<p>
							<img src="{{asset('assets/images/frontend/logo-menu-button-transparent.png')}}" alt)"rocklegend player" />
							<br />
							loading rocklegend player
						</p>
					</div>
					<div class="counter-overlay">
						<p class="info">
							<span class="bg-black">&nbsp;&nbsp;&nbsp;{{$track->getDifficultyName()}}&nbsp;&nbsp;&nbsp;</span><br /><br />
							<span class="song-name--info-overlay">{{$song->title}}</span>
							by
							<span class="artist-name--info-overlay">{{ $artist->name }}</span><br />-<br />
							Press [SPACE] or click here <br />to start the countdown!<br /><br /><b><span class="var-mode">{{$settings['play_mode']}}</span> mode</b><br />
							<i id="change-playmode" class="btn t-white bg-black">&nbsp;&nbsp;&nbsp;change to <span class="var-mode-alt">{{$settings['play_mode'] == 'tap' ? 'strum' : 'tap'}}</span>&nbsp;&nbsp;&nbsp;</i></p>
						<p class="count">3</p>
					</div>
					<div class="score-overlay">
						<br />
						<h1 class="headline bg-green"><i class="fa fa-trophy"></i> song finished!</h1>

						<div class="score-button-wrap">
							<a href="#" class="repeat-song btn bg-red"><i class="fa fa-repeat"></i>&nbsp;play again</a>
							<a href="{{ route('game.play', array('artist' => $nextSong->song->artist->slug, 'song' => $nextSong->song->slug, 'track' => $nextSong->id)) }}" class="next-song btn bg-green"><i class="fa fa-step-forward"></i>&nbsp;next song</a>
							<a href="#" class="share-score btn bg-fb-blue"><i class="fa fa-facebook"></i>&nbsp;share score!</a>
							@if($song->artist->itunes_url != "")
								<a href="{{$song->artist->itunes_url}}" class="buy-song btn bg-white t-black" target="_blank"><i class="fa fa-shopping-cart"></i>&nbsp;buy this song!</a>
							@elseif($song->artist->bandcamp_url != "")
								<a href="{{$song->artist->bandcamp_url}}" class="buy-song btn bg-white t-black" target="_blank"><i class="fa fa-shopping-cart"></i>&nbsp;buy this song!</a>
							@endif
						</div>
					</div>
					<div class="settings-button">
						<a href="#" class="btn-custom">
							<i class="fa fa-cog fa-inverse"></i>
						</a>
					</div>
					<div class="settings-overlay">
						<span class="fa-stack fa close">
							<i class="fa fa-circle fa-stack-2x t-red"></i>
							<i class="fa fa-close fa-stack-1x fa-inverse">&#xf00d;</i>
						</span>
						<h1>Settings</h1>
						<form id="player-settings-form" method="post" action="{{ route('game.settings.save') }}" class="ajax" data-cb="settingsSaved">
							{!! csrf_field() !!}
							<table style="width: 100%;">
								<tr>
									<td>Amount of sparkles<small>
									<span class="fa-stack tooltip" title="The amount of sparkles when you hit a note. Lower value can increas performance. Default: 8">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-info fa-stack-1x t-black"></i>
									</span></small></td>
									<td style="width: 50%;">
										<div id="slider--max-sparkles"></div>
										<input type="hidden" value="{{$settings['player_burst_count']}}" name="player_burst_count" />
									</td>
									<td>
										<span id="slider-value--max-sparkles">
											{{ $settings['player_burst_count'] }}
										</span>
									</td>
								</tr>
								<tr>
									<td>Enable Cheering<small>
									<span class="fa-stack tooltip" title="Enabling this plays a cheering sound after defined streak intervals. Default: Yes">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-info fa-stack-1x t-black"></i>
									</span></small></td>
									<td style="width: 50%;">
										<input type="checkbox" value="1" name="player_enable_cheering" {{$settings['player_enable_cheering'] == 1 ? 'checked' : ''}} />
									</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>Cheering Volume<small>
									<span class="fa-stack tooltip" title="Volume of the cheering crowd (if enabled). Default: 0.5">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-info fa-stack-1x t-black"></i>
									</span></small></td>
									<td style="width: 50%;">
										<div id="slider--cheering-volume"></div>
										<input type="hidden" value="{{$settings['player_cheering_volume']}}" name="player_cheering_volume" />
									</td>
									<td>
										<span id="slider-value--cheering-volume">
											{{ $settings['player_cheering_volume'] }}
										</span>
									</td>
								</tr>
								<tr>
									<td>Render Mode<small>
									<span class="fa-stack tooltip" title="Render Mode to be used. Depending on hardware and OS the render mode you choose can affect performance in a good or bad way. People with good graphics cards might enjoy better performance with WebGL. Default: CANVAS">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-info fa-stack-1x t-black"></i>
									</span></small></td>
									<td style="width: 50%;">
										<select name="player_display_mode">
											<option value="CANVAS" {{ $settings['player_display_mode'] == 'CANVAS' ? 'selected' : '' }}>CANVAS</option>
											<option value="WEBGL" {{ $settings['player_display_mode'] == 'WEBGL' ? 'selected' : '' }}>WebGL</option>
											<option value="AUTO" {{ $settings['player_display_mode'] == 'AUTO' ? 'selected' : '' }}>Autodetect</option>
										</select>
									</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="3">
										<input type="submit" value="Save" class="btn bg-green" />
										<input type="button" value="Try" class="btn bg-blue tooltip" title="Doesn't save settings, so you can try them first." />
										<!--<input type="reset" value="Reset" class="btn bg-red" />-->
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<span style="display: none;" class="success">Settings saved successfully.</span>
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="small-12 medium-4 columns" style="padding-top:200px;padding-left:10px;">
			<h1 class="bg-blue">Like this?</h1>
			<p><a href="https://www.patreon.com/bePatron?u=3916023" data-patreon-widget-type="become-patron-button">Become a Patron!</a><script async src="https://c6.patreon.com/becomePatronButton.bundle.js"></script></p>
		</div>

		<div class="scoreBox right">
			<span id="score"></span> points<br />
			<span id="streak"></span> streak<br />
			x<span id="multiplier"></span>

			<a href="javascript:void(0);" onclick="rl.toggleFocus();return false;" class="force-reload focusToggle">
				<span class="fa-stack fa-lg">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-lightbulb-o fa-stack-1x fa-inverse"></i>
				</span>
			</a>
		</div>

		<script type="text/javascript">

		    var soundFiles = {!! json_encode($soundFiles) !!};
		    var song_slug = "{{ $song->slug }}";
		    var song_name = "{{ $song->title }}";
		    var artist_name = "{{ $artist->name }}";

		    var max_user_score = {{ $track->getUserScore() }};
		    var max_friend_score = {{ is_object($friendScore) ? $friendScore->score : 0 }};
		    var max_score = {{ $track->getHighscore() }};

		    @if($friendScore && $friendScoreData)
		      var friend_score_tracked =  JSON.parse('{!!$friendScoreData!!}').data;
		    @else
		      var friend_score_tracked = false;
		    @endif

		    var logo_url = "{{ asset('assets/images/frontend/logo-big-with-bg.png') }}";
		    var thumbnail_url = "{{$song->artist->getThumbnail(1200,800)}}";

			var ASSETS_BASE_URL = '{{url("")}}';
			var aNotes = null;

			var notes_count = {{ $track->getCount() }};

			var share_url = '{{ route('game.play', array('artist' => $song->artist->slug, 'song' => $song->slug, 'track' => $track->id, 'user_id' => $user->id)) }}?ref=fb_score';

			var share_title = '{{ $song->title }} by {{ $song->artist->name }} ({{$track->getDifficultyName()}}) | rocklegend';

			// end migration code

			var song_id = {{ $song->id }};

			var user_config = {
				lanes: {{ $track->lanes }},
				playbackRate: 1.0,
				buttonKeys: [
					false,
				@for($i = 1; $i <= 5; $i++)
			        {{ $settings['key_lane'.$i] }},
				@endfor
					13,
					16
				],
				buttonKeysAlt: [
					false,
				@for($i = 1; $i <= 5; $i++)
			        {{ $settings['key_alt_lane'.$i] }},
				@endfor
					13,
					16
				],
				restartKey: {{$settings['quick_restart']}},
				pxPerSecond: {{ $track->px_per_second }},
				mode: '{{ $settings['play_mode'] }}',
				maxNotes: {{ $settings['player_max_notes'] }},
				burstCount: {{ $settings['player_burst_count'] }},
				enableCheering: {{ $settings['player_enable_cheering']}},
				cheeringVolume: {{ $settings['player_cheering_volume']}},
    			displayMode: '{{$settings['player_display_mode']}}'
			}

			var testMode = {{ $test ? 1 : 0 }};
			var track_id = {{$track->id}};

			function lzw_decode(s) {
			    var dict = {};
			    var data = (s + "").split("");
			    var currChar = data[0];
			    var oldPhrase = currChar;
			    var out = [currChar];
			    var code = 256;
			    var phrase;
			    for (var i=1; i<data.length; i++) {
			        var currCode = data[i].charCodeAt(0);
			        if (currCode < 256) {
			            phrase = data[i];
			        }
			        else {
			           phrase = dict[currCode] ? dict[currCode] : (oldPhrase + currChar);
			        }
			        out.push(phrase);
			        currChar = phrase.charAt(0);
			        dict[code] = oldPhrase + currChar;
			        code++;
			        oldPhrase = phrase;
			    }
			    return out.join("");
			}
		</script>

		<div class="clear"></div>
	</div>
</div>
@endif
<div class="row">
	@if(!$isFacebook && Sentinel::inRole('admin'))
		<div class="small-12 columns text-center">
			<a href="{{ route('create.editor', array('song' => $track->song->slug, 'track' => $track->id, 'difficulty_id' => $track->difficulty)) }}">Edit track</a>
		</div>
	@endif
	<hr />
	<div class="medium-4 small-4 columns text-left">
		@include('game.partials.highscores', array('track' => $track))
	</div>
	<div class="medium-4 small-8 columns js-nscroll-parent">
		{!! $comments !!}
	</div>
	<div class="medium-4 small-12 columns js-nscroll">
		<h2 class="bg-green">More from this artist</h2>
		<div class="row">
			@include('artist.partials.header', array('facebook' => false))
			@include('artist.partials.meta_small')
			<div class="medium-12 columns">
				<p>{!!$artist->shortBio(150)!!}</p>
				<h3 class="bg-green">Songs</h3><br />
				@include('artist.partials.songs', array('autoopen' => false))
			</div>
		</div>
	</div>
</div>
@stop

@section('footer-scripts')
	{!! HTML::script('assets/js/plugins/howler.min.js') !!}
	{!! HTML::script('assets/js/plugins/phaser.min.js') !!}

	@if( App::environment() == 'development')
			{!! HTML::script('games/note-highway/develop/player/build/game.cat.js?t='.time()) !!}
	@else
		@if(file_exists(public_path().'/games/note-highway/develop/player/build/game.js'))
			{!! HTML::script('games/note-highway/develop/player/build/game.js?t='.time()) !!}
		@endif
	@endif

	<script type="text/javascript">
		var capture = null;
		var player_canvas = null;

		var mobile = false; //initiate as false
		// device detection
		if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
		    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4)))
			mobile = true;

		$(function(){
			playerPage.init();
			scores.init({{$track->id}});
		});
	</script>
@stop
