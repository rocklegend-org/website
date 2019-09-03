<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        $groups = array('admin', 'player', 'artist', 'label');

        foreach($groups as $username) {

            $group = Sentry::getGroupProvider()->findByName($username);

            $password = $username.'rl';

        	Sentry::getUserProvider()->create(array(

				'username'    => $username,
				'password'    => $password,
				'email'       => $username . '@example.com',
				'activated'   => 1,

			))->addGroup($group);
        }
    }
}
