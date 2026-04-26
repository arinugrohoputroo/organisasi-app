<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'session',
        'status',
        'recorded_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}