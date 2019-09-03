<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        $reset = new ResetSettingsSeeder;
        $reset->run();

        $default_settings = Config::get('user_settings');

        foreach($default_settings as $default_setting){
            $setting = new Setting;

            $setting->fill($default_setting)->save();
        }
    }
}