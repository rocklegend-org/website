<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnUpdateCurrentTimestamp extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE ".DB::getTablePrefix()."albums CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL");

		DB::statement("ALTER TABLE ".DB::getTablePrefix()."artists CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL");

		DB::statement("ALTER TABLE ".DB::getTablePrefix()."labels CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL");

		DB::statement("ALTER TABLE ".DB::getTablePrefix()."users CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL");

		DB::statement("ALTER TABLE ".DB::getTablePrefix()."songs CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL");

		DB::statement("ALTER TABLE ".DB::getTablePrefix()."notes CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{		
		DB::statement("ALTER TABLE ".DB::getTablePrefix()."albums CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

		DB::statement("ALTER TABLE ".DB::getTablePrefix()."artists CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMPNOT NULL");

		DB::statement("ALTER TABLE ".DB::getTablePrefix()."labels CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

		DB::statement("ALTER TABLE ".DB::getTablePrefix()."users CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

		DB::statement("ALTER TABLE ".DB::getTablePrefix()."songs CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

		DB::statement("ALTER TABLE ".DB::getTablePrefix()."notes CHANGE updated_at updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");
	}

}
