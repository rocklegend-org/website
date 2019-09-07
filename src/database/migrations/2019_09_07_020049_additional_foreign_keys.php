<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdditionalForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('followers', function(Blueprint $table) {
            $table->integer('followed_user_id')->unsigned()->change();
            $table->integer('stalker_user_id')->unsigned()->change();

            $table->foreign('followed_user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('stalker_user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('songs', function(Blueprint $table) {
            $table->integer('artist_id')->unsigned()->change();
            $table->integer('album_id')->unsigned()->change();
            $table->integer('label_id')->unsigned()->change();

            $table->foreign('artist_id')->references('id')->on('artists')
                ->onDelete('cascade');

            $table->foreign('album_id')->references('id')->on('albums')
                ->onDelete('cascade');

            $table->foreign('label_id')->references('id')->on('labels')
                ->onDelete('cascade');
        });

        Schema::table('albums', function(Blueprint $table) {
            $table->integer('artist_id')->unsigned()->change();

            $table->foreign('artist_id')->references('id')->on('artists')
                ->onDelete('cascade');
        });

        Schema::table('tracks_comments', function(Blueprint $table) {
            $table->integer('track_id')->unsigned()->change();
            $table->integer('user_id')->unsigned()->change();

            $table->foreign('track_id')->references('id')->on('tracks')
                ->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('tracks_comments_flags', function(Blueprint $table) {
            $table->integer('track_comment_id')->unsigned()->change();

            $table->foreign('track_comment_id')->references('id')->on('tracks_comments')
                ->onDelete('cascade');
        });

        Schema::table('tracks_history', function(Blueprint $table) {
            $table->integer('track_id')->unsigned()->change();
            $table->integer('song_id')->unsigned()->change();
            $table->integer('user_id')->unsigned()->change();

            $table->foreign('track_id')->references('id')->on('tracks')
                ->onDelete('cascade');

            $table->foreign('song_id')->references('id')->on('songs')
                ->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('tracks', function(Blueprint $table) {
            $table->integer('song_id')->unsigned()->change();
            $table->integer('user_id')->unsigned()->change();

            $table->foreign('song_id')->references('id')->on('songs')
                ->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
