<?php
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Resource {
	use SoftDeletes;
	
	protected $table = 'albums';

    protected $softDelete = true;

    protected $fillable = array(
        'artist_id',
        'title',
    );

    protected static $rules = array(
        'title' => 'required',
    );

	public function artist()
	{
		return $this->belongsTo('Artist')->withTrashed();
	}

	public function songs()
	{
		return $this->hasMany('Song')->withTrashed();
	}
}