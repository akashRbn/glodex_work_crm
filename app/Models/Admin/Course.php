<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use  SoftDeletes;
    
    protected $guarded = [];
    public $timestamps = true;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }

    public function courseProgram()
    {
        return $this->belongsTo(CourseProgram::class, 'course_program_id');
    }

    public function getIntakeMonthNamesAttribute()
    {
        $monthIds = json_decode($this->intake_month_id, true) ?? [];

        if (empty($monthIds)) {
            return 'N/A';
        }

        // Fetch month names from IntakeMonth model
        $months = IntakeMonth::whereIn('id', $monthIds)
            ->pluck('month_name')
            ->toArray();

        return implode(', ', $months);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'course_id');
    }

}
