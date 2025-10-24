<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\ParticipantNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\DescriptionText;
use Illuminate\Support\Facades\Auth; // ✅ Import Authuse Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use App\Models\ActiveTask;
use App\Models\CompletedTask;


class PatronController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();
        
        // Retrieve projects from the database
        $projects = Project::orderBy('priority', 'desc')->get();
        
        // Calculate dashboard statistics
        $myProjectsCount = Project::where('patron_id', $userId)->count();
        
        // Completed tasks: tasks assigned by this patron that are in completed_tasks table
        $completedTasksCount = CompletedTask::whereHas('task', function($query) use ($userId) {
            $query->where('assigned_by', $userId);
        })->count();
        
        // Get completed task IDs to exclude from active count
        $completedTaskIds = CompletedTask::whereHas('task', function($query) use ($userId) {
            $query->where('assigned_by', $userId);
        })->pluck('task_id');
        
        // Active tasks: tasks assigned by this patron that are in active_tasks table but NOT completed
        $activeTasksCount = ActiveTask::whereHas('task', function($query) use ($userId) {
            $query->where('assigned_by', $userId);
        })->whereNotIn('task_id', $completedTaskIds)->count();
        
        // Research assistants count
        $researchAssistantsCount = User::where('role', 'research_assistant')->count();

        // Debug logging to help troubleshoot
        \Log::info('Patron dashboard counts for user ' . $userId, [
            'my_projects' => $myProjectsCount,
            'active_tasks' => $activeTasksCount,
            'completed_tasks' => $completedTasksCount,
            'research_assistants' => $researchAssistantsCount,
            'completed_task_ids' => $completedTaskIds->toArray()
        ]);

        // Pass data to the view
        return view('patron.dashboard', compact(
            'projects',
            'myProjectsCount',
            'activeTasksCount',
            'completedTasksCount',
            'researchAssistantsCount'
        ));
    }


    // public function dashboard()
    // {
    //     return view('patron.dashboard');
    // }

    // Method to show the create projects form
    public function createProject()
    {
        return view('projects.create'); // Render the create.blade.php view
    }

    public function storeProject(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'nullable|url',
            'priority' => 'required|integer|in:1,2,3',
            'patron_id' => 'required|integer',


        ]);
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        // Save the project
        $project = new Project();
        $project->title = $validatedData['title'];
        $project->description = $validatedData['description'] ?? null;
        // $imagePath = $request->file('image')->store('projects', 'public');
        $project->image = $imagePath;
        $project->url = $validatedData['url'] ?? null;
        $project->priority = $validatedData['priority'];
        $project->patron_id = $validatedData['patron_id'];


        $project->save(); // Save the project

        // Redirect to the projects route after saving the project
        return redirect()->route('Allprojects')->with('success', 'Project added successfully');
    }


    public function index()
    {
        $descriptionText = DescriptionText::latest()->first(); // Get the most recent hero text
        $projects = Project::all(); // Fetch all projects

        return view('projects.index', compact('projects', 'descriptionText'));
    }


    public function Pubdashboard()
    {
        // Retrieve projects from the database
        $projects = Project::orderBy('priority', 'desc')->get();
        

        // Pass projects data to the view
        return view('frontend.master', compact('projects'));
    }

    public function Allprojects()
    {
        // Get the latest description
        $descriptionText = DescriptionText::latest()->first(); 
        // Fetch 6 projects per page
        $projects = Project::orderBy('priority', 'desc')->paginate(8); 
        return view('frontend.projectspage', compact('projects' , 'descriptionText'));
    }



    public function edit(Project $project)
{
    // Check if the current user is the patron of the project
    if ($project->patron_id !== auth()->id()) {
        return redirect()->route('projects.index')->with('error', 'You are not authorized to edit this project.');
    }

    return view('projects.edit', compact('project'));
}

public function update(Request $request, Project $project)
{
    // Check if the current user is the patron of the project
    if ($project->patron_id !== auth()->id()) {
        return redirect()->route('projects.index')->with('error', 'You are not authorized to update this project.');
    }

    // Validate incoming request data
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'url' => 'nullable|url',
        'priority' => 'required|integer|in:1,2,3',
    ]);

    // If image is uploaded, store it
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('projects', 'public');
        $project->image = $imagePath;
    }

    // Update project fields
    $project->title = $validatedData['title'];
    $project->description = $validatedData['description'];
    $project->url = $validatedData['url'] ?? null;
    $project->priority = $validatedData['priority'];

    // Save changes
    $project->save();

    // Redirect back to the projects index with success message
    // return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    return redirect('/projects')->with('success', 'Project updated successfully.');

}

public function destroy(Project $project)
{
    // Check if the current user is the patron of the project
    if ($project->patron_id !== auth()->id()) {
        return redirect()->route('projects.index')->with('error', 'You are not authorized to delete this project.');
    }

    // Delete the project
    $project->delete();

    // Redirect back with success message
    // return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    return redirect('/projects')->with('success', 'Project updated successfully.');

}


    

    public function createTask()
    {
        return view('task.create');
    }

    public function showRegisterUserForm()
    {
        $roles = ['patron', 'research_assistant'];
        $randomPassword = Str::random(10); // Generate a random 10-character password
        return view('patron.register_user', compact('roles', 'randomPassword'));
    }

    public function registerUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|in:admin,patron,research_assistant',
                'password' => 'required|string|min:6', // Add password validation
            ]);

            // Use the password from the form (already generated)
            $randomPassword = $validated['password'];

            // Create new user
            $user = new User();
            $user->name = trim($validated['first_name'] . ' ' . $validated['last_name']);
            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->email = $validated['email'];
            $user->password = Hash::make($randomPassword); // Hash the generated password
            $user->role = $validated['role'];
            $user->save();

            // Prepare email data
            $emailData = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $randomPassword, // Send the plain password via email
                'registered_by' => auth()->user()->name,
            ];

            // Send the password via email
            Mail::to($user->email)->send(new ParticipantNotification($emailData));

            return redirect()->route('patron.users.list')->with('success', 'User registered successfully. Password sent via email.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listUsers()
    {
        $users = User::where('role', '!=', 'admin')
            ->orderByRaw("FIELD(role, 'patron') DESC")
            ->orderBy('name', 'ASC') // Optional: Additional ordering by name
            ->get();
        return view('patron.list', compact('users'));
    }

    public function updateDescriptionText(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $userId = Auth::id();

        // Check if the user already has a hero text entry
        DescriptionText::updateOrCreate(
            ['user_id' => $userId],
            ['content' => $request->input('content')]
        );


        return redirect()->route('patron.dashboard')->with('success', 'text updated successfully!.');

    }


    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Ensure patrons cannot delete themselves
        if ($user->id == auth()->id()) {
            return redirect()->route('patron.users.list')->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting admin users
        if ($user->role === 'admin') {
            return redirect()->route('patron.users.list')->with('error', 'Not authorized to delete admin users.');
        }

        // Hard delete
        $user->delete();

        return redirect()->route('patron.users.list')->with('success', 'User deleted successfully.');
    }

    public function disableUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id == auth()->id()) {
            return redirect()->route('patron.users.list')->with('error', 'You cannot disable your own account.');
        }
        if ($user->role === 'admin') {
            return redirect()->route('patron.users.list')->with('error', 'Not authorized to disable admin users.');
        }
        $user->status = 'disabled';
        $user->save();
        return redirect()->route('patron.users.list')->with('success', 'User disabled');
    }

    public function enableUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return redirect()->route('patron.users.list')->with('error', 'Not authorized to enable admin users.');
        }
        $user->status = 'active';
        $user->save();
        return redirect()->route('patron.users.list')->with('success', 'User enabled');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return redirect()->route('patron.users.list')->with('error', 'Not authorized to edit admin users.');
        }
        $roles = ['patron', 'research_assistant'];
        return view('patron.edit_user', compact('user', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return redirect()->route('patron.users.list')->with('error', 'Not authorized to edit admin users.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:patron,research_assistant',
            'password' => 'nullable|string|min:6',
            'contact' => 'nullable|string|max:255',
        ]);

        $user->name = trim((string) $request->input('first_name') . ' ' . (string) $request->input('last_name'));
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->contact = $validated['contact'] ?? $user->contact;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('patron.users.list')->with('success', 'User updated successfully.');
    }
}