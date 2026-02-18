<?php

namespace Database\Seeders;

use App\Models\Admin\CountryContinent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         CountryContinent::insert([
            ['continent_name' => 'Asia'],
            ['continent_name' => 'Europe'],
            ['continent_name' => 'Oceania'],
            ['continent_name' => 'North America'],
            ['continent_name' => 'South America'],
            ['continent_name' => 'Africa'],
        ]);
    }
}
