<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\ParticipantNotification;
use Illuminate\Support\Facades\Mail;
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
          $roles = ['patron', 'research_assistant'];
          return view('admin.register_user', compact('roles'));
      }
      

public function registerUser(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,patron,research_assistant',
    ]);

    // Explicitly set the role to avoid accidental overriding
    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->password = Hash::make($validated['password']);
    $user->role = $validated['role']; // Ensure this is stored correctly
    $user->save();


 
    $emailData = [
        'name' => $user->name,
        'email' => $user->email,
        'password' => $validated['password'], // Correct key here
        'registered_by' => auth()->user()->name,
    ];
    
    Mail::to($user->email)->send(new ParticipantNotification($emailData));
    
    // Redirect to the user list page with a success message
    return redirect()->route('admin.users.list')->with('success', 'User registered successfully.');
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

    // Delete the user
    $user->delete();

    return redirect()->route('admin.users.list')->with('success', 'User deleted successfully');
}


        
}
