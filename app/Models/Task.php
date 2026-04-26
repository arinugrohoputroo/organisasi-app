<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'division_id',
        'due_date',
        'created_by'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submissions()
    {
    return $this->hasMany(\App\Models\TaskSubmission::class);
    }

    public static function boot()
    {
    parent::boot();

    static::deleting(function ($task) {
        $task->submissions()->delete();
    });
    }
}
