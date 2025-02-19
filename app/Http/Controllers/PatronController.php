<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ParticipantNotification;
use Illuminate\Support\Facades\Mail;

class PatronController extends Controller
{
    public function dashboard(){
        return view('patron.dashboard');
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
}
