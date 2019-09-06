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

        $roles = array();

        foreach ($permissions as $name => $perm) {
            $role = Sentinel::findRoleByName($name);

            if (is_null($role)) {
                $role = Sentinel::getRoleRepository()->createModel()->create([
                    'name'          => $name,
                    'slug'          => ucfirst($name)
                ]);
            }
        
            $role->permissions = $perm;
            $role->save();

            $roles[$name] = $role;
        }

        $this->command->info('Roles and permissions seeded.');
    }

}