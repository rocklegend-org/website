<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder {

    public function run() {

        $permissions = [
            'Admin' => [
                'dashboard' => true,
            ],

            'Player' => [
                'tools' => true,
            ],
        ];

        Eloquent::unguard();

        $roles = array();

        foreach ($permissions as $name => $perm) {
            $role = Sentinel::findRoleByName($name);

            if (is_null($role)) {
                $role = Sentinel::getRoleRepository()->createModel()->create([
                    'name'          => $name,
                    'slug'          => lcfirst($name)
                ]);
            }
        
            $role->permissions = $perm;
            $role->save();

            $roles[$name] = $role;
        }

        // delete roles which no longer exist
        DB::table('roles')->whereNotIn('name', array_keys($permissions))->delete();

        $this->command->info('Roles and permissions seeded.');
    }

}