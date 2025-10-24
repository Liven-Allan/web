<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'assigned_by',
        'priority',
        'status',
        'due_date',
    ];

    // Relationships
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
    
    // In Task.php
    protected $casts = [
       'due_date' => 'datetime',
    ];
    
    public function activeTask()
    {
        return $this->hasOne(ActiveTask::class, 'task_id');
    }

    // Get the computed status based on active task progress
    public function getComputedStatusAttribute()
    {
        $activeTask = $this->activeTask;

        if (!$activeTask) {
            return 'not_started'; // Default if no active task
        }

        $progress = $activeTask->progress;

        if ($progress >= 0 && $progress <= 49) {
            return 'pending';
        } elseif ($progress >= 50 && $progress <= 94) {
            return 'in_progress';
        } elseif ($progress >= 95 && $progress <= 100) {
            return 'completed';
        }

        return 'unknown'; // Fallback
    }


}
