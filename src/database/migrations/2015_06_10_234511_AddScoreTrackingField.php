<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScoreTrackingField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('highscores', function($table){
			$table->longText('tracked_score');
		});
		Schema::table('scores', function($table){
			$table->longText('tracked_score');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('highscores', function($table){
			$table->dropColumn('tracked_score');
		});

		Schema::table('scores', function($table){
			$table->dropColumn('tracked_score');
		});
	}

}
