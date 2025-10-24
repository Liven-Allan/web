<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\ActiveTask;
use App\Models\CompletedTask;

class ResearchAssistantController extends Controller
{
    public function dashboard(){
        // Check if user needs to change password
        $user = auth()->user();
        $userId = $user->id;

        // Check password change requirement
        $needsPasswordChange = $user->password_changed; // Or check other criteria like password reset flag

        // Calculate task counts for the logged-in research assistant
        $assignedTasksCount = Task::where('assigned_to', $userId)->count();
        
        // Get completed task IDs to exclude from active count
        $completedTaskIds = CompletedTask::where('assigned_to', $userId)->pluck('task_id');
        
        // Active tasks are those that have been activated but NOT completed
        $activeTasksCount = ActiveTask::where('assigned_to', $userId)
                                     ->whereNotIn('task_id', $completedTaskIds)
                                     ->count();
        
        // Completed tasks are those in the completed_tasks table
        $completedTasksCount = CompletedTask::where('assigned_to', $userId)->count();

        // Additional debugging to understand the data
        $allActiveTasks = ActiveTask::where('assigned_to', $userId)->with('task')->get();
        $allCompletedTasks = CompletedTask::where('assigned_to', $userId)->with('task')->get();
        
        // Debug logging to help troubleshoot
        \Log::info('Dashboard counts for user ' . $userId, [
            'assigned_tasks' => $assignedTasksCount,
            'active_tasks' => $activeTasksCount,
            'completed_tasks' => $completedTasksCount,
            'completed_task_ids' => $completedTaskIds->toArray(),
            'active_tasks_details' => $allActiveTasks->map(function($at) {
                return [
                    'id' => $at->id,
                    'task_id' => $at->task_id,
                    'task_title' => $at->task->title ?? 'N/A',
                    'task_status' => $at->task->status ?? 'N/A',
                    'progress' => $at->progress
                ];
            }),
            'completed_tasks_details' => $allCompletedTasks->map(function($ct) {
                return [
                    'id' => $ct->id,
                    'task_id' => $ct->task_id,
                    'task_title' => $ct->task->title ?? 'N/A'
                ];
            })
        ]);

        // Get recent tasks for display
        $recentTasks = Task::where('assigned_to', $userId)
                          ->orderBy('created_at', 'desc')
                          ->take(5)
                          ->get();

        return view('research_assistant.dashboard', compact(
            'needsPasswordChange',
            'assignedTasksCount',
            'activeTasksCount', 
            'completedTasksCount',
            'recentTasks'
        ));
    }
      public function changePassword(Request $request)
      {
          $user = auth()->user();
      
          // Validate the new password input
          $request->validate([
              'new-password' => 'required|min:6|confirmed', // Ensure password is at least 6 characters and matches the confirmation
          ]);
      
          // Hash the password
          $user->password = Hash::make($request->input('new-password')); 
          $user->password_changed = 1; // Set the password_changed flag to 1 (indicating password is changed)
          
          // Debugging: Log the user data before saving
          \Log::info('User before saving: ', $user->toArray());
      
          // Save the user data
          $user->save();
      
          // Debugging: Log the user data after saving
          \Log::info('User after saving: ', $user->toArray());
      
          // Redirect the user with a success message
          return redirect()->route('research_assistant.dashboard')->with('success', 'Password changed successfully.');
      }
    }