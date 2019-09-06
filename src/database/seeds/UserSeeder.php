<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        $roles = array('admin', 'player', 'artist', 'label');

        foreach($roles as $username) {

            $role = Sentinel::findRoleBySlug($username);

            $password = $username.'rl';

        	$user = Sentinel::create([
				'username'    => $username,
				'password'    => $password,
				'email'       => $username . '@example.com',
				'activated'   => 1,
            ]);

            $role->users()->attach($user);
        }
    }
}
