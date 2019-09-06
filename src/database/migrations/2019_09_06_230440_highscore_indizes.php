<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HighscoreIndizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function() {
            // get old scores which are still highscores
            $oldHighscores = Highscore::select('highscores.*')
                ->leftJoin('scores', function($join) {
                    $join->on('scores.id', '=', 'highscores.score_id');
                })
                ->whereNull('scores.id')
                ->get();
            
            // move old highscores to new scores table and update highscores
            foreach ($oldHighscores as $highscore) {
                $score = OldScore::find($highscore->score_id);
                var_dump($score);

                $newScore = new Score($score->toArray());
                $newScore->save();

                Highscore::where('score_id', $score->id)
                    ->update([
                        'score_id' => $newScore->id,
                    ]);
            }

            $oldScores = OldScore::all();

            foreach ($oldScores as $old) {
                $new = new Score($old->toArray());
                $new->save();
            }

            OldScore::truncate();
        });
        
        // now we can properly set up our foreign keys
        Schema::table('highscores', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['track_id']);
            $table->dropIndex(['score_id']);
 
            $table->integer('user_id')->unsigned()->change();
            $table->integer('track_id')->unsigned()->change();
            $table->integer('score_id')->unsigned()->change();
     
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('track_id')->references('id')->on('tracks')
                ->onDelete('cascade');
            $table->foreign('score_id')->references('id')->on('scores')
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
        Schema::table('highscores', function (Blueprint $table) {     
            $table->integer('user_id')->change();
            $table->integer('track_id')->change();
            $table->integer('score_id')->change();
   
            Schema::disableForeignKeyConstraints();

            $table->dropForeign(['user_id']);
            $table->dropForeign(['track_id']);
            $table->dropForeign(['score_id']);

            $table->dropIndex(['user_id', 'track_id']);

            Schema::enableForeignKeyConstraints();

            $table->index('user_id');
            $table->index('track_id');
            $table->index('score_id');
        });
    }
}
