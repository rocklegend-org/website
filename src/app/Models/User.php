<?php

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

use Cmgmyr\Messenger\Traits\Messagable;

class User extends SentinelUser implements AuthenticatableContract, CanResetPasswordContract {
    use Messagable, SoftDeletes, Authenticatable, CanResetPassword;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	
	protected $fillable = [
			'email',
			'username',
			'password',
			'last_name',
			'first_name',
			'permissions',
	];
	protected $loginNames = ['username', 'email'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	public function badges()
	{
		return $this->hasMany('UserBadge');
	}

	public function settings()
	{
		return $this->hasMany('UserSetting');
	}

	public function notifications()
	{
		return $this->hasMany('Notification', 'recipient_id');
	}

	public function follows()
	{
		return $this->hasMany('Follower', 'stalker_user_id');
	}

	public function followers()
	{
		return $this->hasMany('Follower', 'followed_user_id');
	}

	public function scores()
	{
		return $this->hasMany('Score');
	}

	public function oldScores()
	{
		return $this->hasMany('OldScore');
	}

	public function tracks()
	{
		return $this->hasMany('Track');
	}

	public function getCountry()
	{
		return $this->belongsTo('Country', 'country');
	}

	public function throttleInfo()
	{
		return $this->hasOne('Cartalyst\Sentinel\Throttling\EloquentThrottle');
	}

	public function delete()
	{
		Score::where('user_id', $this->id)->delete();
		Track::where('user_id', $this->id)->update(array('user_id',1));

		return parent::delete();
	}

	public function getUID()
	{
		return md5($this->username.$this->id.$this->email.$this->password);
	}

	public function setting($settingName, $settingValue = null)
	{
		$cacheKey = $this->cacheKey($settingName);

		if (is_null($settingValue) && Cache::has($cacheKey)) {
			return Cache::get($cacheKey);
		}

		$setting = Setting::byName($settingName);

		$user_setting = UserSetting::currentUser()
						->name($settingName)
						->first();

		if(is_null($settingValue)){
			$value = null;

			if(is_null($user_setting) || $user_setting == false){
				$user_setting = new UserSetting;
				$user_setting->user_id = $this->id;
				$user_setting->setting_id = $setting->id;

				if($setting->constrained){
					$user_setting->allowed_setting_value_id = $setting->default_value;
					$value = $setting->scopeAllowedSettingDefaultValue()->first()->item_value;
				}else{
					$user_setting->unconstrained_value = $setting->default_value;
					$value = $setting->default_value;
				}

				$user_setting->save();

				return $value;
			}else{
				if($setting->constrained){
					return AllowedSettingValue::where('id',$user_setting->allowed_setting_value_id)->select('item_value')->first()->item_value;
				}else{
					return $user_setting->unconstrained_value;
				}
			}
		}else{
			Cache::forget($this->cacheKey($settingName));

			if(is_null($user_setting) || $user_setting == false)
			{
				$user_setting = new UserSetting();
				$user_setting->user_id = $this->id;
				$user_setting->setting_id = $setting->id;
			}

			if($setting->constrained){
				$user_setting->allowed_setting_value_id = $settingValue;
			}else{
				$user_setting->unconstrained_value = $settingValue;
			}

			$user_setting->save();

			return $settingValue;
		}
	}

	public function cacheKey($suffix)
	{
		return 'user.'.$this->id.'.'.$suffix;
	}

	public function settingsMap()
	{
		$settings = Setting::select('name')->get();

		$map = array();

		foreach($settings as $setting) {
			$map[$setting->name] = Cache::remember(
				$this->cacheKey($setting->name),
				30,
				function() use ($setting) {
					return $this->setting($setting->name);
				}
			);
		}

		return $map;
	}

	public function getFollowLink()
	{
		$html = View::make('profile.partials.followLink');
		$html->with('user', $this);
		$html->with('doesFollow', User::current()->id ? User::current()->doesFollow($this->id) : false);
		return $html->render();
	}

	public function doesFollow($userId){
		$followConnection = Follower::where('stalker_user_id',$this->id)->where('followed_user_id', $userId)->first();

		return count($followConnection) > 0 ? true : false;
	}

	public function scopeCurrent($query)
	{
		if(is_null(Sentinel::getUser())){
			return (object) array('id'=>false);
		}

		$userId = Sentinel::getUser()->id;
		$cachedUser = Cache::get('user.'.$userId);

		return is_null($cachedUser) ? Cache::remember('user.'.$userId, 1, function() use ($query, $userId) {
			return $query->where('id', $userId)
				->first();
		}) : $cachedUser;
	}

	public function profileUrl()
	{
		return route('profile', array('user' => $this->username));
	}

	public function badgesUrl()
	{
		return route('profile.badges', array('user' => $this->username));
	}

	public function hasBadge($badgeId)
	{
		$badge = UserBadge::where('user_id', $this->id)->where('badge_id', $badgeId)->first();
		return !is_null($badge);
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function setRememberToken($value)
	{

	}

	public function getRememberToken()
	{

	}

	public function getRememberTokenName() {

	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function addAvatarFromUpload($uploadedFile)
	{
		if( !is_null($uploadedFile) )
		{
			$img = Image::make($uploadedFile);

			$orientation = $img->exif('Orientation');

            if (!empty($orientation)) 
            {
                switch($orientation) {
                    case 8:
                        $img->rotate(90);
                        break;
                    case 3:
                        $img->rotate(180);
                        break;
                    case 6:
                        $img->rotate(-90);
                        break;
                }
            }

            $img->fit(70,70);
			$img->save($this->getAvatarsPath().$this->id.".png");

		//	return $img;
		}
	}

	public function getAvatarUrl()
	{
		if(File::exists(public_path().'/media/avatars/'.$this->id.'.png')){
			return url("").'/media/avatars/'.$this->id.'.png';
		}else{
			return url("").'/assets/images/frontend/default-avatar.png';
		}
	}

	public function getAvatarsPath()
	{
		return public_path().'/media/avatars/';
	}

	public function getPlayCountHistory($format = false)
	{
		$scores = new Score;

		$scores->where('user_id',$this->id);

		$scores = $scores->date('month')->orderBy('created_at', 'asc')->get();

		$scoresByDate = array();

		foreach($scores as $score)
		{
			$date = date('d/m', strtotime($score->created_at));
			
			if(!isset($scoresByDate[$date]))
			{
				$scoresByDate[$date] = 0;
			}

			$scoresByDate[$date]++;
		}
		
		$arr = array(
			'labels' => array(),
			'datasets' => array(
				array(
					'label' => 'Plays',
					'fillColor' => 'rgba(255,204,0,0.2)',
		            'strokeColor' => 'rgba(220,220,220,1)',
		            'pointColor' => 'rgba(255,204,0,1)',
		            'pointStrokeColor' => '#fff',
		            'pointHighlightFill' => '#fff',
		            'pointHighlightStroke' => 'rgba(220,220,220,1)',
		            'data' => array()
				)
			)
		);

		foreach($scoresByDate as $date => $count)
		{
			$arr['labels'][] = $date;
			$arr['datasets'][0]['data'][] = $count;
		}

		return json_encode($arr);
	}

	public function genderPronoun(){
		switch($this->gender){
			case 'male':
				return 'his';
			case 'female':
				return 'her';
			default:
				return 'his/her';
		}
	}
}