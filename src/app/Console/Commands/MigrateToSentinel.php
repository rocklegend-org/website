<?php namespace Rocklegend\Console\Commands;

use Activation;
use DB;
use Illuminate\Console\Command;
use Sentinel;

class MigrateToSentinel extends Command
{
    /**
     * The console command name
     *
     * @var string
     */
    protected $name = 'sentinel:upgrade';
    /**
     * The console command description
     *
     * @var string
     */
    protected $description = 'Update existing Sentry data to Sentinel';
    /**
     * The table to use for users queries
     *
     * @var string
     */
    protected $usersTable = 'users';
    /**
     * The table to use for groups queries
     *
     * @var string
     */
    protected $groupsTable = 'groups';
    /**
     * The table to use for users_groups queries (the join table)
     *
     * @var string
     */
    protected $usersGroupsTable = 'users_groups';
    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->upgradeActivations();
        $this->upgradeRoles();
        $this->upgradeRoleAttachments();
        $this->upgradeRolePermissions();
    }
    /**
     * Upgrade existing Sentry activation data into Sentinel
     *
     * We first grab all user id's that are active and then create a new activation and complete it in one fell swoop.
     * Then we grab all user id's that have not been activated and create a new activation.
     */
    protected function upgradeActivations()
    {
        $activeIds = DB::table($this->usersTable)->where('activated', true)->pluck('id');
        foreach ($activeIds as $id) {
            $user = Sentinel::findById($id);
            if (!Activation::completed($user)) {
                $activation = Activation::create($user);
                Activation::complete($user, $activation->code);
            }
        }
        $this->info('Existing active users have been upgraded');
        $pendingIds = DB::table($this->usersTable)
                        ->where('activated', true)
                        ->pluck('id');
        foreach ($pendingIds as $id) {
            $user = Sentinel::findById($id);
            if (!Activation::exists($user) && !Activation::completed($user)) {
                Activation::create($user);
            }
        }
        $this->info('Existing pending users have been upgraded');
    }
    /**
     * Upgrade existing groups into Sentinel's roles
     *
     * We grab all groups and then create new roles for each one.
     */
    protected function upgradeRoles()
    {
        $groups = DB::table($this->groupsTable)->orderBy('id')->get();
        foreach ($groups as $group) {
            Sentinel::getRoleRepository()->createModel()->create(
                [
                    'name' => $group->name,
                    'slug' => str_slug($group->name)
                ]
            );
        }
        $this->info('Existing groups have been upgraded to roles');
    }
    /**
     * Upgrade existing user group attachments into Sentinel's role attachments
     *
     * First we grab all users. Then we grab all records from the `users_groups` table based on the users returned from
     * the first find. This will eliminate any potential duplicates or orphaned records. Then we grab all old groups so
     * have some good group names to work with.
     *
     * Once we have all our good data, we can start recreating the user role attachments. We run through all the records
     * from the user_groups table. We find the respective user, then find the role based off of the old group name. Then
     * we use Sentinel's magic to create the new attachment.
     */
    protected function upgradeRoleAttachments()
    {
        $users = DB::table($this->usersTable)->pluck('id');
        $userGroups = DB::table($this->usersGroupsTable)->whereIn('user_id', $users)->pluck('group_id', 'user_id');
        $groups = DB::table($this->groupsTable)->pluck('name', 'id');
        foreach ($userGroups as $key => $value) {
            $user = Sentinel::findById($key);
            $role = Sentinel::findRoleByName($groups[$value]);
            $role->users()->attach($user);
        }
        $this->info('Existing groups have been attached to users as roles');
    }
    /**
     * Upgrade existing group permissions into Sentinel's roles
     *
     * We need to grab all groups. Then we run through each one. We parse the permission json and add each permission to
     * the respective role
     */
    protected function upgradeRolePermissions()
    {
        $groups = DB::table($this->groupsTable)->get();
        foreach ($groups as $group) {
            $role = Sentinel::findRoleByName($group->name);
            foreach (json_decode($group->permissions) as $permission => $value) {
                $role->addPermission($permission, $value ? true : false)->save();
            }
        }
        $this->info('Existing group permissions have been upgraded');
    }
}