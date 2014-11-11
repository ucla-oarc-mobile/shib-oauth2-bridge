<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
                
                DB::table('oauth_scopes')->delete();
                DB::table('oauth_scopes')->insert([
                    'scope' => 'basic',
                    'name' => 'basic',
                    'description' => 'basic'
                ]);
	}

}
