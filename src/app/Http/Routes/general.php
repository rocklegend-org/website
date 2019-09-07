<?php
    Route::get('imprint', array('uses' => 'HomeController@showImprint', 'as' => 'imprint'));
    Route::get('terms-of-service', array('uses' => 'HomeController@showTerms', 'as' => 'tos'));
    Route::get('admin-stats', array('uses' => 'HomeController@showStatistics'));
    Route::get('changelog', array('uses' => 'MarkdownController@changelog', 'as' => 'changelog'));
    
    Route::get('sitemap/{format?}', array('uses' => 'BaseController@generateSitemap'));
    Route::get('sitemap.{format}', array('uses' => 'BaseController@generateSitemap'));
