@if(User::current()->official_tracker || Sentinel::getUser()->inRole('admin'))

			<h2 class="bg-black">Upload MIDI</h2>
			<p>Choose a midi file (page refreshes automatically - all unsaved changes will be lost).<br />
			<br />
			<input id="midiupload" type="file" name="midi">
			@if($song->hasMidi())
			<section id="midi-tracks">
				<a href="#" class="ajax analyze">Analyze Midi</a>
			</section>
			@endif

			@section('footer-scripts')
			@parent
			{!! HTML::script('assets/js/plugins/jquery-fileupload/js/jquery.iframe-transport.js')!!}
			{!! HTML::script('assets/js/plugins/jquery-fileupload/js/jquery.fileupload.js')!!}
			<script type="text/javascript">
			$(function(){
				var midi_upload_url = '{{ url('/tools/upload-midi/'.(isset($track) ? $track->id : 'new')).'?slug='.$song->slug }}';
			    $('#midiupload').fileupload({
			        url: midi_upload_url,
			        dataType: 'json',
			        formData: { _token: csrf },
			        success: function (e, data) {
			        	if(typeof(e.track) != 'undefined'){
			        		location.href = '/create/editor/'+e.song+'/'+e.lanes+'/'+e.track;
			        	}
			        },
			        progressall: function (e, data) {
			            
			        }
			    }).prop('disabled', !$.support.fileInput)
			        .parent().addClass($.support.fileInput ? undefined : 'disabled');

			     $('#midi-tracks a.analyze').on('click', function(e){
			     	e.preventDefault();

			     	$(this).replaceWith('<span class="analyze">Analyzing midi file. Please wait...</span>');

			     	$.get('{{url('/tools/analyze-midi/'.$song->slug)}}', { song: '{{$song->slug}}' },function(data){
			     			$('#midi-tracks .analyze').replaceWith('Choose a track:<br />')
			     			$.each(data.possible_tracks, function(i, v){
			     				$('#midi-tracks').append((i+1)+'.: <a href="/tools/select-midi-track/'+i+'/{{isset($track) ? $track->id : 0}}" class="choose-midi-track">'+v+' Notes</a><br />');
			     			});
			     	});
			     });

			     $(document).on('click', '.choose-midi-track', function(e){
			     	e.preventDefault();

			     	if(confirm('If you select this track all existing data of the current track will be overwritten. Are you sure you want to do this?')){
			     		location.href = $(this).attr('href');
			     	}

			     });
			});
			</script>
			@append
		@else
			To import midi files, request "official tracker" status in the forum, on facebook or via twitter.
		@endif