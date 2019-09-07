<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BadgeIndizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_badges', function (Blueprint $table) {   
            $table->integer('user_id')->unsigned()->change();
            $table->integer('badge_id')->unsigned()->change();
     
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('badge_id')->references('id')->on('badges')
                ->onDelete('cascade');

            $table->unique(['user_id', 'badge_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_badges', function (Blueprint $table) {     
            $table->integer('user_id')->change();
            $table->integer('badge_id')->change();
   
            $table->dropForeign(['user_id']);
            $table->dropForeign(['badge_id']);

            $table->dropUnique(['user_id', 'badge_id']);
        });
    }
}
