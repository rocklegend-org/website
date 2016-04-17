<?php

use Helper\RLString;

class Resource extends Model {

    /**
     * Listen for save event
     */
    protected static function boot()
    {
        static::saving(function($model)
        {
            $model->setUniqueSlug($model);
            $model->setHashOnce($model);
            return $model->validate();
        });

        parent::boot();
    }

    public function setUniqueSlug( $model, $force = false)
    {
        $refString = null;
        $refString = isset($model->name) ? $model->name : $refString;
        $refString = isset($model->title) ? $model->title : $refString;

        if($model->slug != '' && !is_null($model->slug) && !$force){
           return;
        }

        if(is_null($refString))
        {
            return;
        }

        $model->slug = RLString::normalize($refString);

        // check that slug was not taken yet and randomize if necessary
        $validator = Validator::make(
            $model->toArray(),
            array( 'slug' => 'unique:'.$model->table )
        );
        if($validator->fails())
        {
            $model->slug = RLString::normalize($refString).'-'.sprintf('%1$04d', mt_rand(10000,99999));
        }

        return $model;
    }

    public function setHashOnce($model)
    {
        if(is_null($model->hash))
        {
            $model->hash = md5(uniqid(mt_rand(), TRUE));
        }
    }

    public function getThumbnail($filePath, $width, $height)
    {
        $dir = pathinfo($filePath, PATHINFO_DIRNAME);
        $filename = pathinfo($filePath, PATHINFO_FILENAME);

        if(!file_exists($dir)){
            return 'http://placehold.it/'.$width.'x'.$height.'&text='.$this->name;
        }

        if(!file_exists($dir.'/thumbnails/'.$filename.'_'.$width.'_'.$height.'.jpg')){
            if(!file_exists($dir.'/thumbnails')) mkdir($dir.'/thumbnails');
            Image::make($filePath)
                ->fit($width, $height)
                ->save($dir."/thumbnails/".$filename."_".$width."_".$height.".jpg");
            return asset(str_replace(public_path(),'',$dir)."/thumbnails/".$filename."_".$width."_".$height.".jpg");
        }else{
            return asset(str_replace(public_path(),'',$dir)."/thumbnails/".$filename."_".$width."_".$height.".jpg");
        }
    }

}
