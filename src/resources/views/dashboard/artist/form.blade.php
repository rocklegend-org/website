
<div class="col-md-4">
	<div class="inline-form">
		<label class="c-label">Artist name</label><input name="name" class="input-style" type="text" placeholder="Artist Name" value="{{ Input::old('name') ?: (isset($artist) ? $artist->name : '') }}">
		<p>This should be the name of the artist</p>
	</div>
</div>

<div class="col-md-4">
	<div class="inline-form">
		<label class="c-label">Artist Image (optional)</label>
		{!! Form::file('image', array('class' => 'input-style')) !!}
		<p>This image will shown as the artists thumbnail.</p>
	</div>
</div>
<div class="col-md-4">
	<div class="inline-form">
		<label class="c-label">Header Image (optional)</label>
		{!! Form::file('headerImage', array('class' => 'input-style')) !!}
		<p>This image will shown as the artists header image.</p>
	</div>
</div>
<div class="clear"></div>
<div class="col-md-4">
	<div class="inline-form">
		<label class="c-label">Founded Date</label><input name="founded_date" type="text" placeholder="Founded date" value="{{ Input::old('founded_date') ?: (isset($artist) ? $artist->founded_date : '') }}">
	</div>
	<div class="inline-form">
		<label class="c-label">Genre</label><input name="genre" type="text" placeholder="Genre" value="{{ Input::old('genre') ?: (isset($artist) ? $artist->genre : '') }}">
	</div>
	<div class="inline-form">
		<label class="c-label">Tags</label><input name="tags" type="text" placeholder="Genre" value="{{ Input::old('tags') ?: (isset($artist) ? $artist->tags : '') }}">
		<p>Comma (,) seperated list of tags for this artist (for search and search engines)</p>
	</div>
</div>
<div class="col-md-8">
	<div class="inline-form">
		<label class="c-label">Biography</label><textarea name="biography" class="input-style" placeholder="Biography" rows="13">{{ Input::old('biography') ?: (isset($artist) ? $artist->biography : '') }}</textarea>
		<p>Please provide a short biography of the artist.</p>
	</div>
</div>
<div class="clear"></div>

<hr />

<div class="col-md-3">
	<div class="inline-form">
		<label class="c-label">Facebook URL</label><input name="facebook_url" type="text" placeholder="Facebook URL" value="{{ Input::old('facebook_url') ?: (isset($artist) ? $artist->facebook_url : '') }}">
	</div>
</div>
<div class="col-md-3">
	<div class="inline-form">
		<label class="c-label">Twitter URL</label><input name="twitter_url" type="text" placeholder="Twitter URL" value="{{ Input::old('twitter_url') ?: (isset($artist) ? $artist->twitter_url : '') }}">
	</div>
</div>
<div class="col-md-3">
	<div class="inline-form">
		<label class="c-label">Youtube URL</label><input name="youtube_url" type="text" placeholder="Youtube URL" value="{{ Input::old('youtube_url') ?: (isset($artist) ? $artist->youtube_url : '') }}">
	</div>
</div>
<div class="col-md-3">
	<div class="inline-form">
		<label class="c-label">Youtube ID</label><input name="youtube_id" type="text" placeholder="Youtube ID" value="{{ Input::old('youtube_id') ?: (isset($artist) ? $artist->youtube_id : '') }}">
	</div>
</div>

<div class="clear"></div>


<div class="col-md-4">
	<div class="inline-form">
		<label class="c-label">Bandcamp URL</label><input name="bandcamp_url" type="text" placeholder="Bandcamp URL" value="{{ Input::old('bandcamp_url') ?: (isset($artist) ? $artist->bandcamp_url : '') }}">
	</div>
</div>
<div class="col-md-4">
	<div class="inline-form">
		<label class="c-label">iTunes URL</label><input name="itunes_url" type="text" placeholder="iTunes URL" value="{{ Input::old('itunes_url') ?: (isset($artist) ? $artist->itunes_url : '') }}">
	</div>
</div>
<div class="col-md-4">
	<div class="inline-form">
		<label class="c-label">Website URL</label><input name="website_url" type="text" placeholder="Website URL" value="{{ Input::old('website_url') ?: (isset($artist) ? $artist->website_url : '') }}">
	</div>
</div>
<hr />

