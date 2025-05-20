@extends('layouts.app-admin')

@section('title', 'User Profile')

@section('content')
    <div class="container-fluid">
        <!-- Success Messages -->
        @if (session('status') === 'profile-updated')
            <div id="success-alert-profile" class="alert alert-success">
                {{ __('Your profile has been updated successfully!') }}
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div id="success-alert-password" class="alert alert-success">
                {{ __('Your password has been updated successfully!') }}
            </div>
        @endif

        <h1 class="h3 mb-4 text-gray-800">User Profile</h1>

        <div class="row">
            <!-- Profile Information Form -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Update Profile Information</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input id="name" name="name" type="text" class="form-control"
                                    value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="contact">{{ __('Contact') }}</label>
                                <input id="contact" name="contact" type="text" class="form-control"
                                    value="{{ old('contact', $user->contact) }}">
                                @error('contact')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

            


                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input id="email" name="email" type="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                                            <div class="form-group">
                                <label for="about">{{ __('About') }}</label>
                                <textarea id="about" name="about" class="form-control" rows="4">{{ old('about', $user->About) }}</textarea>
                                @error('about')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="profile_picture">{{ __('Profile Picture') }}</label>
                                <div class="text-center mb-3">
                                    <img id="preview"
                                        src="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : asset('img/default-profile.png') }}"
                                        alt="Profile Picture" class="rounded-circle mb-2" width="120" height="120">
                                </div>
                                <input id="profile_picture" name="profile_picture" type="file" class="form-control"
                                    accept="image/*" onchange="previewImage(event)">
                                @error('profile_picture')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Save Changes') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Password Update Form -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Update Password</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="current_password">{{ __('Current Password') }}</label>
                                <input id="current_password" name="current_password" type="password" class="form-control"
                                    autocomplete="current-password">
                                @error('current_password', 'updatePassword')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('New Password') }}</label>
                                <input id="password" name="password" type="password" class="form-control"
                                    autocomplete="new-password">
                                @error('password', 'updatePassword')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control" autocomplete="new-password">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Update Password') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Auto-Dismiss and Image Preview -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(function () {
                let profileAlert = document.getElementById("success-alert-profile");
                let passwordAlert = document.getElementById("success-alert-password");

                if (profileAlert) {
                    profileAlert.style.transition = "opacity 0.5s";
                    profileAlert.style.opacity = "0";
                    setTimeout(() => profileAlert.remove(), 500);
                }

                if (passwordAlert) {
                    passwordAlert.style.transition = "opacity 0.5s";
                    passwordAlert.style.opacity = "0";
                    setTimeout(() => passwordAlert.remove(), 500);
                }
            }, 3000);
        });

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection