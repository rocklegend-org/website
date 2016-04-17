<?php

use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function($table) {
			$table->increments('id');
			$table->string('code');
			$table->string('name');
		});

		Artisan::call('db:seed', array('--class' => 'CountriesTableSeeder'));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('countries');
	}

}