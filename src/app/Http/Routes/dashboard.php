<?php

Route::get('dashboard', 'Dashboard\\DashboardController@index')->name('dashboard')->middleware(['auth', 'perm:dashboard']);

Route::middleware(['auth', 'perm:dashboard'])
	->prefix('dashboard')
	->name('dashboard.')
	->namespace('Dashboard')
	->group(function () {
		Route::resources([
			'artist' => 'ArtistController',
			'album' => 'AlbumController',
			'track' => 'TrackController',
			'song' => 'SongController',
			'user' => 'UserController',
			'signup-code' => 'SignupCodeController',
		]);
	});