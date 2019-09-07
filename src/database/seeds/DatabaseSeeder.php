<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $isDev = env('APP_ENV', 'production') === 'development';

        if ($isDev) {
            $this->call(ResetSeeder::class);
        }

        $this->call(PermissionSeeder::class);
        
        if ($isDev) {
            $this->call(UserSeeder::class);
        }

        $this->call(BadgeSeeder::class);
        $this->call(SettingSeeder::class);

        Model::reguard();
    }
}
