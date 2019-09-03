<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNotesToTracks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::rename('notes', 'tracks');

		Schema::table('tracks', function($table)
		{
			$table->string('name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::rename('tracks', 'notes');

		Schema::table('notes', function($table){
			$table->dropColumn('name');
		});
	}

}
