<?php

use Illuminate\Database\Seeder;

class BadgeSeeder extends DatabaseSeeder {

    public function run()
    {
        Eloquent::unguard();

        $badges = Config::get('badges');
        $users = User::all();
        $userCount = count($users);

        foreach($badges as $key => $badge_data){
            DB::transaction(function () use ($key, $badge_data, $users, $userCount) {
                print_r('Seeding badge "'.$key.'"');
                $badge = Badge::findByInternalName($key);
                $existed = !is_null($badge);

                if(!$existed){
                    $badge = new Badge;
                }

                $badge->name = $badge_data['name'];
                $badge->description = $badge_data['description'];
                $badge->image = $badge_data['image'];
                $badge->internal_name = $badge_data['internal_name'];
                $badge->group = $badge_data['group'];
                
                $badge->save();

                if ($existed) {
                    return;
                }

                $skipIds = UserBadge::where('badge_id', $badge->id)
                    ->pluck('user_id')
                    ->toArray();
                $i = 1;
                $checkCount = $userCount - count($skipIds);

                foreach($users as $user){
                    if (!array_search($user->id, $skipIds)) {
                        Badge::check($badge->internal_name, $user, true);

                        $i++;

                        if ($i % 100 === 0) {
                            print_r("Still seeding badge \"" . $key . "\" (". $i . "/" . $checkCount . ")\r\n");
                        }
                    }
                }
            }, 5);
        }
    }
}

class ResetBadgeSeeder extends DatabaseSeeder {

	public function run()
	{
		Eloquent::unguard();

		$tables = array('badges', 'user_badges');

		foreach ($tables as $table) {

			DB::table($table)->truncate();
		}
	}

}
