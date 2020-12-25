<?php

use Illuminate\Database\Seeder;

class SecretsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('secrets')->delete();

        DB::table('secrets')->insert([
            ['name' => 'amber', 'latitude' => 42.8805, 'longitude' => -8.54569, 'location_name' => 'Santiago de Compostela'],
            ['name' => 'diamond', 'latitude' => 38.2622, 'longitude' => -0.70107, 'location_name' => 'Elche'],
            ['name' => 'pearl', 'latitude' => 41.8919,'longitude' => 2.5113, 'location_name' => 'Rome'],
            ['name' => 'ruby', 'latitude' => 53.4106, 'longitude' => -2.9779, 'location_name' => 'Liverpool'],
            ['name' => 'sapphire', 'latitude' => 50.08804, 'longitude' => 14.42076, 'location_name' => 'Prague']
        ]);
    }
}