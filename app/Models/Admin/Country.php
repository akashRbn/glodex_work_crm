<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use  SoftDeletes;
    protected $guarded = [];
    public $timestamps = true;

    public function countryContinent()
    {
        return $this->belongsTo(CountryContinent::class, 'continent_id');
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'country_id');
    }

    public function jobs()
    {
        return $this->hasMany(CompanyJob::class, 'country_id');
    }
}
