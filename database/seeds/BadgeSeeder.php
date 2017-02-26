<?php

use Illuminate\Database\Seeder;

class BadgeSeeder extends DatabaseSeeder {

    public function run()
    {

        $rb = new ResetBadgeSeeder();
        $rb->run();

        Eloquent::unguard();

        $badges = Config::get('badges');

        foreach($badges as $key => $badge_data){
            $badge = Badge::where('internal_name', $key)->first();

            if(is_null($badge)){
                $badge = new Badge;
            }

            $badge->name = $badge_data['name'];
            $badge->description = $badge_data['description'];
            $badge->image = $badge_data['image'];
            $badge->internal_name = $badge_data['internal_name'];
            $badge->group = $badge_data['group'];
            
            $badge->save();

            foreach(User::all() as $user){
                Badge::check($badge->internal_name, $user->id, true);
            }
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
