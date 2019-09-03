<?php 
class SignupCodeUse extends Eloquent {

    protected $table = 'user_signup_codes';

    public function code()
    {
    	return $this->belongsTo('SignupCode', 'signup_code_id');
    }
}