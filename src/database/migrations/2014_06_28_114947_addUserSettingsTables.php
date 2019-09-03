<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserSettingsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/**
		 * settings
		 *
		 * This table stores available settings
		 */
		Schema::create('settings', function($table){
		    $table->increments('id');
		    $table->string('name');
		    $table->boolean('constrained');
		    $table->string('data_type');
		    $table->integer('min_value');
		    $table->integer('max_value');
		    $table->string('default_value');
		    $table->timestamps();
		});

		/**
		 * allowed_settings_values
		 *
		 * This table stores allowed values for constrained settings
		 */
		Schema::create('allowed_settings_values', function($table){
			$table->increments('id');
			$table->integer('setting_id');
			$table->string('item_value');
			$table->string('caption');
		    $table->timestamps();
		});

		/**
		 * user_settings
		 *
		 * This table stores user_settings
		 */
		Schema::create('user_settings', function($table){
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('setting_id');
			$table->integer('allowed_setting_value_id');
			$table->string('unconstrained_value');
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
		Schema::dropIfExists('settings');
		Schema::dropIfExists('allowed_settings_values');
		Schema::dropIfExists('user_settings');
	}

}
