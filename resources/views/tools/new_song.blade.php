@extends('layout')

@section('content')

<div class="login">

	<div class="small-12 medium-6 columns medium-centered">

		<div class="row">

			<div class="small-12 columns">

				<h2>Create a new song</h2>

				{{ Form::open(array('route' => 'create.song', 'id' => 'form-new-song', 'files' => true)) }}
					<div class="row">
						<div class="medium-12 columns">
							<label for="song_title">
								Song Title
								<input type="text" value="" name="song_title" />
							</label>
						</div>
						<div class="medium-12 columns">
							<label for="artist_name">
								Artist Name
								<input type="text" value="" name="artist_name" />
							</label>
						</div>
						<div class="medium-12 columns">
							<label for="audio_file">
								Audio File
								{{ Form::file('audio_file'); }}
							</label>
						</div>
						<div class="clear"></div>
						<div class="medium-8 columns">
							<label for="audio_file">
								I want to track this amount of lanes:
								<select name="lanes">
									<?php
										for($l = 1; $l <= (Agent::isMobile() ? 3 : 5); $l++){
									?>
										<option value="{{ $l }}" {{ Agent::is('mobile') ? ($l == 3 ? 'selected' : '') : ($l == 5 ? 'selected' : '') }}>{{ $l }}</option>
									<?php
										}
									?>
								</select>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="medium-12 columns">
							{{ Form::submit('Create!'); }}
						</div>
					</div>
				{{ Form::close() }}
			
			</div>

		</div>

	</div>

</div>

<!-- Feedbackify -->
<script type="text/javascript">
	var fby = fby || [];
	fby.push(['showTab', {id: '7494', position: 'right', color: '#2c2c2c'}]);
	(function () {
	    var f = document.createElement('script'); f.type = 'text/javascript'; f.async = true;
	    f.src = '//cdn.feedbackify.com/f.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(f, s);
	})();
</script>

@stop