<?php

namespace App\Http\Controllers;

use App\Models\ProjectsDetails;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Word; //textsvg
use App\Models\ActiveTask;
use App\Models\CompletedTask;
use Illuminate\Support\Facades\DB;  // Import the DB facade
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignmentNotification;
use App\Models\Project;
use App\Models\DescriptionText;

class TemplateController extends Controller
{
    public function index()
    {
        // Get the latest description
        $descriptionText = DescriptionText::latest()->first(); 

         // Fetch the top 4 projects, ordered by priority (highest first)
    // $projects = Project::orderBy('priority', 'desc')->limit(4)->get();
    $projects = Project::orderBy('priority', 'asc')   // Order by priority in ascending order (lowest first)
    ->orderBy('created_at', 'desc')  // Then, order by creation date in ascending order (oldest first)
    ->limit(4)  
    ->get();

     return view('frontend.master', compact('projects', 'descriptionText'));



    }
    public function displayProjectdetails()
    {
        $descriptionText = DescriptionText::latest()->first(); // Get the latest description
        $ProjectsDetails = ProjectsDetails::first(); // Fetch the first project (modify as needed)
        return view('frontend.projects', compact('ProjectsDetails','descriptionText'));
    }



    public function createTask()
    {
        $role = auth()->user()->hasRole('admin') ? 'admin' : 'patron';

        // Fetch all users with the "research_assistant" role
        $researchAssistants = User::where('role', 'research_assistant')->get();

        return view('task.create', compact('role', 'researchAssistants'));
    }

    public function storeTask(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        // Save the task in the database
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'assigned_to' => $validated['assigned_to'],
            'assigned_by' => auth()->id(),
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
        ]);


        // Fetch the assigned user
        $assistant = User::find($validated['assigned_to']);

        if ($assistant) {
            // Prepare email data
            $emailData = [
                'name' => $assistant->name,
                'email' => $assistant->email,
                'task_title' => $task->title,
                'task_description' => $task->description ?? 'No description provided.',
                'priority' => ucfirst($task->priority),
                'due_date' => $task->due_date->format('Y-m-d'),
                'assigned_by' => auth()->user()->name,
            ];

            // Send email
            Mail::to($assistant->email)->send(new TaskAssignmentNotification($emailData));
        }

        // Redirect based on the role of the user
        $role = auth()->user()->role;
        if ($role == 'admin') {
            return redirect()->route('admin.task.list')->with('success', 'Task created successfully!');
        } elseif ($role == 'patron') {
            return redirect()->route('patron.task.list')->with('success', 'Task created successfully!');
        }

        // Fallback redirect if role is unrecognized (optional)
        return redirect()->route('task.list')->with('success', 'Task created successfully!');
    }

    public function listTasks()
    {
        $tasks = Task::all();
        $role = auth()->user()->role;

        return view('task.list', compact('tasks', 'role'));
    }

    public function edit(Task $task)
    {
        $role = auth()->user()->role; // Get the role from the logged-in user
        $users = User::where('role', 'research_assistant')->get();
        return view('task.edit', compact('task', 'role', 'users')); // Use 'task.edit'
    }


    public function update(Request $request, Task $task)
    {
        // \Log::info($request->all()); // Log request data
        $role = auth()->user()->role;

        // Ensure only allowed roles can update tasks
        if (!in_array($role, ['admin', 'patron'])) {
            return back()->with('error', 'You are not authorized to perform this action.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date',
        ]);

        try {
            $task->update($data);
            // Get the role of the authenticated user
            $role = auth()->user()->role;

            return redirect()->route($role . '.task.list')->with('success', 'Task updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update task: ' . $e->getMessage());
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return redirect()->back()->with('success', 'Task deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete task: ' . $e->getMessage());
        }
    }

    // research assisant view tasks
    public function listTasksForResearchAssistant()
    {
        $tasks = Task::where('assigned_to', auth()->user()->id)
            ->with('activeTask') // Load related active task
            ->get();

        return view('task.list', [
            'tasks' => $tasks,
            'role' => 'research_assistant',
        ]);
    }


    // Research assistant task activation
    public function activateTask(Request $request, Task $task)
    {
        // Ensure the task is assigned to the currently authenticated research assistant
        if ($task->assigned_to !== auth()->user()->id) {
            return back()->with('error', 'You are not authorized to activate this task.');
        }

        // Check if the task is already activated
        $existingActiveTask = ActiveTask::where('task_id', $task->id)
            ->where('assigned_to', $task->assigned_to)
            ->first();

        if ($existingActiveTask) {
            return back()->with('error', 'Task already activated.');
        }

        // Create a new ActiveTask record
        ActiveTask::create([
            'task_id' => $task->id,
            'assigned_to' => $task->assigned_to,
            'assigned_by' => $task->assigned_by,
            'progress' => 0, // Default progress as 0%
        ]);

        return back()->with('success', 'Task activated successfully!');
    }

    // Research assistant active tasks
    public function listActiveTasks()
    {
        // Fetch active tasks assigned to the current user
        $activeTasks = ActiveTask::where('assigned_to', auth()->user()->id)->with(['task', 'assignedBy'])->get();

        return view('research_assistant.active_tasks', [
            'activeTasks' => $activeTasks,
        ]);
    }

    // admin and patron view active tasks
    public function listAdminActiveTasks()
    {
        $activeTasks = ActiveTask::with(['task', 'assignedTo', 'assignedBy'])->get();
        return view('admin.active_tasks', ['activeTasks' => $activeTasks]);
    }

    public function listPatronActiveTasks()
    {
        $activeTasks = ActiveTask::with(['task', 'assignedTo', 'assignedBy'])->get();
        return view('patron.active_tasks', ['activeTasks' => $activeTasks]);
    }

    // comment
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Find the ActiveTask by ID and update the comment
        $activeTask = ActiveTask::findOrFail($id);
        $activeTask->comment = $request->comment;
        $activeTask->save();

        // Check the role of the user and redirect accordingly
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.active_tasks')->with('success', 'Comment added successfully!');
        } elseif (auth()->user()->hasRole('patron')) {
            return redirect()->route('patron.active_tasks')->with('success', 'Comment added successfully!');
        }

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    // task progress control
    public function recordProgress($id)
    {
        $activeTask = ActiveTask::findOrFail($id);

        // Check if the user is authorized to update the task
        if ($activeTask->assigned_to != auth()->user()->id) {
            return back()->with('error', 'You are not authorized to update this task.');
        }

        return view('research_assistant.record_progress', [
            'activeTask' => $activeTask,
        ]);
    }
    public function updateProgress(Request $request, $id)
    {
        $activeTask = ActiveTask::findOrFail($id);

        // Check if the user is authorized to update the task
        if ($activeTask->assigned_to != auth()->user()->id) {
            return back()->with('error', 'You are not authorized to update this task.');
        }

        // Validate and update progress
        $request->validate([
            'progress' => 'required|numeric|min:0|max:100',
        ]);

        $activeTask->update(['progress' => $request->progress]);

        return redirect()->route('research_assistant.active_tasks')->with('success', 'Task progress updated successfully!');
    }

    // Task completion 
    public function confirmTaskCompletion($id)
    {
        // Start a transaction
        DB::beginTransaction();

        try {
            // Get the active task along with its related task
            $activeTask = ActiveTask::with('task')->findOrFail($id);

            // Check if the task is already in the CompletedTask model
            $completedTask = CompletedTask::where('task_id', $activeTask->task->id)->first();

            if ($completedTask) {
                // If the task is already marked as completed, show an error message
                $route = auth()->user()->hasRole('admin') ? 'admin.active_tasks' : 'patron.active_tasks';
                return redirect()->route($route)->with('error', 'This task has already been marked as completed.');
            }

            // Check if the task status is "completed"
            if ($activeTask->task->status === 'completed') {
                // Transfer the task to the CompletedTask model
                CompletedTask::create([
                    'task_id' => $activeTask->task->id,
                    'assigned_to' => $activeTask->assigned_to,
                    'assigned_by' => $activeTask->assigned_by,
                    'progress' => $activeTask->progress,
                    'comment' => $activeTask->comment,
                ]);

                // Commit the transaction
                DB::commit();

                // Redirect back with success message
                $route = auth()->user()->hasRole('admin') ? 'admin.active_tasks' : 'patron.active_tasks';
                return redirect()->route($route)->with('success', 'Task marked as completed and saved.');
            }

            // If the task status is not "completed"
            $route = auth()->user()->hasRole('admin') ? 'admin.active_tasks' : 'patron.active_tasks';
            return redirect()->route($route)->with('error', 'The task is not marked as completed.');

        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollBack();

            // Log the exception or return a failure message
            $route = auth()->user()->hasRole('admin') ? 'admin.active_tasks' : 'patron.active_tasks';
            return redirect()->route($route)->with('error', 'Something went wrong. Please try again later.');
        }
    }

   
    public function peoplepage()
    {
        $users = User::orderByRaw("FIELD(role, 'admin', 'patron', 'research_assistant')")->get();
        return view('frontend.peoplepage', compact('users'));
    }
    
    public function publications()
    {
        return view('frontend.publications');
    }

    public function courses()
    {
        return view('frontend.courses');
    }

    public function news()
    {
        return view('frontend.news');
    }

    public function events()
    {
        return view('frontend.events');
    }

}
