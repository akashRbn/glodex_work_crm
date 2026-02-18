<?php

namespace Database\Seeders;

use App\Models\Admin\CourseProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseProgram::insert([
            ['course_program' => 'PhD'],
            ['course_program' => 'MRes'],
            ['course_program' => 'Masters'],
            ['course_program' => 'Pre Masters'],
            ['course_program' => 'Bachelor'],
            ['course_program' => 'Higher Diploma'],
            ['course_program' => 'Diploma'],
            ['course_program' => 'Foundation'],
        ]);
    }
}
