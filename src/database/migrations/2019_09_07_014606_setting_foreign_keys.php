<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_settings', function(Blueprint $table) {
            $table->integer('user_id')->unsigned()->change();
            $table->integer('setting_id')->unsigned()->change();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('setting_id')->references('id')->on('threads')
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
        Schema::table('user_settings', function(Blueprint $table) {
            $table->integer('user_id')->change();
            $table->integer('setting_id')->change();

            $table->dropForeign(['user_id']);
            $table->dropForeign(['setting_id']);
        });
    }
}
