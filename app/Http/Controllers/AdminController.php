<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\ParticipantNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\DescriptionText;
use Illuminate\Support\Facades\Auth;
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
          $randomPassword = Str::random(10); // Generate a random 10-character password
          return view('admin.register_user', compact('roles', 'randomPassword'));
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
  
              return redirect()->route('admin.users.list')->with('success', 'User registered successfully. Password sent via email.');
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

    // Delete the user
    $user->delete();

    return redirect()->route('admin.users.list')->with('success', 'User deleted successfully');
}

public function updateDescription(Request $request)
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

    
    return redirect()->back()->with('success', 'Text updated successfully!');
}
        
}
