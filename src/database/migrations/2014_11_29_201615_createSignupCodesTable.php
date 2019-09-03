<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignupCodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('signup_codes', function($table)
		{
			$table->increments('id');
			$table->string('code');
			$table->boolean('used')->default(false);
			$table->integer('amount');
			$table->timestamp('active_from');
			$table->timestamp('active_to');
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('user_signup_codes', function($table)
		{
			$table->integer('signup_code_id');
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
		Schema::dropIfExists('signup_codes');
		Schema::dropIfExists('user_signup_codes');
	}

}
