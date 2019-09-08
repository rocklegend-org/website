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

    public static function byName(string $name) {
        return Cache::remember('setting.'.$name, 3600, function() use ($name) {
            return Setting::where('name', $name)
                ->first();
        });
    }
}