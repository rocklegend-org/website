<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScoreIndizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('highscores', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('score_id');
            $table->index('track_id');
            $table->index('score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('highscores', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('score_id');
            $table->dropIndex('track_id');
            $table->dropIndex('score');
        });
    }
}
