<?php

class AssignmentsFeatureSeeder extends Seeder {

	public function run()
	{
		// precondition: users are seeded

		Eloquent::unguard();

        $this->command->info('Assignments test data seeded');

		// get admin user for manufaturer_user relation
		$admin = User::where('username', '=', 'admin')->get()[0];

		// manufacturers
		DB::table('manufacturers')->delete();
		$manufacturer = new Manufacturer;
		$manufacturer->name = 'Manufacturer1';
		$manufacturer->save();
		$admin->manufacturers()->save($manufacturer);
		
		$manufacturer = new Manufacturer;
		$manufacturer->name = 'Manufacturer2';
		$manufacturer->save();
		$admin->manufacturers()->save($manufacturer);

		// medium_template & package_tempalte
		DB::table('medium_templates')->delete();
		$medium_template = new MediumTemplate;
		$medium_template->name = "MediumConcurrency1";
		$medium_template->concurrency = 1;
		$medium_template->save();
		$medium_template2 = new MediumTemplate;
		$medium_template2->name = "MediumConcurrency2";
		$medium_template2->concurrency = 4;
		$medium_template2->save();

		DB::table('package_templates')->delete();
		$package_template = new PackageTemplate;
		$package_template->name = "PackageDSplitable";
		$package_template->equivalent_value = 1000;
		$package_template->booking_period = 'D';
		$package_template->is_splitable = 1;
		$package_template->save();
		$package_template->medium_templates()->save($medium_template, ['amount' => 1]);
		$package_template->medium_templates()->save($medium_template2, ['amount' => 2]);
		$package_template = new PackageTemplate;
		$package_template->name = "PackageM";
		$package_template->equivalent_value = 2000;
		$package_template->booking_period = 'M';
		$package_template->is_splitable = 0;
		$package_template->save();
		$package_template->medium_templates()->save($medium_template2, ['amount' => 2]);

	}

}