<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllScoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scores', function($table)
		{
			$table->increments('id');
			$table->integer('track_id');
			$table->integer('user_id');

			$table->integer('score');
			$table->integer('max_streak');
			$table->integer('max_multiplier');

			$table->integer('notes_hit');
			$table->integer('notes_missed');

			$table->longtext('performance_data'); // this could hold the performance data (for animating a video?)
			
			$table->string('play_mode');
			$table->text('keylog');
			$table->integer('reload_count');

			$table->timestamps();
		});

		if(Schema::hasTable('highscores')):
			Schema::rename('highscores', 'highscores_OLD');
		endif;

		Schema::create('highscores', function($table)
		{
			$table->increments('id');
			$table->integer('score_id');
			$table->integer('track_id');
			$table->integer('user_id');

			$table->integer('score');
			$table->integer('max_streak');
			$table->integer('max_multiplier');

			$table->integer('notes_hit');
			$table->integer('notes_missed');

			$table->longtext('performance_data'); // this could hold the performance data (for animating a video?)

			$table->string('play_mode');
			$table->text('keylog');
			$table->integer('reload_count');

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
		Schema::dropIfExists('scores');

		if (Schema::hasTable('highscores_OLD')):
			Schema::dropIfExists('highscores');
			Schema::rename('highscores_OLD', 'highscores');
		endif;
	}
}
