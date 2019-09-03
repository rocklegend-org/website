<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptimizedTrackingColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->boolean('official_tracker')->nullable();
		});

		Schema::table('tracks', function($table)
		{
			$table->integer('play_count');
			$table->renameColumn('difficulty_id','lanes');
			$table->integer('difficulty')->default(5);
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
			$table->dropColumn('official_tracker');
		});

		Schema::table('tracks', function($table)
		{
			$table->dropColumn('play_count');
			$table->renameColumn('lanes','difficulty_id');
			$table->dropColumn('difficulty');
		});
	}

}
