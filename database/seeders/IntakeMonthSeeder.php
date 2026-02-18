<?php

namespace Database\Seeders;

use App\Models\Admin\IntakeMonth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntakeMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         IntakeMonth::insert([
            ['month_name' => 'January'],
            ['month_name' => 'February'],
            ['month_name' => 'March'],
            ['month_name' => 'April'],
            ['month_name' => 'May'],
            ['month_name' => 'June'],
            ['month_name' => 'July'],
            ['month_name' => 'Auguest'],
            ['month_name' => 'September'],
            ['month_name' => 'October'],
            ['month_name' => 'November'],
            ['month_name' => 'December'],
        ]);
    }
}
