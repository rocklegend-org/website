<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        $roles = array('admin', 'player');

        foreach($roles as $username) {

            $role = Sentinel::findRoleBySlug($username);
            $user = User::where('username', $username)->first();

            if (is_null($user)) {
                $password = $username.'rl';

                $user = Sentinel::create([
                    'username'    => $username,
                    'password'    => $password,
                    'email'       => $username . '@example.com',
                    'activated'   => 1,
                ]);
            } else if ($user->inRole($role->slug)) {
                return;
            }

            $role->users()->attach($user);
        }
    }
}
