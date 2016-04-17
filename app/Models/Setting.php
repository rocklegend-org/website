<?php 
class Setting extends Eloquent {

    protected $table = 'settings';

    public function allowedSettingValue()
    {
    	return $this->hasMany('AllowedSettingValue');
    }

    public function users()
    {
    	return $this->hasMany('User');
    }

    public function scopeAllowedSettingDefaultValue()
    {
    	return $this->allowedSettingValue()->where('id', $this->default_value);
    }
}