<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public $timestamps = true;

    public function applicantfiles()
    {
      return $this->hasMany(ApplicantFile::class, 'applicant_id');
    }

    public function createdBy()
    {
      return $this->belongsTo(User::class, 'created_by');
    }
}
