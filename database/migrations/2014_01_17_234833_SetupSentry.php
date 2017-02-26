<?php

use Illuminate\Database\Migrations\Migration;

class SetupSentry extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table) {
			$table->string('username')->after('email');
			$table->unique('username');
			$table->dropColumn('email');
			$table->softDeletes();
	    });

		Schema::table('users', function($table) {
	    	$table->string('email')->after('username')->unique()->nullable();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}