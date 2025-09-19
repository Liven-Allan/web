<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        // Ensure the URL is valid and signed
        if (! URL::hasValidSignature($request)) {
            abort(403, 'Invalid or expired verification link.');
        }

        $user = User::findOrFail($request->route('id'));

        // If someone else is logged in (e.g., an admin testing links), log them out
        if (Auth::check() && Auth::id() !== $user->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        if ($user->password === null) {
            // Generate password reset token and redirect to reset page
            $token = Password::createToken($user);
            $resetUrl = URL::to('/reset-password/' . $token . '?email=' . urlencode($user->email));
            return redirect($resetUrl);
        }

        return redirect()->route('login');
    }
}