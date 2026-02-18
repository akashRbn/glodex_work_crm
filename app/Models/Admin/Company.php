<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public $timestamps = true;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function jobs()
    {
        return $this->hasMany(CompanyJob::class, 'company_id');
    }
}
