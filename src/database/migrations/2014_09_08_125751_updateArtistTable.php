<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateArtistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{		
		Schema::table('artists', function($table){
			$table->string('founded_date');
			$table->longText('biography');
			$table->string('genre');
			$table->text('tags');
			$table->text('facebook_url');
			$table->text('twitter_url');
			$table->text('youtube_url');
			$table->text('bandcamp_url');
			$table->text('itunes_url');
			$table->text('website_url');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('artists', function($table){
			$table->dropColumn(array('founded_date', 'biography','genre','tags',
									'facebook_url','twitter_url',
									'youtube_url','bandcamp_url','itunes_url','website_url'));
		});
	}

}
