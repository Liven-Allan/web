<?php
namespace App\Http\Controllers;

use App\Models\Publication;
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
        // Retrieve publications from the database
        $publications = Publication::orderBy('priority', 'desc')->get();

        // Pass publications data to the view
        return view('patron.dashboard', compact('publications'));
    }
    

    // public function dashboard()
    // {
    //     return view('patron.dashboard');
    // }

    // Method to show the create publication form
    public function createPublication()
    {
        return view('publications.create'); // Render the create.blade.php view
    }

    public function storePublication(Request $request)
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
        $imagePath = $request->file('image')->store('publications', 'public');
    }

    // Save the publication
    $publication = new Publication();
    $publication->title = $validatedData['title'];
    $publication->description = $validatedData['description'] ?? null;
    $imagePath = $request->file('image')->store('publications', 'public');
    $publication->image = $imagePath; 
    $publication->url = $validatedData['url'] ?? null;
    $publication->priority = $validatedData['priority'];
    $publication->patron_id = $validatedData['patron_id'];
   

    $publication->save(); // Save the publication

    // Redirect to the publications route after saving the publication
    return redirect()->route('publications')->with('success', 'Publication added successfully');
}

        public function index()
    {
        $publications = Publication::all(); // Fetch all publications
    return view('publications.index', compact('publications'));
    }

    public function Pubdashboard()
    {
        // Retrieve publications from the database
        $publications = Publication::orderBy('priority', 'desc')->get();

        // Pass publications data to the view
        return view('frontend.master', compact('publications'));
    }

    public function publications()
    {
        // // Fetch the publications and pass them to the view
        // $publications = Publication::orderBy('priority', 'desc')->get();

        // // Return the publications view
        // return view('frontend.master', compact('publications'));

        // Fetch the top 4 publications, ordered by priority (highest first)
    $publications = Publication::orderBy('priority', 'desc')->limit(4)->get();

    // Return the publications view with the data
    return view('frontend.master', compact('publications'));
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
