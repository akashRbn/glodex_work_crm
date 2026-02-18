<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $guarded = [];
    public $timestamps = true;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
