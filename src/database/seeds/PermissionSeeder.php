<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder {

    public function run() {

        $permissions = array(

            'Admin' => array(

                'Dashboard\\DashboardController'    => 1,
                'Dashboard\\AlbumController'        => 1,
                'Dashboard\\ArtistController'       => 1,
                'Dashboard\\LabelController'        => 1,
                'Dashboard\\TrackController'         => 1,
                'Dashboard\\SongController'         => 1,
                'Dashboard\\UserController'         => 1,
                'Dashboard\\InviteController'       => 1,
                'Dashboard\\SignupCodeController'  => 1,

                'ProfileController'                 => 1,
            ),

            'Artist' => array(

                'Dashboard\\DashboardController'    => 1,
                'Dashboard\\AlbumController'        => 1,
                'Dashboard\\ArtistController'       => 1,
                'Dashboard\\LabelController@show'   => 1,
                'Dashboard\\SongController'         => 1,
                'Dashboard\\UserController'         => 1,
            ),

            'Label' => array(

                'Dashboard\\DashboardController'    => 1,
                'Dashboard\\AlbumController'        => 1,
                'Dashboard\\ArtistController'       => 1,
                'Dashboard\\LabelController'        => 1,
                'Dashboard\\UserController'         => 1,
                'Dashboard\\SongController'         => 1,
            ),

            'Player' => array(

                'ProfileController'                 => 1,
            ),
        );

        Eloquent::unguard();

        $groups = array();

        foreach ($permissions as $name => $perm) {

            try {

                $group = Sentry::getGroupProvider()->findByName($name);
                $group->permissions = $perm;
                $group->save();

            } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {

                $group = Sentry::getGroupProvider()->create(array(

                    'name'          => $name,
                    'permissions'   => $perm,
                ));
            }

            $groups[$name] = $group;
        }

        $this->command->info('Groups and permissions seeded.');
    }

}