@extends('layouts.app')

@section('content')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h1>Gymate - Find Your Gym Bro</h1>
            <p>Join Gymate, the social network for fitness enthusiasts. Connect with like-minded gym buddies and never train alone again.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Sign Up Now</a>
        </div>
        <div class="col-md-6 mt-md-0 mt-4">
            <!-- Add an image related to Gymate here -->
            <img src="{{ asset('images/landing-page.jpeg') }}" class="img-fluid rounded" alt="Gymate">
        </div>
    </div>
</div>



<!-- Add floating gym buddy icon -->
<div class="gym-buddy-icon">🏋️</div>
@endsection
@endsection
