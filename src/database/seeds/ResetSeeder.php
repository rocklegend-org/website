<?php

use Illuminate\Database\Seeder;

class ResetSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		$tables = array('groups', 'throttle', 'users', 'users_groups');

		foreach ($tables as $table) {

			DB::table($table)->truncate();
		}

		$this->command->info('Database reset');
	}

}
