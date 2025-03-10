<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ResearchAssistantController extends Controller
{
    public function dashboard(){
          // Check if user needs to change password
          $user = auth()->user();

            // Assuming you have a column 'password_changed' in your users table
        // If the user is new or hasn't changed their password yet, send a flag
        $needsPasswordChange = $user->password_changed; // Or check other criteria like password reset flag

        return view('research_assistant.dashboard', compact('needsPasswordChange'));
    
      }
      public function changePassword(Request $request)
      {
          $user = auth()->user();
      
          // Validate the new password input
          $request->validate([
              'new-password' => 'required|min:6|confirmed', // Ensure password is at least 6 characters and matches the confirmation
          ]);
      
          // Hash the password
          $user->password = Hash::make($request->input('new-password')); 
          $user->password_changed = 1; // Set the password_changed flag to 1 (indicating password is changed)
          
          // Debugging: Log the user data before saving
          \Log::info('User before saving: ', $user->toArray());
      
          // Save the user data
          $user->save();
      
          // Debugging: Log the user data after saving
          \Log::info('User after saving: ', $user->toArray());
      
          // Redirect the user with a success message
          return redirect()->route('research_assistant.dashboard')->with('success', 'Password changed successfully.');
      }
    }