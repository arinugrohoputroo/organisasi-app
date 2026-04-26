<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['name', 'created_by'];

    public function users()
    {
    return $this->belongsToMany(User::class)
        ->withPivot('assigned_by')
        ->withTimestamps();
    }
}
