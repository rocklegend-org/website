<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tracks_comments', function($table)
		{
			$table->increments('id');
			$table->integer('track_id');
			$table->integer('user_id');
			$table->integer('parent_id')->default(0);
		    $table->text('comment');
		    $table->boolean('active')->default(true);
		    $table->timestamps();
		});

		Schema::create('tracks_comments_flags', function($table)
		{
			$table->increments('id');
			$table->integer('track_comment_id');
			$table->integer('user_id');
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
		Schema::dropIfExists('tracks_comments');
		Schema::dropIfExists('tracks_comments_flags');
	}

}
