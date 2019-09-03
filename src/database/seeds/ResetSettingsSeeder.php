<?php

use Illuminate\Database\Seeder;

class ResetSettingsSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		$tables = array('settings');

		foreach ($tables as $table) {

			DB::table($table)->truncate();
		}

		//$this->command->info('Settings database reset');
	}

}
