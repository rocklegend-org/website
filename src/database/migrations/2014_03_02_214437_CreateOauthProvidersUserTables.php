<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthProvidersUserTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->string('provider')->after('email')->nullable();
	    });

		Schema::create('users_facebook', function(Blueprint $table)
		{
		    $table->increments('id');
		    $table->unsignedInteger('user_id');
		    $table->string('facebook_id');
		    $table->string('name')->nullable();
		    $table->string('first_name')->nullable();
		    $table->string('last_name')->nullable();
		    $table->string('link')->nullable();
		    $table->string('username')->nullable();
		    $table->string('gender')->nullable();
		    $table->string('email')->nullable();
		    $table->unsignedInteger('timezone')->nullable();
		    $table->string('locale')->nullable();
		    $table->boolean('verified')->nullable();
		    $table->timestamps();
		});

		Schema::create('users_twitter', function(Blueprint $table)
		{
		    $table->increments('id');
		    $table->unsignedInteger('user_id');
		    $table->string('twitter_id');
		    $table->string('name')->nullable();
		    $table->string('screen_name')->nullable();
		    $table->string('location')->nullable();
		    $table->string('description')->nullable();
		    $table->string('url')->nullable();
		    $table->integer('utc_offset')->nullable();
		    $table->string('time_zone')->nullable();
		    $table->boolean('verified')->nullable();
		    $table->string('lang')->nullable();
		    $table->timestamps();
		});

		Schema::create('users_google', function(Blueprint $table)
		{
		    $table->increments('id');
		    $table->unsignedInteger('user_id');
		    $table->string('google_id');
		    $table->string('email')->nullable();
		    $table->boolean('verified_email')->nullable();
		    $table->timestamps();
		});

		Schema::create('users_github', function(Blueprint $table)
		{
		    $table->increments('id');
		    $table->unsignedInteger('user_id');
		    $table->string('github_id');
		    $table->string('login')->nullable();
		    $table->string('url')->nullable();
		    $table->string('type')->nullable();
		    $table->string('name')->nullable();
		    $table->string('company')->nullable();
		    $table->string('blog')->nullable();
		    $table->string('location')->nullable();
		    $table->string('email')->nullable();
		    $table->boolean('hireable')->nullable();
		    $table->text('bio')->nullable();
		    $table->integer('public_repos')->nullable();
		    $table->integer('followers')->nullable();
		    $table->integer('following')->nullable();
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
		Schema::drop('users_facebook');

		Schema::drop('users_twitter');

		Schema::drop('users_google');

		Schema::drop('users_github');

		Schema::table('users', function($table) {
			$table->dropColumn('provider');
	    });
	}

}
