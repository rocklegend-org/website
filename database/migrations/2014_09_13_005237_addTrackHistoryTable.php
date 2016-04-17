<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrackHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tracks_history', function($table)
		{
			$table->increments('id');
			$table->integer('track_id');
			$table->integer('version');

		    $table->unsignedInteger('song_id');
			$table->unsignedInteger('lanes');
			$table->unsignedInteger('difficulty');
			$table->longtext('data');
		    $table->unsignedInteger('status');
			$table->integer('play_count');
			$table->string('name');
		    $table->unsignedInteger('user_id')->nullable();
			$table->unsignedInteger('px_per_second')->default(150);

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
		Schema::dropIfExists('tracks_history');
	}

}
