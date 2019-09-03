<?php

Route::get('play/{artist}/{song}/{track}/{user?}', array('uses' => 'SongController@play', 'as' => 'game.play'));

Route::get('testPlay/{track}', array('uses' => 'SongController@playTest', 'as' => 'game.play.test'));

Route::post('track/notes.json', array('uses' => 'SongController@getNotes'));

Route::post('play/score/{track}/save', array('uses' => 'SongController@saveScore', 'as' => 'game.saveScore'));

Route::any('track/comments/{track}/{page?}', array('uses' => 'SongController@comments', 'as' => 'track.comments'));

Route::post('track/comment/{track}', array('uses' => 'SongController@comment', 'as' => 'track.comment.post'));
Route::post('track/comment/{track}/reply', array('uses' => 'SongController@replyToComment', 'as' => 'track.comment.reply'));
Route::get('track/comment/{track}/reply', function(){
	return Redirect::to('');
});

Route::get('track/{track}.json', array('uses' => 'SongController@getTrackJSON', 'as' => 'track.json'));
Route::post('track/{track}.scores.html', array('uses' => 'SongController@getTrackScoresHtml'));

Route::post('user/playersettings', array('uses' => 'ProfileController@savePlayerSettings', 'as' => 'game.settings.save'));