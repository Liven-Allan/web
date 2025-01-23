<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedTask extends Model
{
    use HasFactory;

    protected $table = 'completed_tasks'; // Assuming table name is 'completed_tasks'

    // Mass-assignable attributes
    protected $fillable = [
        'task_id',
        'assigned_to',
        'assigned_by',
        'progress',
        'comment',
    ];

    protected $casts = [
        'progress' => 'integer', // Cast to integer
    ];

    // Define relationships
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

}
