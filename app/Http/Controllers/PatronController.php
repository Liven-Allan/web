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


class PatronController extends Controller
{
    public function dashboard()
    {
        // Retrieve projects from the database
        $projects = Project::orderBy('priority', 'desc')->get();
        

        // Pass projects data to the view
        return view('patron.dashboard', compact('projects'));

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
        return view('patron.register_user', compact('roles'));
    }

    public function registerUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|in:patron,research_assistant',
            ]);

            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            $user->save();

            // Send verification email
            $user->notify(new \App\Notifications\CustomVerifyEmail(auth()->user()->name ?? 'Patron'));

            return redirect()->route('patron.users.list')->with('success', 'User registered successfully. Verification email sent.');
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

        $user = Auth::user();

        // Check if the user already has a hero text entry
        DescriptionText::updateOrCreate(
            ['user_id' => $user->id],
            ['content' => $request->input('content')]
        );


        return redirect()->route('patron.dashboard')->with('success', 'text updated successfully!.');

    }


    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Ensure patrons cannot delete other users
        if ($user->id == auth()->id()) {
            return redirect()->route('patron.users.list')->with('error', 'You cannot delete your own account.');
        }

        // Delete the user
        $user->delete();

        return redirect()->route('patron.users.list')->with('success', 'User deleted successfully.');
    }
}