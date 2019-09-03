
	<div class="col-md-4">
		<div class="inline-form">
			<label class="c-label">Song Title</label><input name="song_title" class="input-style" type="text" placeholder="Song Title" value="{{ Input::old('song_title') ?: (isset($song) ? $song->title : '') }}">
			<p>This should be the title of the song</p>
		</div>
	</div>
	<!-- TODO: implement autosuggest for artists -->
	<div class="col-md-4">
		<div class="inline-form">
			<label class="c-label">Artist Name</label><input name="artist_name" class="input-style" type="text" placeholder="Artist Name" value="{{ Input::old('artist_name') ?: (isset($song) && !is_null($song->artist) ? $song->artist->name : '') }}">
			<p>Enter the exact artist name.</p>
		</div>
	</div>
	<div class="col-md-4">
		<div class="inline-form">
			<label class="c-label">Album Title (optional)</label><input name="album_title" type="text" placeholder="Album Title" value="{{ Input::old('album_title') ?: (isset($song) && !is_null($song->album) ? $song->album->title : '') }}">
			<p>If you know it, put the title of the album here.</p>
		</div>
	</div>
	<div class="clear"></div>

	<div class="col-md-4">
		<div class="inline-form">
			<label class="c-label">Song Artwork (optional)</label>
			{!! Form::file('song_artwork', array('class' => 'input-style')) !!}
			<p>This image will shown as the song's thumbnail.</p>
		</div>
	</div>
	<div class="col-md-4">
		<div class="inline-form">
			<label class="c-label">Song MP3</label>
			{!! Form::file('song_mp3', array('class' => 'input-style')) !!}
		</div>
	</div>

	<div class="col-md-4">
		<div class="inline-form">
			<label class="c-label">Song MIDI</label>
			{!! Form::file('song_midi', array('class' => 'input-style')) !!}
			<p>Upload a MIDI File if you already have a tapped version of the song.</p>
		</div>
	</div>
	<div class="clear"></div>

	<div class="col-md-4 col-sm-6">
		<label class="c-label">Status</label>
		<select name="status" class="form-control">
			@foreach(Config::get('game.songstates') as $key => $state)
				<option value="{{$key}}"
					{{isset($song) && $key==$song->status ? 'selected' : ''}}>{{Lang::get('game.songstates.'.$state)}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-2 col-xs-6">
			<label class="c-label">Trackable</label>
			<div class="clearfix"></div>
				<input type="checkbox" value="true" name="trackable" {{Input::old('trackable') ?: (isset($song) && $song->trackable) ? 'checked="checked"' : ''}}>
		</div>
	</div>
	<div class="clear"></div>
	<div class="col-md-4">
	{!! Form::submit(isset($song) ? 'Update' : 'Create', array('class' => 'buttonFinish btn green btn-primary')) !!}
	</div>