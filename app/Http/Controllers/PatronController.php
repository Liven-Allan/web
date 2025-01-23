<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PatronController extends Controller
{
    public function dashboard(){
        return view('patron.dashboard');
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
      
          // Redirect to the user list page with a success message
          return redirect()->route('patron.users.list')->with('success', 'User registered successfully.');
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
