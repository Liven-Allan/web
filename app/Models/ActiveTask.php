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
        static::created(function ($activeTask) {
            // When an active task is created, update the main task status to pending
            $task = $activeTask->task;
            if ($task) {
                $task->status = 'pending';
                $task->save();
                \Log::info("Task ID {$task->id} activated and status set to pending");
            }
        });

        static::updated(function ($activeTask) {
            $task = $activeTask->task;
    
            if ($task) {
                $progress = $activeTask->progress;
                $oldStatus = $task->status;
                $newStatus = $oldStatus;
    
                // Determine new status based on progress
                if ($progress >= 0 && $progress <= 49) {
                    $newStatus = 'pending';
                } elseif ($progress >= 50 && $progress <= 94) {
                    $newStatus = 'in_progress';  
                } elseif ($progress >= 95 && $progress <= 100) {
                    $newStatus = 'completed';
                }
    
                // Only update if status actually changed
                if ($newStatus !== $oldStatus) {
                    $task->status = $newStatus;
                    $task->save();
                    
                    \Log::info("Task status updated via progress change", [
                        'task_id' => $task->id,
                        'old_status' => $oldStatus,
                        'new_status' => $newStatus,
                        'progress' => $progress
                    ]);
                }
            }
        });
    }
    

    

}
