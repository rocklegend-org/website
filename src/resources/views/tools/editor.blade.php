@extends('layout')

@section('page_title')
Create a Track for {{ $song->title }} by {{ $song->artist->name }} | rocklegend
@overwrite

@section('content')
</div>
<div class="full play-wrapper--editor">

	<div class="large-player-background" style="background-image:url({{$song->getThumbnail(1200,900)}})">
		<div class="overlay"></div>
	</div>

	<div class="large-player-loading-overlay"></div>

	<div class="row editor-container">
		<div class="medium-1 column">
			&nbsp;
		</div>
		<div class="medium-3 columns">
			<h3>Various Editor Settings</h3>
			<label for="tracking">
				<input type="checkbox" value="1" name="tracking" id="trackingCB" checked="checked" /> Track Taps	
			</label>
			<label for="playTicks">
				<input type="checkbox" value="1" name="ticks" id="ticksCB" /> Play Ticks
			</label>
			<br />
			Note Distance: <span id="pxPerSecond"></span><br />
			<div id="slider-pxPerSecond"></div>

			<br />

			Playback Rate: <span id="playbackRate"></span><br />
			<div id="slider-playbackRate"></div>
			<small>1.0 = normal speed</small>

			<hr />

			<label for="auto-save">
				<input type="checkbox" value="1" name="auto-save" id="autoSaveCB" {{ $user->setting('autosave') ? 'checked="checked"' : '' }} />
				Auto-Save
			</label>

			<div id="auto-save-container" {{ !$user->setting('autosave') ? 'class="hide"' : '' }}>
				<p>Auto-Save Interval: <span id="auto-save-interval"></span></p>
				<div id="slider-autoSave"></div>
				<div id="auto-save-info" class="alert-box warning" style="display: none;"></div>
			</div>

			<hr />

			<div id="manual-save-info" class="alert-box warning" style="display: none;"></div>

			<label for="finish">
				<input type="button" class="bg-blue" id="btn-save" value="Save Progress!" />
				<input type="button" class="bg-green" id="btn-finish" value="Finish!" />
			</label>

			@if(isset($track))
			<br />
			<a href="{{ route('game.play.test', array('track' => $track->id )) }}" class="btn bg-violet" target="_blank">Test-Play (opens new window)</a>
			@endif
			
		</div>

		<div class="small-12 medium-4 columns text-center">
			<div class="row">
				<div id="note-editor" class="editor-container">
					<div id="main-canvas">
						<div class="gradient-top"></div>
						<div class="gradient-bottom"></div>
						<div class="loading-overlay">
							<p>
								<img src="{{asset('assets/images/frontend/logo-menu-button-transparent.png')}}" alt)"rocklegend player" />
								<br />
								loading rocklegend player
							</p>
						</div>
						<div class="button-overlay">
							@for($i = 1; $i <= $track->lanes; $i++)
								<span class="button-{{$i}}">
									{{chr($user->setting('key_lane'.$i))}}
								</span>
							@endfor
						</div>				
					</div>

					<div class="audio-controls">
						<small>Position:</small>
						<div id="slider-position">Initialising music...</div><br />
					</div>
				</div>
			</div>
		</div>

		<div class="small-12 medium-3 columns end">
			<h3>Note Details</h3>&nbsp;<span class="var-sel-count">0</span> selected <br />
			<small><a href="#" id="deselect-all">(unselect all)</a> </small>
			
			<!--<small id="previous-selection" style="display: block;"> | <a href="#"><i class="fa-square-o fa"></i> previous selection</a> </small>-->

			<small id="copy-selected" style="display: none;"> | <a href="#"><i class="fa-copy fa"></i> copy selected</a> </small>
			
			<small id="paste-copied" style="display: none;"> | <a href="#"><i class="fa-paste fa"></i> paste copied</a></small>
			<br />
			<small id="copy-info">no notes copied</small>
			<hr />
			<table>
				<tr>
					<td>
						<b>Time: <small>in ms</small></b>
					</td>
					<td>
						<input type="number" min="0" step="1" id="sel-note-time" value="-" readonly>
					</td>
				</tr>
				<tr>
					<td>
						<b>Duration: <small>in ms, min: 75</small></b>
					</td>
					<td>
						<input type="number" min="0" step="1" id="sel-note-duration" value="-" readonly>
					</td>
				</tr>
				<tr>
					<td>
						<b>Lane: <small>1-5</small></b>
					</td>
					<td>
						<input type="number" min="1" max="5" step="1" id="sel-note-lane" value="-" readonly>
					</td>
				</tr>
				<tr>
					<td>
						<b>HO/PO:</b>
					</td>
					<td>
 						<input type="checkbox" value="1" name="hopo" id="sel-note-hopo" readonly/>
					</td>
				</tr>
			</table>
			<hr />
			<div id="debug-container">
				<label for="current-time">Current Time
					<input type="text" disabled value="0.00" name="current-time" />
				</label>

				<button class="toggle-playback paused">Play/Pause</button>
				<button class="mute unmute">Mute Music</button>
			</div>

			<hr />

			<div id="advanced-options-container" class="">
				<input type="checkbox" value="1" id="toggleLines" /> Show Times
				<br />
				Grid:
				<select id="grid" class="tiny">
					<option value="0.5">2</option>
					<option value="0.25" selected="selected">4</option>
					<option value="0.125">8</option>
					<option value="0.0625">16</option>
					<option value="0.03125">32</option>
					<option value="0.015625">64</option>
				</select>
			</div>
		</div>
	</div>
	<div id="modal-errorMinimumNotes" class="reveal-modal tiny" data-reveal>
		<h1>An error occured.</h1>
		<div class="alert-box error">
			Please make sure to add at least 5 notes to your track before you save.</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>

	<script type="text/javascript">
	    var soundFiles = {!! json_encode($soundFiles) !!};
	    var song_slug = "{{ $song->slug }}";

		var ASSETS_BASE_URL = '{{url("")}}';
		var aNotes = {!! !is_null($track) ? json_encode($track->getNotesAsArray()) : '[[],[],[],[],[],[]]' !!};

		// migration code
		if(aNotes.length <= 5){
			aNotes.splice(0, 0, [false]);
		}
		// end migration code 
		
		var edit_mode = true;

		var user_config = {
			lanes: {{ $lanes }},
			mobile: {{ Agent::isMobile() ? 'true' : 'false' }},
			playbackRate: 1.0,
			buttonKeys: [
				false,
			@for($i = 1; $i <= 5; $i++)
		        {{ $user->setting('key_lane'.$i) }},
			@endfor
			],		
			destroyNotes: false,
			trackTaps: true,
			tickNoise: false,
			auto_save: {{ $user->setting('autosave') ? 'true' : 'false' }},
			auto_save_interval: {{ $user->setting('autosave_interval') != "" ? $user->setting('autosave_interval') : 30 }},
			pxPerSecond: {{ $track->px_per_second }}
		}
		
		var song_id = {{ $song->id }};

		@if(is_null($track))
			var track_id = 0;
		@else
			var track_id = {{$track->id}};
		@endif

		if(window.location.hash){
			track_id = window.location.hash.substring(1);

			user_config.fetchNotes = true;
		}
	</script>
</div>

<div class="row">
	<hr />
	<div class="medium-8 small-12 columns text-left">
		<h2 class="bg-blue">Track Settings</h2>
		<br />
		<div class="row">
			<div class="small-4 columns">
				<label for="status">State: <a href="javascript:void(0);" class="tooltip force-reload" title="Only 'Published' tracks are visible for other people than you. The 'Review' state is meant for an upcoming new feature where the community decides if the track should be published. Tracks with less than 100 notes can't be published automatically and have to be reviewed first.">(info)</a></label>
				<select name="status" {{ (isset($track) && $track->status == '2') ? 'disabled' : ''}}>
					<option value="0">-</option>
					@foreach(Config::get('game.trackstates') as $key => $state)
						@if($key != 2 || $user->official_tracker == 1)
							<option value="{{$key}}"
							{{isset($track) && $key==$track->status ? 'selected' : ''}}>{{Lang::get('game.trackstates.'.$state)}}</option>
						@endif
					@endforeach
				</select>
			</div>
			<div class="small-4 columns">
				<label for="difficulty">Difficulty:</label>
				<select name="difficulty" >
					@include('tools.partials.available_difficulties', array('tracks' => Track::where('song_id', $track->song_id)->where('status', 2)->get(), 'missing' => Song::find($track->song_id)->missingDifficulties(), 'default' => $track->difficulty))
				</select>
			</div>
			<div class="small-4 end columns">
				<label for="lanes">Lanes: <a href="javascript:void(0);" class="tooltip lanes ajax" title="In order to see the changed lane amount you have to click on save, then go back to tools and click edit on the song again.">(info)</a></label>
				<select name="lanes" >
					@for($i = 1; $i <= 5; $i++)
						<option value="{{$i}}"
							{{isset($track) && $i==$track->lanes ? 'selected' : ''}}>{{$i}}</option>
					}
					@endfor
				</select>			
			</div>
			<div class="small-6 end columns">
				<label for="status">Move all notes by x ms: <a href="javascript:void(0);" class="tooltip force-reload" title="">(info)</a></label>
				<input type="number" min="-100000" max="100000" name="move_notes_ms" style="float:left;width: 100px; margin-right: 10px;" value="0" />
				<a href="#" class="btn bg-blue" id="move_notes">Move!</a>
				<span id="notesUpdated">0</span> notes updated
			</div>
		</div>
	</div>
	<div class="medium-4 small-12 columns">
		<h2 class="bg-red">Track & Song Data</h2>
		<br />
		<strong>Duration:</strong> {{ $song->getDuration(false) }}
		<br />
		<strong>Play count:</strong> {{ isset($track) ? $track->scores()->count() : '0' }}
		<br />
		<strong>Note count:</strong> <span class="stats-notecount">{{ isset($track) ? $track->getCount() : '0' }}</span>
		<br />
		@if(User::current()->official_tracker || Sentinel::getUser()->inRole('admin')))
		<h2 class="bg-blue">Download</h2>
		<br />
		<a href="{{url('').$soundFiles[0]}}" target="_blank">{{$song->title}} - MP3</a>
		<br />
		<a href="{{url('').$soundFiles[1]}}" target="_blank">{{$song->title}} - OGG</a>
		@endif
	</div>
	<div class="clear">
	</div>
	<div class="small-12 columns">
		@include('tools.partials.midi')
	</div>
	<div class="small-12 columns" style="display: none;" id="error-debug">
		<textarea style="width: 100%; height: 400px;">

		</textarea>
	</div>
</div>
@stop

@section('footer-scripts')
	{!! HTML::script('assets/js/plugins/soundjs-0.6.1.min.js') !!}
	{!! HTML::script('assets/js/plugins/phaser.min.js') !!}

	@if( App::environment() == 'development')
			{!! HTML::script('games/note-highway/develop/editor/build/game.cat.js?t='.time()) !!}
	@else
		@if(file_exists(public_path().'/games/note-highway/develop/editor/build/game.js'))
			{!! HTML::script('games/note-highway/develop/editor/build/game.js?t='.time()) !!}
		@endif
	@endif

	<script type="text/javascript">
		$(function(){
			$('#pxPerSecond').html(RL.config.pxPerSecond);
			$('#playbackRate').html(RL.config.playbackRate);
		});
	</script>
@stop