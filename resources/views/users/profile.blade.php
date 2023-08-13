@extends('layouts.app')

@section('content')
    @if($user->profile_completed)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center text-primary">Profile Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if ($user->profile_image)
                                    <img src="{{ asset('storage/images/profile/' . $user->profile_image) }}" alt="Profile Image" class="img-fluid mb-3">
                                @else
                                    <img src="{{ asset('images/default-profile-image.png') }}" alt="Default Profile Image" class="img-fluid mb-3">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <p><strong>Name:</strong> {{ $user->name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Location:</strong> {{ $user->location ?: 'N/A' }}</p>
                                <p><strong>About Me:</strong> {{ $user->about_me ?: 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-title mt-2">
                            <h3 class="text-center text-primary">Complete your profile</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('users.complete_profile') }}" enctype="multipart/form-data">
                                @csrf
        
                                <div class="form-group">
                                    <label for="profile_image">Profile Image:</label>
                                    <input type="file" id="profile_image" name="profile_image" class="form-control-file">
                                </div>
        
                                <div class="form-group">
                                    <label for="location">Location:</label>
                                    <input type="text" id="location" name="location" class="form-control">
                                </div>
        
                                <div class="form-group">
                                    <label for="about_me">About Me:</label>
                                    <textarea id="about_me" name="about_me" class="form-control"></textarea>
                                </div>
        
                                <button type="submit" class="btn btn-primary mt-2">Save</button>
                            </form>
                            @if(session('success'))
                                <div class="alert alert-success mt-3">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection