@extends('layouts.app-admin')

@section('title', 'Register User')

<style>
    body {
        color: black !important;
    }

   
</style>

@section('content')
<h1>Register User</h1>

<form action="{{ route(auth()->user()->role . '.register_user.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
   
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-control" id="role" name="role" required>
            @foreach ($roles as $role)
                <option value="{{ $role }}">{{ ucfirst($role) }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>
@endsection
