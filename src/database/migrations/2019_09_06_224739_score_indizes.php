<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScoreIndizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scores', function (Blueprint $table) {   
            $table->integer('user_id')->unsigned()->change();
            $table->integer('track_id')->unsigned()->change();
     
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('track_id')->references('id')->on('tracks')
                ->onDelete('cascade');

            $table->index(['user_id', 'track_id']);
        });

        Schema::table('highscores_OLD', function (Blueprint $table) {   
            $table->integer('user_id')->unsigned()->change();
            $table->integer('track_id')->unsigned()->change();
     
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('track_id')->references('id')->on('tracks')
                ->onDelete('cascade');

            $table->index(['user_id', 'track_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scores', function (Blueprint $table) {     
            $table->integer('user_id')->change();
            $table->integer('track_id')->change();
   
            $table->dropForeign(['user_id']);
            $table->dropForeign(['track_id']);

            $table->dropIndex(['user_id', 'track_id']);
        });

        Schema::table('highscores_OLD', function (Blueprint $table) {     
            $table->integer('user_id')->change();
            $table->integer('track_id')->change();
   
            $table->dropForeign(['user_id']);
            $table->dropForeign(['track_id']);

            $table->dropIndex(['user_id', 'track_id']);
        });
    }
}
