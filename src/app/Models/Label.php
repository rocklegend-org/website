<?php
use Illuminate\Database\Eloquent\SoftDeletes;

class Label extends Resource {
	use SoftDeletes;

	protected $table = 'labels';

	protected $softDelete = true;

    protected $fillable = array(
        'name',
    );

    protected static $rules = array(
        'name' => 'required',
    );

}