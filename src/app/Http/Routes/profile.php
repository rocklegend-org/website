<?php

Route::get('profile', array('uses' => 'ProfileController@show'));
Route::get('profile/detail/{username?}', array('uses' => 'ProfileController@show', 'as' => 'profile'));
Route::get('profile/box/{username}', array('uses' => 'ProfileController@getBox', 'as' => 'profile.box'));
Route::any('profile/edit', array('uses' => 'ProfileController@edit', 'as' => 'profile.edit'));

Route::get('profile/settings', array('uses' => 'ProfileController@settings', 'as' => 'profile.settings'));
Route::post('profile/settings', array('uses' => 'ProfileController@settings', 'as' => 'profile.settings'));
Route::post('profile/settings/editor', array('uses' => 'ProfileController@settingsEditor', 'as' => 'profile.settings.editor'));
Route::post('profile/settings/discover', array('uses' => 'ProfileController@settingsDiscover', 'as' => 'profile.settings.discover'));

Route::post('profile/follow', array('uses' => 'ProfileController@follow', 'as' => 'profile.follow'));
Route::post('profile/unfollow', array('uses' => 'ProfileController@unfollow', 'as' => 'profile.unfollow'));

Route::get('profile/badges/{username?}', array('uses' => 'ProfileController@badges', 'as' => 'profile.badges'));
Route::get('badges', array('uses' => 'BadgeController@showList', 'as' => 'badges'));

// conversations
Route::get('conversations', array('uses' => 'ConversationController@index', 'as' => 'conversation'));
Route::get('conversations/read/{id}', array('uses' => 'ConversationController@read', 'as' => 'conversation.read'));
Route::any('conversations/start/{recipient?}', array('uses' => 'ConversationController@start', 'as'=>'conversation.start'));

Route::post('conversations/message', array('uses' => 'ConversationController@message', 'as' => 'conversation.message'));
Route::get('conversations/messages/{id}', array('uses' => 'ConversationController@messages', 'as' => 'conversation.messages'));
Route::get('conversations/leave/{id}', array('uses' => 'ConversationController@leave', 'as' => 'conversation.leave'));

Route::get('conversations/availableRecipients', array('uses' => 'ConversationController@availableRecipients'));

// notifications
Route::post('notifications/dismiss', array('uses' => 'ProfileController@dismissNotification'));
Route::get('notifications.html', array('uses' => 'ProfileController@getNotificationHtml'));
