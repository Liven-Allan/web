<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-8">
        <div class="w-full max-w-md bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-900 text-center">Set Your Password</h1>
            <p class="mt-2 text-sm text-gray-600 text-center">
                Welcome! You’ve verified your email. Please set a new password to secure your account.
            </p>

            @if (session('status'))
                <div class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-800">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-6" aria-label="Set Password Form">
                @csrf
                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                           aria-describedby="email-help" readonly />
                    <p id="email-help" class="mt-1 text-xs text-gray-500">This email is pre-filled from your verification and cannot be changed.</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                           aria-describedby="password-help" />
                    <p id="password-help" class="mt-1 text-xs text-gray-500">Use at least 8 characters, including letters, numbers, and a special character (e.g., @#&).</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                </div>

                <button type="submit"
                        class="w-full block px-4 py-2 mt-6 text-black bg-indigo-600 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        style="color: black !important; background-color: #4b5e9d !important;">
                    Save Password
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Back to login</a>
            </div>
        </div>
    </div>
</x-guest-layout>