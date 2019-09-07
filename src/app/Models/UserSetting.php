<?php 
class UserSetting extends Eloquent {

    protected $table = 'user_settings';

    public function user()
    {
    	return $this->belongsTo('User');
    }

    public function setting()
    {
    	return $this->belongsTo('Setting');
    }

    public function scopeCurrentUser($query)
    {
    	return $query->where('user_id',Sentinel::getUser()->id);
    }

    public function scopeName($query, $name)
    {
    	$setting = Setting::where('name',$name)->first();

    	return $query->where('setting_id', $setting->id);
    }
}