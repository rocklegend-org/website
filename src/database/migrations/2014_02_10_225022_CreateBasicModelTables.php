<?php

use Illuminate\Database\Migrations\Migration;

class CreateBasicModelTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('artists', function($table)
		{
		    $table->increments('id');
		    $table->string('name');
		    $table->string('slug')->unique();
		    $table->string('hash')->unique();
		    $table->softDeletes();
		    $table->timestamps();
		});

		Schema::create('labels', function($table)
		{
		    $table->increments('id');
		    $table->string('name');
		    $table->string('slug')->unique();
		    $table->string('hash')->unique();
		    $table->softDeletes();
		    $table->timestamps();
		});

		Schema::create('songs', function($table)
		{
		    $table->increments('id');
		    $table->unsignedInteger('artist_id')->nullable();
		    $table->unsignedInteger('album_id')->nullable();
		    $table->unsignedInteger('label_id')->nullable();
		    $table->string('title');
		    $table->string('slug')->unique();
		    $table->string('hash')->unique();
		    /**
		     * The current song status
		     * 0 = inactive
		     * 1 = active
		     * 2 = pending review
		     * 3 = marked as spam
		     */
		    $table->unsignedInteger('status');
		    $table->softDeletes();
		    $table->timestamps();
		});

		Schema::create('albums', function($table)
		{
		    $table->increments('id');
		    $table->unsignedInteger('artist_id');
		    $table->string('title');
		    $table->string('slug')->unique();
		    $table->string('hash')->unique();
		    $table->softDeletes();
		    $table->timestamps();
		});

		Schema::create('notes', function($table)
		{
		    $table->increments('id');
		    $table->unsignedInteger('song_id');
			$table->unsignedInteger('difficulty_id');
			$table->longtext('data');
		    /**
		     * The current notetrack status
		     * 0 = inactive
		     * 1 = active
		     * 2 = pending review
		     * 3 = marked as spam
		     */
		    $table->unsignedInteger('status');

		    $table->softDeletes();
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
		Schema::dropIfExists('albums');
		Schema::dropIfExists('artists');
		Schema::dropIfExists('labels');
		Schema::dropIfExists('songs');
		Schema::dropIfExists('notes');
	}

}