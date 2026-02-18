<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\ParticipantNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\DescriptionText;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CustomVerifyEmail;
use App\Models\Project;
class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
      }
      
    public function createTask()
      {
          return view('task.create'); 
      }  

      public function showRegisterUserForm()
      {
          $roles = ['admin', 'patron', 'research_assistant'];
         // $randomPassword = Str::random(10); // Generate a random 10-character password
          //return view('admin.register_user', compact('roles', 'randomPassword'));
           return view('admin.register_user', ['roles' => $roles]);
      }
      

      public function registerUser(Request $request)
      {
          try {
              $validated = $request->validate([
                  'first_name' => 'required|string|max:255',
                  'last_name' => 'required|string|max:255',
                  'email' => 'required|email|unique:users,email',
                  'role' => 'required|in:admin,patron,research_assistant',
                  //'password' => 'required|string|min:6', // Add password validation
              ]);
  
              // Use the password from the form (already generated)
             // $randomPassword = $validated['password'];
              
              // Create new user
              $user = new User();
              $user->name = trim($validated['first_name'] . ' ' . $validated['last_name']);
              $user->first_name = $validated['first_name'];
              $user->last_name = $validated['last_name'];
              $user->email = $validated['email'];
             // $user->password = Hash::make($randomPassword); // Hash the generated password
              $user->role = $validated['role'];
              $user->save();
  
              // Prepare email data
            //   $emailData = [
            //       'name' => $user->name,
            //       'email' => $user->email,
            //       //'password' => $randomPassword, // Send the plain password via email
            //       'registered_by' => auth()->user()->name,
            //   ];
  
              // Send the password via email
              //Mail::to($user->email)->send(new ParticipantNotification($emailData));
  
              //return redirect()->route('admin.users.list')->with('success', 'User registered successfully. Password sent via email.');
               $user->notify(new CustomVerifyEmail(auth()->user()->name ?? 'Admin'));

            return redirect()->route('admin.users.list')->with('success', 'User registered successfully. Verification email sent.');
            } catch (\Exception $e) {
              return response()->json(['error' => $e->getMessage()], 500);
          }
      }
        public function listUsers()
        {
            // Retrieve all users and order them by role (admin > patron > research_assistant) and name
            $users = User::orderByRaw("FIELD(role, 'admin', 'patron', 'research_assistant') ASC")
                        ->orderBy('name', 'ASC')
                        ->get();

            return view('admin.list', compact('users'));
        }

        public function deleteUser($id)
        {
            $user = User::findOrFail($id);

            // Ensure the admin cannot delete themselves
            if ($user->id == auth()->id()) {
                return redirect()->route('admin.users.list')->with('error', 'You cannot delete your own account.');
            }

            // Hard delete
            $user->delete();

            return redirect()->route('admin.users.list')->with('success', 'User deleted successfully');
        }

        public function disableUser($id)
        {
            $user = User::findOrFail($id);
            if ($user->id == auth()->id()) {
                return redirect()->route('admin.users.list')->with('error', 'You cannot disable your own account.');
            }
            $user->status = 'disabled';
            $user->save();
            return redirect()->route('admin.users.list')->with('success', 'User disabled');
        }

        public function enableUser($id)
        {
            $user = User::findOrFail($id);
            $user->status = 'active';
            $user->save();
            return redirect()->route('admin.users.list')->with('success', 'User enabled');
        }

public function updateDescription(Request $request)
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

    
    return redirect()->back()->with('success', 'Text updated successfully!');
}
    
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $roles = ['admin', 'patron', 'research_assistant'];
        return view('admin.edit_user', compact('user', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,patron,research_assistant',
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

        return redirect()->route('admin.users.list')->with('success', 'User updated successfully');
    }

    // Project Management Methods
    public function createProject()
    {
        return view('projects.create');
    }

    public function storeProject(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'nullable|url',
            'priority' => 'required|integer|in:1,2,3',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        $project = new Project();
        $project->title = $validatedData['title'];
        $project->description = $validatedData['description'] ?? null;
        $project->image = $imagePath;
        $project->url = $validatedData['url'] ?? null;
        $project->priority = $validatedData['priority'];
        $project->patron_id = auth()->id(); // Admin becomes the patron
        $project->save();

        return redirect()->route('admin.projects')->with('success', 'Project created successfully');
    }

    public function projects()
    {
        $projects = Project::orderBy('priority', 'desc')->get();
        return view('admin.projects', compact('projects'));
    }

    public function editProject(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function updateProject(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'nullable|url',
            'priority' => 'required|integer|in:1,2,3',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
            $project->image = $imagePath;
        }

        $project->title = $validatedData['title'];
        $project->description = $validatedData['description'];
        $project->url = $validatedData['url'] ?? null;
        $project->priority = $validatedData['priority'];
        $project->save();

        return redirect()->route('admin.projects')->with('success', 'Project updated successfully');
    }

    public function destroyProject(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects')->with('success', 'Project deleted successfully');
    }
        
}
