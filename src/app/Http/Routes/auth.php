<?php

Route::get('login', array('uses' => 'AuthController@login', 'as' => 'login'));
Route::post('login', array('uses' => 'AuthController@postLogin', 'as' => 'login.process'));

Route::get('logout', array('uses' => 'AuthController@logout', 'as' => 'logout'));

// password reset
Route::get('forgot-password', array('uses' => 'AuthController@passwordForgotten', 'as' => 'password.forgotten'));
Route::post('forgot-password', array('uses' => 'AuthController@passwordForgottenProcess', 'as' => 'password.forgotten'));
Route::get('reset-password/{code}/{id}', array('uses' => 'AuthController@passwordReset', 'as' => 'password.reset'));
Route::post('reset-password/process', array('uses' => 'AuthController@passwordResetProcess', 'as' => 'password.reset.process'));

// register
Route::any('register', array('uses' => 'AuthController@register', 'as' => 'register'));