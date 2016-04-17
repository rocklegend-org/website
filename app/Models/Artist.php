<?php
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Resource {
	use SoftDeletes;
	
	protected $table = 'artists';

    protected $softDelete = true;

    protected $fillable = array(
        'name',
        'founded_date',
        'biography',
        'genre',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'youtube_id',
        'bandcamp_url',
        'itunes_url',
        'website_url',
        'tags'
    );

    protected static $rules = array(
        'name' => 'required',
    );

	public function songs()
	{
		return $this->hasMany('Song');
	}

	public function albums()
	{
		return $this->hasMany('Album');
	}

	public function addArtworkFileFromUpload($uploadedFile, $name = 'artwork')
	{
		if( !is_null($uploadedFile) )
		{
			$r = $uploadedFile->move($this->getMediaPublicPath(), $name.".".$uploadedFile->getClientOriginalExtension());
			if($uploadedFile->getClientOriginalExtension() != 'jpg'){
				Image::make($this->getMediaPublicPath().$name.".".$uploadedFile->getClientOriginalExtension())
							->save($this->getMediaPublicPath().$name.".jpg");
				unlink($this->getMediaPublicPath().$name.'.'.$uploadedFile->getClientOriginalExtension());
			}
			array_map('unlink', glob($this->getMediaPublicPath().'thumbnails/*.jpg'));
			return $r;
		}
	}

	public function getArtwork($name = 'artwork')
	{
		return asset('/media/artists/'.$this->id.'/'.$name.'.jpg');
	}

	public function getThumbnail($width, $height, $file = 'artwork')
	{
		$filePath = $this->getMediaPublicPath().$file.'.jpg';
		if(!file_exists($filePath)){
			$filePath = $this->getMediaPublicPath().'artwork.jpg';
		}
		return parent::getThumbnail($filePath, $width, $height);
	}

	public function getMediaPublicPath()
	{
		return public_path().'/media/artists/'.$this->id.'/';
	}

	public function shortBio($length = 255, $moreLink = true, $replaceQuotes = false)
	{
		$string = strip_tags($this->biography);

		if (strlen($string) > $length) {

		    // truncate string
		    $stringCut = substr($string, 0, $length);

		    // make sure it ends in a word so assassinate doesn't become ass...
		    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'.($moreLink ? ' <a href="'.route('artist.show', array('artist' => $this->slug)).'">Read More</a>' : ''); 
		}

		if($replaceQuotes){
			$string = str_replace('"', "'", $string);
		}
		return $string;
	}

	public function hasTracks()
	{
		$songs = $this->songs;

		$countTracks = 0;

		foreach($songs as $song)
		{
			if(count($song->availableDifficulties()) > 0){
				$countTracks++;
			}
		}

		return $countTracks > 0 ? true:false;
	}

	public function playCount()
	{
		$count = 0;
		foreach($this->songs as $song)
		{
			$count += $song->playCount();
		}
		return $count;
	}
}