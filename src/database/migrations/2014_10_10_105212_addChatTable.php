<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChatTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chat_channels', function($table)
		{
			$table->increments('id');
			$table->string('token');
			$table->string('channel_name');
			$table->integer('creator_id');
			$table->boolean('public');
			$table->string('password');
			$table->timestamps();
		});

		Schema::create('chat_messages', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('channel_id');
			$table->text('message');
			$table->timestamps();
		});

		Schema::create('chat_users', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('channel_id');
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
		Schema::dropIfExists('chat_channels');
		Schema::dropIfExists('chat_messages');
		Schema::dropIfExists('chat_users');
	}

}
