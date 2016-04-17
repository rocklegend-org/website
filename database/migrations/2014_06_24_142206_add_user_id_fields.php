<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('songs', function($table)
		{
		    $table->unsignedInteger('user_id')->nullable();
		});

		Schema::table('notes', function($table)
		{
		    $table->unsignedInteger('user_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{		
		Schema::table('songs', function($table)
		{
		    $table->dropColumn('user_id');
		});

		Schema::table('notes', function($table)
		{
		    $table->dropColumn('user_id');
		});
	}

}
