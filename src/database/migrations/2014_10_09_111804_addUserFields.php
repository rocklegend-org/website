<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->text('bio');
			$table->string('country');
			$table->string('city');
			$table->date('birthday')->nullable();
			$table->text('favorite_bands');
			$table->text('instruments_played');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
			$table->dropColumn(array('bio', 'country', 'city', 'birthday', 'favorite_bands', 'instruments_played'));
		});
	}

}
