<?php

class AllowedSettingValue extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'allowed_setting_values';

	public function setting()
	{
		return $this->hasOne('Setting');
	}
}