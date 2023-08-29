@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-title mt-2">
                    <h3 class="text-center text-primary">Edit Your Profile</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="profile_image">Profile Image:</label>
                            <input type="file" id="profile_image" name="profile_image" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="location">Location:</label>
                            <input type="text" id="location" name="location" class="form-control" value="{{ $user->location }}">
                        </div>

                        <div class="form-group">
                            <label for="about_me">About Me:</label>
                            <textarea id="about_me" name="about_me" class="form-control">{{ $user->about_me }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Update</button>
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

@endsection
