<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\ParticipantNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Notifications\CustomVerifyEmail;
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
        $roles = ['admin', 'patron', 'research_assistant'];
        return view('admin.register_user', ['roles' => $roles]);
    }

    public function registerUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|in:admin,patron,research_assistant',
            ]);

            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            $user->save();

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
        ['content' => $request->input('content')]
    );

    
    return redirect()->back()->with('success', 'Text updated successfully!');
}
        
}
