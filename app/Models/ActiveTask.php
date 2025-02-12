<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveTask extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'active_tasks';

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

    protected static function booted()
    {
        static::updated(function ($activeTask) {
            $task = $activeTask->task;
    
            if ($task) {
                $progress = $activeTask->progress;
    
                if ($progress >= 0 && $progress <= 49) {
                    $task->status = 'pending';
                } elseif ($progress >= 50 && $progress <= 94) {
                    $task->status = 'in_progress';  
                } elseif ($progress >= 95 && $progress <= 100) {
                    $task->status = 'completed';
                }
    
                // Debugging: Log the status before saving
                \Log::info("Updating task ID {$task->id} status to: {$task->status}");
    
                // Save the task
                $task->save();
            }
        });
    }
    

    

}
