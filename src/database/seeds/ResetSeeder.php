<?php

use Illuminate\Database\Seeder;

class ResetSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		$tables = array('roles', 'throttle', 'users', 'role_users');

		foreach ($tables as $table) {

			DB::table($table)->truncate();
		}

		$this->command->info('Database reset');
	}

}
