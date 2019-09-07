<?php
/**
 * Part of the Sentinel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Sentinel
 * @version    2.0.18
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return array(
	'cookie' => 'cartalyst_sentinel',

	'roles' => [
		'model' => 'Cartalyst\Sentinel\Roles\EloquentRole',
	],

	'users' => array(
		'model' => 'User',
		'login_attribute' => 'username',
	),

	'persistences' => [
		'model' => 'Cartalyst\Sentinel\Persistences\EloquentPersistence',
		'single' => false,
	],

	'checkpoints' => [
		'throttle',
		// 'activation',
	],

	'activations' => [
		'model' => 'Cartalyst\Sentinel\Activations\EloquentActivation',
		'expires' => 259200,
		'lottery' => [2, 100],
	],

	'reminders' => [
		'model' => 'Cartalyst\Sentinel\Reminders\EloquentReminder',
		'expires' => 14400,
		'lottery' => [2, 100],
	],

	'throttling' => [
		'model' => 'Cartalyst\Sentinel\Throttling\EloquentThrottle',
		'global' => [
			'interval' => 900,
			'thresholds' => [
					10 => 1,
					20 => 2,
					30 => 4,
					40 => 8,
					50 => 16,
					60 => 32,
			],
		],
		'ip' => [
			'interval' => 900,
			'thresholds' => 5,
		],
		'user' => [
			'interval' => 900,
			'thresholds' => 5,
		],
	],

);
