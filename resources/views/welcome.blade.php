@extends('layouts.app')

@section('content')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h1>Gymate - Find Your Gym Bro</h1>
            <p>Join Gymate, the social network for fitness enthusiasts. Connect with like-minded gym buddies and never train alone again.</p>
            <a href="#" class="btn btn-primary btn-lg">Sign Up Now</a>
        </div>
        <div class="col-md-6">
            <!-- Add an image related to Gymate here -->
            <!-- Example: <img src="gymate-logo.png" alt="Gymate Logo"> -->
        </div>
    </div>
</div>

<!-- Add animated bubbles -->
<div class="bubble-container">
    @for($i = 0; $i < 15; $i++)
    <div class="bubble" style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; width: {{ rand(20, 50) }}px; height: {{ rand(20, 50) }}px;"></div>
    @endfor
</div>

<!-- Add floating gym buddy icon -->
<div class="gym-buddy-icon">🏋️</div>
@endsection
@endsection