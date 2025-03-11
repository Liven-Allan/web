<?php
namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ParticipantNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\DescriptionText;
use Illuminate\Support\Facades\Auth; // ✅ Import Authuse Illuminate\Support\Facades\Mail;
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
        'url' => 'nullable|url',
        'priority' => 'required|integer|in:1,2,3',
        'patron_id' => 'required|integer',
    ]);

    // Save the publication
    $publication = new Publication();
    $publication->title = $validatedData['title'];
    $publication->description = $validatedData['description'] ?? null;
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

    // Show the registration form with a pre-generated password
    public function showRegisterUserForm()
    {
        $roles = ['research_assistant'];
        $randomPassword = Str::random(10); // Generate a random 10-character password
        return view('patron.register_user', compact('roles', 'randomPassword'));
    }

    public function registerUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|in:admin,patron,research_assistant',
                'password' => 'required|string|min:6', // Add password validation
            ]);

            // Use the password from the form (already generated)
            $randomPassword = $validated['password'];
            
            // Create new user
            $user = new User();
            $user->name = $validated['name'];
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

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Ensure patrons cannot delete their own account
        if ($user->id == auth()->id()) {
            return redirect()->route('patron.users.list')->with('error', 'You cannot delete your own account.');
        }

        // Delete the user
        $user->delete();

        return redirect()->route('patron.users.list')->with('success', 'User deleted successfully.');
    }
 
    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'new-password' => 'required|min:6|confirmed', // Validation
        ]);

        // Update the password
        $user->password = Hash::make($request->input('new-password'));
        $user->password_changed = true; // Update the flag
        $user->save();

        return redirect()->route('patron.dashboard')->with('success', 'Password changed successfully.');
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
            ['content' => $request->content]
        );

        
        return redirect()->route('patron.dashboard')->with('success', 'text updated successfully!.');

    }
}


