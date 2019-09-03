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

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(ResetSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BadgeSeeder::class);
        $this->call(SettingSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }
}
