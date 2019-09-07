<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        $default_settings = Config::get('user_settings');

        foreach($default_settings as $default_setting){
            $setting = Setting::byName($default_setting['name']);

            if (is_null($setting)) {
                $setting = new Setting;
            }

            $setting->fill($default_setting)->save();
        }
    }
}