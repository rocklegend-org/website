@extends('layout')

@section('content')

<div class="login">

	<div class="small-12 medium-6 columns medium-centered">

		<div class="row">

			<div class="small-12 columns">

				<h2>Create a new track for a song</h2>

				{!! Form::open(array('route' => 'create.track', 'id' => 'form-new-track', 'files' => true)) !!}
					<div class="row">
						<div class="medium-12 columns">
							<label for="song_title">
								Song:
								{!! Form::select('song_id', $song_list) !!}
							</label>
						</div>
						<div class="clear"></div>
						<div class="medium-8 columns">
							<label for="audio_file">
								I want to track this difficulty:
								<select name="difficulty_id">
									@include('tools.partials.available_difficulties', array('tracks' => Track::where('song_id', key($song_list))->where('status', 2)->get(), 'missing' => Song::find(key($song_list))->missingDifficulties()))
								</select>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="medium-12 columns">
							{!! Form::submit('Create!'); !!}
						</div>
					</div>
				{!! Form::close() !!}
			
			</div>

		</div>

	</div>

</div>

@stop

@section('footer-scripts')
	<script type="text/javascript">
		$(function(){
			$('select[name="song_id"]').on('change', function(){
				$('select[name="difficulty_id"]').hide();
				$('#form-new-track input[type="submit"]').hide();
				$('#form-new-track').prop('disabled', true);
				$.ajax({
					type: 'post',
					url: '{{route('track.missingDifficulties')}}',
					data: { song_id: $('select[name="song_id"] option:selected').val()}, 
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
					},
					success: function(html){
						$('select[name="difficulty_id"]').html(html).show();
						$('#form-new-track input[type="submit"]').show();
						$('#form-new-track').prop('disabled', false);
					}
				});
			});
		});
	</script>
@stop