<?php

Route::get('tools', array('uses' => 'ToolsController@index', 'as' => 'tools'));

Route::any('create/song', array('uses' => 'ToolsController@newSong', 'as' => 'create.song'));
Route::any('create/track', array('uses' => 'ToolsController@newTrack', 'as' => 'create.track'));
Route::post('missingDifficulties.html', array('uses' => 'ToolsController@missingDifficultiesSelect', 'as' => 'track.missingDifficulties'));

Route::any('create/editor/{song}/{difficulty_id?}/{track?}', array('uses' => 'ToolsController@editor', 'as' => 'create.editor'));
Route::post('tools/getTrackById/{track}', array('uses' => 'ToolsController@getTrackById'));
Route::post('tools/upload-midi/{track?}', array('uses' => 'ToolsController@uploadMidi'));
Route::any('tools/analyze-midi/{song}', array('uses' => 'ToolsController@analyzeMidi'));
Route::any('tools/select-midi-track/{key}/{track}', array('uses' => 'ToolsController@selectMidiTrack'));


Route::get('delete/track/{track}/{force?}', array('uses' => 'ToolsController@deleteTrack', 'as' => 'delete.track'));
Route::get('clone/track/{track}', array('uses' => 'ToolsController@cloneTrack', 'as' => 'clone.track'));
Route::get('revive/track/{track}', array('uses' => 'ToolsController@reviveTrack', 'as' => 'revive.track'));
Route::get('create/review/{song}/{track}', array('uses' => 'ToolsController@review', 'as' => 'create.review'));

Route::get('tools/trash', array('uses' => 'ToolsController@trash', 'as' => 'tools.trash'));