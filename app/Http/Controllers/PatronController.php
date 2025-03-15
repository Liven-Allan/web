<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\ParticipantNotification;
use Illuminate\Support\Facades\Mail;
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
    return redirect()->route('projects')->with('success', 'Project added successfully');
}


        public function index()
    {
        $projects = Project::all(); // Fetch all projects
    return view('projects.index', compact('projects'));
    }

    public function Pubdashboard()
    {
        // Retrieve projects from the database
        $projects = Project::orderBy('priority', 'desc')->get();

        // Pass projects data to the view
        return view('frontend.master', compact('projects'));
    }

    public function projects()
    {
        
         $projects = Project::orderBy('priority', 'desc')->get(); // Fetch projects
    return view('frontend.master', compact('projects'));

    //     // Fetch the top 4 projects, ordered by priority (highest first)
    // $projects = Project::orderBy('priority', 'desc')->limit(4)->get();

    // // Return the projects view with the data
    // return view('frontend.master', compact('projects'));
    }

    

    public function createTask()
    {
        return view('task.create');
    }  

    public function showRegisterUserForm()
    {
        $roles = ['research_assistant'];
        return view('patron.register_user', compact('roles'));
    }

    public function registerUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:admin,patron,research_assistant',
            ]);

            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->role = $validated['role'];
            $user->save();

            $emailData = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $validated['password'],
                'registered_by' => auth()->user()->name,
            ];

            Mail::to($user->email)->send(new ParticipantNotification($emailData));

            return redirect()->route('patron.users.list')->with('success', 'User registered successfully.');
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
