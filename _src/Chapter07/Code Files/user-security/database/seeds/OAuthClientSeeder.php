<?php

use Illuminate\Database\Seeder;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('oauth_clients')->insert(
            [
                'id' => '100001',
                'secret' => 'myUniqueSecret34234234',
                'name' => 'theRealMrGott'
            ]
        );

    }
}