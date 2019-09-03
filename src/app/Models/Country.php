<?php

class Country extends Eloquent {

	protected $table = 'countries';

    protected $softDelete = false;

	public function users()
	{
		return $this->hasMany('User', 'country');
	}

	public static function getList($default = false, $print = false)
	{
		$countries = Country::get();

		$html = '';
		foreach($countries as $country){
			$html .= '<option value="'.$country->id.'">'.$country->name.'</option>';
		}

		if($print){
			echo $html;
			return true;
		}
		
		return $html;
	}
}