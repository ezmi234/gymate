@extends('layouts.app')

@section('content')

<style>
    .posts-container {
        max-height: 80vh;
        overflow-y: auto;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset('images/jk-placeholder-image.jpg') }}" alt="Your Image" class="img-fluid">
                <div class="card-body">
                    <h5 class="card-title">John Doe</h5>
                    <p class="card-text">Web Developer</p>
                    <p class="card-text">Location: New York</p>
                    <p class="card-text">Joined: January 2022</p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">About Me</h5>
                    <p class="card-text">I'm a passionate web developer with experience in building web applications using Laravel and Bootstrap. In my free time, I enjoy hiking and photography.</p>
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-md-0 mt-3">
            <div class="card">
                <div class="card-body posts-container">
                    <h5 class="card-title">Posts</h5>
                    <div class="card-text">
                        <div class="media mb-3">
                            <img src="{{ asset('images/jk-placeholder-image.jpg') }}" alt="Your Image" class="img-fluid">
                            <div class="media-body">
                                <h6 class="mt-0">Great day outdoors!</h6>
                                <p>Just came back from an amazing hiking trip. The views were breathtaking!</p>
                            </div>
                        </div>
                        <div class="media">
                            <img src="{{ asset('images/jk-placeholder-image.jpg') }}" alt="Your Image" class="img-fluid">
                            <div class="media-body">
                                <h6 class="mt-0">New coding project in the works.</h6>
                                <p>Excited to start working on my new web app idea using Laravel and Bootstrap.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection