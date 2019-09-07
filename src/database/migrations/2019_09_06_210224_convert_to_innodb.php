<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

function getTables() {
    return DB::select(
        'SELECT table_name FROM information_schema.tables WHERE table_schema = ?',
        [env('DB_DATABASE', 'rocklegend')]
    );
}

class ConvertToInnodb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = getTables();

        foreach ($tables as $table) {
            DB::statement('ALTER TABLE ' . $table->table_name . ' ENGINE = InnoDB');
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = getTables();

        foreach ($tables as $table) {
            DB::statement('ALTER TABLE ' . $table->table_name . ' ENGINE = MyISAM');
        }
    }
}