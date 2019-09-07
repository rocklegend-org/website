<?php

Route::get('dashboard', 'Dashboard\\DashboardController@index')->name('dashboard')->middleware(['auth', 'perm:dashboard']);

Route::middleware(['auth', 'perm:dashboard'])
	->prefix('dashboard')
	->name('dashboard.')
	->namespace('Dashboard')
	->group(function () {
		Route::get('song/{id}/notes', array('uses' => 'SongController@notes', 'as' => 'song.notes'));
		Route::get('flush-cache', array('uses' => 'DashboardController@flushCache', 'as' => 'flush.cache'));

		Route::post('song/{id}/notes', array('uses' => 'SongController@updateNotes', 'as' => 'song.notes.approve'));

		Route::resources([
			'artist' => 'ArtistController',
			'album' => 'AlbumController',
			'track' => 'TrackController',
			'song' => 'SongController',
			'user' => 'UserController',
			'signup-code' => 'SignupCodeController',
		]);
	});