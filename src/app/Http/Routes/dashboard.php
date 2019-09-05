<?php

Route::group( ['prefix' => 'dashboard', 'as' => 'dashboard.', 'namespace' => 'Dashboard'], function () {
	Route::resources([
		'artist' => 'ArtistController',
		'album' => 'AlbumController',
		'track' => 'TrackController',
		'song' => 'SongController',
		'user' => 'UserController',
		'signup-code' => 'SignupCodeController',
	]);
});