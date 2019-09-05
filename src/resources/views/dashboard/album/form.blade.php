
<div class="col-md-4">
	<div class="inline-form">
		<label class="c-label">Album name</label><input name="title" class="input-style" type="text" placeholder="Album Name" value="{{ Input::old('title') ?: (isset($album) ? $album->title : '') }}">
		<p>This should be the name of the album</p>
	</div>
</div>
<div class="clear"></div>

<hr />