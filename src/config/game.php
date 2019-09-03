<?php
/**
 * This file contains various configuration options for notes & difficulties
 *
 * @author pne
 */

return array(

	/*
	|--------------------------------------------------------------------------
	| Difficulties
	|--------------------------------------------------------------------------
	|
	| We'll start with 5 difficulties.
	| If we ever need or want to, we can add more as we like.
	|
	*/
	'difficulties' => array(
		2 => array(
			'name' => 'easy',
			'notes'=> array(72,73,74,75)
		),

		3 => array(
			'name' => 'normal',
			'notes'=> array(84,85,86,87,88)
		),

		4 => array(
			'name' => 'hard',
			'notes'=> array(96,97,98,99,100)
		),

		5 => array(
			'name' => 'pro',
			'notes'=> array(96,97,98,99,100)
		),
	),

	'difficulty_colors' => array(
		2 => 'blue',
		3 => 'green',
		4 => 'yellow',
		5 => 'red'
	),
// prev
	// 1 published 
	// 3 voting
	// 0 unpublished 
	// 2 draft
	'trackstates' => array(
		0 => 'draft',
		1 => 'review',
		2 => 'published',
	),

	'songstates' => array(
		0 => 'un-published',
		1 => 'published',
		2 => 'review',
		3 => 'vip-only',
		4 => 'requested'
	),

	'buttonColors' => array(
		1 => 'red',
		2 => 'yellow',
		3 => 'green',
		4 => 'blue',
		5 => 'violet'
	)
);