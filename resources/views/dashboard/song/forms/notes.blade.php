<div class="col-md-12">
	<div class="inline-form">
		<p>These are all available tracks for this song.</p>
		<table class="table table-striped table-bordered" style="width: auto;">
			<thead>
				<tr>
					<th>Status</th>
					<th>Tracker</th>
					<th>Play Count</th>
					<th>Note Count</th>
					<th>Lanes</th>
					<th>Difficulty</th>
					<th width="160">Actions</th>
				</tr>
			</thead>
			<tbody>
				@if(sizeof($tracks) > 0)
				@foreach($tracks as $track)
				<tr>
					<td>
						<select name="status[{{$track->id}}]" class="form-control">
							@foreach(Config::get('game.trackstates') as $key => $state)
								<option value="{{$key}}"
									{{$key==$track->status ? 'selected' : ''}}>{{Lang::get('game.trackstates.'.$state)}}</option>
							@endforeach
						</select>
					</td>
					<td>{{$track->user->username}}</td>
					<td>
						@if($track->scores()->date('month')->count() > 0)
							<canvas id="play_count_{{$track->id}}" width="150" height="80"></canvas>
							<script type="text/javascript">
								var data_{{$track->id}} = {{$track->getPlayCountHistory('js')}};

								var ctx_{{$track->id}} = document.getElementById("play_count_{{$track->id}}").getContext("2d");
								var chart_{{$track->id}} = new Chart(ctx_{{$track->id}}).Line(data_{{$track->id}},{animation:false});
							</script>
						@else 
							0
						@endif
					</td>
					<td>{{$track->getCount()}}</td>
					<td>{{$track->lanes}}</td>
					<td>{{$track->getDifficultyName()}} | {{$track->difficulty}}</td>
					<td>
						<a href="{{ route('game.play', array('artist' => $track->song->artist->slug, 'song' => $track->song->slug, 'track' => $track->id)) }}?ref=dashboard" target="_blank" class="btn yellow m-sml-btn">Play</a>
						<a href="{{ route('dashboard.track.destroy', array('id' => $track->id)) }}" data-method="DELETE" class="btn m-sml-btn pink" data-confirm="Are you sure you want to delete this?"><i class="fa fa-trash-o"></i> Delete</a>
					</td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
		{!! Form::submit('Update', array('class' => 'buttonFinish btn green btn-primary')) !!}
</div>

