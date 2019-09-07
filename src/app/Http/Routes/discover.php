<?php

Route::get('/', array('uses' => 'HomeController@index', 'as' => 'home'));
Route::get('artist/{artist}', array('uses' => 'ArtistController@show', 'as' => 'artist.show'));

Route::get('discover', array('uses' => 'DiscoverController@index', 'as' => 'discover'));
Route::get('discover/songlist', array('uses' => 'DiscoverController@songlist', 'as' => 'discover.songlist'));

Route::get('rankings/{sortBy?}/{dir?}', array('uses' => 'RankingsController@home', 'as' => 'rankings'));
