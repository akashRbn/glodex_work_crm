<?php

namespace Database\Seeders;

use App\Models\Admin\ApplicationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         ApplicationStatus::insert([
            ['status_name' => 'In Progress', 'status_order' => 1],
            ['status_name' => 'On Hold', 'status_order' => 2],
            ['status_name' => 'Applied', 'status_order' => 3],
            ['status_name' => 'Permit Received', 'status_order' => 4],
            ['status_name' => 'Visa Applied', 'status_order' => 5],
            ['status_name' => 'Visa Granted', 'status_order' => 6],
            ['status_name' => 'Visa Rejected', 'status_order' => 7],
            ['status_name' => 'Canceled', 'status_order' => 8],
        ]);
    }
}
