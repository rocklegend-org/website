<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHighscoreInfos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('highscores', function($table)
		{
			$table->string('play_mode');
			$table->text('keylog');
			$table->integer('reload_count');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('highscores', function($table)
		{
			$table->dropColumn('play_mode');
			$table->dropColumn('keylog');
			$table->dropColumn('reload_count');
		});
	}

}
