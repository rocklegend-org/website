<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHighscoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('highscores', function($table)
		{
			$table->integer('track_id');
			$table->integer('user_id');

			$table->integer('score');
			$table->integer('max_streak');
			$table->integer('max_multiplier');

			$table->integer('notes_hit');
			$table->integer('notes_missed');

			$table->longtext('performance_data'); // this could hold the performance data (for animating a video?)
			
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('highscores');		
	}

}
