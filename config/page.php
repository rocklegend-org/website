<?php
/**
 * This file contains various configuration options for the page
 *
 * @author pne
 */

return array(

	'navigation' => array(
		'&nbsp;Play' => array(
			'url' => '/discover',
			'class' => 'bg-green',
			'icon' => 'fa-music',
			'activeCheck' => array('songs*','discover*','play*')
		),
		'Rankings' => array(
			'url' => '/rankings',
			'class' => 'bg-blue',
			'icon' => 'fa-list-ol',
			'activeCheck' => array('rankings*')
		),
		'Tools' => array(
			'url' => '/tools',
			'class' => 'bg-red',
			'icon' => 'fa-cogs',
			'activeCheck' => array('create*', 'tools*') 
		),
		'New forum is online!' => array(
			'url' => 'http://forum.rocklegend.org',
			'class' => 'bg-violet',
			'icon' => 'fa-comments',
			'activeCheck' => array('forum*')
		)
	)
	
);