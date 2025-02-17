@extends('layouts.app-admin')

@section('title', 'User Profile')

@section('content')
    <div class="container-fluid">

        <!-- Success Message for Profile Update at the Top -->
        @if (session('status') === 'profile-updated')
            <div id="success-alert-profile" class="alert alert-success">
                {{ __('Your profile has been updated successfully!') }}
            </div>
        @endif

        <!-- Success Message for Password Update at the Top -->
        @if (session('status') === 'password-updated')
            <div id="success-alert-password" class="alert alert-success">
                {{ __('Your password has been updated successfully!') }}
            </div>
        @endif

        <h1 class="h3 mb-4 text-gray-800">User Profile</h1>

        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Update Profile Information</h6>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Update Password</h6>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Delete Account</h6>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Auto-Dismiss -->
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

            }, 3000); // 3 seconds delay
        });
    </script>

@endsection
