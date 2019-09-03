<?php 
use Illuminate\Database\Eloquent\SoftDeletes;

class SignupCode extends Eloquent {
    use SoftDeletes;

    protected $softDelete = true;

    protected $table = 'signup_codes';

    public function uses()
    {
    	return $this->hasMany('SignupCodeUse', 'signup_code_id');
    }

    public static function valid($code)
    {
        $code = self::where('code', $code)->first();
        if($code){
            if(strtotime($code->active_from) <= time() && strtotime($code->active_to) > time()){
                return true;
            }
        }
        
        return false;
    }

    public static function useCodeForUserId($user_id, $code)
    {
        $code = self::where('code', $code)->first();
        $code->used = true;        
        $code->save();

        $use = new SignupCodeUse;
        $use->signup_code_id = $code->id;
        $use->user_id = $user_id;
        $use->save();
    }

    public function hasLeft()
    {
        return $this->leftCount > 0;
    }

    public function leftCount()
    {
    	return $this->amount - $this->usedCount();
    }

    public function usedCount()
    {
        return count($this->uses);
    }
}