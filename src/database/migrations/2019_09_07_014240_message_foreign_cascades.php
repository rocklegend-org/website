<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MessageForeignCascades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['thread_id']);

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('thread_id')->references('id')->on('threads')
                ->onDelete('cascade');
        });

        Schema::table('participants', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['thread_id']);

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('thread_id')->references('id')->on('threads')
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
        // dont drop this
    }
}
