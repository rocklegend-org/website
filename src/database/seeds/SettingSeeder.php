<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        $default_settings = Config::get('user_settings');

        foreach($default_settings as $default_setting){
            $setting = Setting::where('name', $default_setting['name'])->first();

            if (is_null($setting)) {
                $setting = new Setting;
            }

            $setting->fill($default_setting)->save();
        }
    }
}