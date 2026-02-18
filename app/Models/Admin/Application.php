<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
  use HasFactory, SoftDeletes;
  protected $guarded = [];
  public $timestamps = true;

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

    public function applicant()
  {
    return $this->belongsTo(Applicant::class, 'applicant_id');
  }

  public function job()
  {
    return $this->belongsTo(CompanyJob::class, 'job_id');
  }

  public function applicationStatus()
  {
    return $this->belongsTo(ApplicationStatus::class, 'status', 'status_order');
  }

}
