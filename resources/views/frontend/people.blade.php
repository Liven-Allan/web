@extends('frontend.master')

@section('content')
    <div class="container py-5">
        <h1 class="text-center mb-5">Our Research Team</h1>

        <div class="row">
            @foreach($users as $user)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded-circle mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <p class="card-text">{{ $user->email }}</p>
                            @if($user->contact)
                                <p class="card-text"><small class="text-muted">Contact: {{ $user->contact }}</small></p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection