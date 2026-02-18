<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CompanyJob extends Model
{
    use  HasFactory, SoftDeletes;
    protected $guarded = [];
    public $timestamps = true;

     // company relation
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // country relation
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    
    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }

}
