<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function($table)
		{
			$table->increments('id');
			$table->integer('recipient_id');
			$table->string('type');
			$table->text('title');
			$table->text('subject');
			$table->text('message');
			$table->boolean('active');
			$table->string('group_id');
			$table->text('url');
			$table->text('debug');
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
		Schema::dropIfExists('notifications');
	}

}
