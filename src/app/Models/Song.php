<?php
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Resource {
	use SoftDeletes;

	const MEDIA_FOLDER = 'media/songs';
	const MEDIA_FOLDER_ROOT = 'media';
	const FFMPEG_DIR = '/resources/binaries/ffmpeg/';

	protected $table = 'songs';

    protected $softDelete = true;

    protected $fillable = array(
        'title',
    );

    protected static $rules = array(
        'title' => 'required',
    );


	public function artist()
	{
		return $this->belongsTo('Artist')->withTrashed();
	}

	public function album()
	{
		return $this->belongsTo('Album')->withTrashed();
	}

	public function tracks()
	{
		return $this->hasMany('Track')->withTrashed();
	}

	public function delete()
	{
		Track::where('song_id', $this->id)->delete();

		return parent::delete();
	}

	public function hasAllTracks()
	{
		$tracks = Track::where('song_id', $this->id)->where('status', 2)->where('deleted_at', null)->get();

		$difficulties = array(0,0,0,0,0,0);

		foreach($tracks as $track){
			$difficulties[$track->difficulty]++;
		}

		if(	$difficulties[2] > 0 && 
			$difficulties[3] > 0 && 
			$difficulties[4] > 0 && 
			$difficulties[5] > 0)
		{
			return true;
		}

		return false;
	}

	public function missingDifficulties()
	{
		$tracks = Track::where('song_id', $this->id)->where('status', 2)->where('deleted_at', null)->get();

		$difficulties = array(0,0,0,0,0,0);
		$missing = array();

		foreach($tracks as $track){
			$difficulties[$track->difficulty]++;
		}

		foreach($difficulties as $difficulty_id => $count)
		{
			if($difficulty_id >= 2 && $count <= 0){
				$missing[] = $difficulty_id;
			}
		}

		return $missing;
	}

	public function availableDifficulties()
	{
		$tracks = Track::where('song_id', $this->id)
					->where('status', 2)
					->where('deleted_at', null)
					->get();
		return $tracks;
	}

	public function hasMidi()
	{
		if(file_exists($this->getMediaPublicPath().'tapped.midi')){
			return true;
		}
		
		return false;
	}

	public function getMidi()
	{
		if($this->hasMidi())
		{
			return $this->getMediaPublicPath().'tapped.midi';
		}

		return false;
	}

	public function addMusicFileFromUpload( $uploadedFile, $autoConvert = true )
	{
		// TODO: ensure that existing files don't get overwritten
		// TODO: maybe try catch this

		if( !is_null($uploadedFile) )
		{
			switch(PHP_OS){
				case 'Darwin': $ffmpeg_bin = 'ffmpeg_osx'; break;
				case 'Linux': $ffmpeg_bin = 'ffmpeg_linux'; break;
				case 'Windows': $ffmpeg_bin = 'ffmpeg_windows.exe'; break;
				default: $autoConvert = false; break;
			}

			$ext = $uploadedFile->getClientOriginalExtension();

			if($autoConvert){
				$r = $uploadedFile->move($this->getMediaPublicPath(), "original.".$ext);

				exec(base_path().self::FFMPEG_DIR.$ffmpeg_bin.' -i '.$this->getMediaPublicPath().'original.'.$ext.' -f mp3 '.$this->getMediaPublicPath().'audio.mp3 2>&1', $debug_mp3);
				exec(base_path().self::FFMPEG_DIR.$ffmpeg_bin.' -i '.$this->getMediaPublicPath().'original.'.$ext.' -f ogg  '.$this->getMediaPublicPath().'audio.ogg 2>&1', $debug_ogg);

			}else{
				$r = $uploadedFile->move($this->getMediaPublicPath(), "audio.".$ext);
			}

			return $r;
		}
	}

	public function addMidiFileFromUpload( $uploadedFile )
	{
		if( !is_null($uploadedFile) )
		{
			return $uploadedFile->move($this->getMediaPublicPath(), "tapped.midi");
		}
	}

	public function addArtworkFileFromUpload( $uploadedFile )
	{
		if( !is_null($uploadedFile) )
		{
			$r = $uploadedFile->move($this->getMediaPublicPath(), "artwork.".$uploadedFile->getClientOriginalExtension());
			if($uploadedFile->getClientOriginalExtension() != 'jpg'){
				Image::make($this->getMediaPublicPath()."artwork.".$uploadedFile->getClientOriginalExtension())
							->save($this->getMediaPublicPath()."artwork.jpg");
			}
			return $r;
		}
	}

	public function getMediaPath()
	{
		return '/'.self::MEDIA_FOLDER.'/'.$this->id.'/';
	}

	public function getMediaPublicPath()
	{
		return public_path().$this->getMediaPath();
	}

	public function getArtwork()
	{
		return asset($this->getMediaPath().'artwork.jpg');
	}
	
	public function getThumbnail($width, $height, $file = 'artwork.jpg')
	{
		$filePath = $this->getMediaPublicPath().'artwork.jpg';
		if(!file_exists($filePath)){
			return $this->artist->getThumbnail($width, $height);
		}
		return parent::getThumbnail($filePath, $width, $height);
	}

	public function getTracks()
	{
		return $this->tracks()->with('user')->where('status', 2)->whereNull('deleted_at')->orderBy('difficulty', 'ASC')->get();
	}

	public function getTrackForDifficulty($difficulty_id)
	{
		return $this->tracks()->where('status', 2)->whereNull('deleted_at')->where('difficulty', $difficulty_id)->first();
	}

	public function getSoundFiles()
	{		
		$mediaPath = $this->getMediaPath();
		$songFilename = 'audio';
		$songBasePath = $mediaPath.$songFilename;

		$songBasePathCompressed = $mediaPath.$songFilename.'-compressed';

		//  Firefox doesn't support mp3 files, so use ogg
		$formats = array('mp3','ogg');

		$artistMediaBaseUrl = 'media/';

		$soundFiles = array();
		$soundFilesCompressed = array();

		foreach($formats as $format)
		{
			$soundFiles[] = $songBasePath.'.'.$format;

			if(!file_exists($this->getMediaPublicPath().$songFilename.'-compressed.'.$format)){			
				switch(PHP_OS){
					case 'Darwin': $ffmpeg_bin = 'ffmpeg_osx'; break;
					case 'Linux': $ffmpeg_bin = 'ffmpeg_linux'; break;
					case 'Windows': $ffmpeg_bin = 'ffmpeg_windows.exe'; break;
					default: $autoConvert = false; break;
				}

				$source = $this->getMediaPublicPath().'audio.mp3';
				$target = $this->getMediaPublicPath().'audio-compressed.'.$format;

				if($format == 'mp3'){
					$result = exec(base_path().self::FFMPEG_DIR.$ffmpeg_bin." -i ".$source.' -f '.$format.' -b:a 96k -ac 1 -ar 44100 '.$target);
				}else{
					$result = exec(base_path().self::FFMPEG_DIR.$ffmpeg_bin.' -i '.$this->getMediaPublicPath().'audio-compressed.mp3 -f ogg  '.$this->getMediaPublicPath().'audio-compressed.ogg 2>&1', $debug_ogg);
				}
			}
			$soundFilesCompressed[] = $songBasePathCompressed.'.'.$format;
		}

		return $soundFilesCompressed;
	}

	public function getDuration($iso = true)
	{
		if($this->duration == ''){			
			switch(PHP_OS){
				case 'Darwin': $ffmpeg_bin = 'ffmpeg_osx'; break;
				case 'Linux': $ffmpeg_bin = 'ffmpeg_linux'; break;
				case 'Windows': $ffmpeg_bin = 'ffmpeg_windows.exe'; break;
				default: $autoConvert = false; break;
			}

			$mp3 = $this->getMediaPublicPath().'audio.mp3';
			$command = base_path().self::FFMPEG_DIR.$ffmpeg_bin." -i ".$mp3.' 2>&1 | grep -o \'Duration: [0-9:.]*\'';

			$result = shell_exec($command);
	        $duration = str_replace('Duration: ', '', $result); // 00:05:03.25

			$duration = explode(":",$duration);
	        $seconds = explode(".",$duration[2]);
	        
	        $this->duration_iso = 'PT'.ltrim($duration[1],'0').'M'.ltrim($seconds[0],'0').'S';
	        $this->duration = $duration[1].':'.substr($duration[2], 0, strpos($duration[2], '.'));
	        $this->save();

			return 'PT'.ltrim($duration[1],'0').'M'.ltrim($seconds[0],'0').'S';
		}else{
			return $iso ? $this->duration_iso : substr($this->duration, 0, strpos($this->duration, '.'));
		}
	}

	public function getStatusName()
	{
		return Lang::get('game.songstates.'.Config::get('game.songstates.'.$this->status));
	}

	public function playCount()
	{
		if(Cache::has('song_'.$this->id.'_playcount'))
		{
			return Cache::get('song_'.$this->id.'_playcount');
		}
		else{
			$tracks = $this->getTracks();

			$scores = 0;
			foreach($tracks as $track)
			{
				$scores += $track->scores()->count();
			}

			Cache::put('song_'.$this->id.'_playcount', $scores, 900);

			return $scores;
		}
	}

}