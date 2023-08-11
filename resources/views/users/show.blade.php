@extends('layouts.app')

@section('content')

<style>
    .posts-container {
        max-height: 80vh;
        overflow-y: auto;
    }
</style>

<div class="modal fade" id="followersModal" tabindex="-1" role="dialog" aria-labelledby="followersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followersModalLabel">Followers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach ($user->followers as $follower)
                    @include('users.card', ['user' => $follower])
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="followsModal" tabindex="-1" role="dialog" aria-labelledby="followsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followsModalLabel">Followers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach ($user->follows as $follow)
                    @include('users.card', ['user' => $follow])
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset('images/jk-placeholder-image.jpg') }}" alt="Your Image" class="img-fluid">
                <div class="card-body">
                    <div style="display:flex; flex-flow: wrap; align-items:baseline; justify-content: space-between;">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        @if(Auth::user()->id != $user->id)
                            <button class="follow-button btn btn-block {{ auth()->user()->isFollowing($user) ? 'btn-danger' : 'btn-primary' }}"
                             data-user-id="{{ $user->id }}">
                                {{ auth()->user()->isFollowing($user) ? 'Unfollow' : 'Follow' }}
                            </button>
                        @else
                            <a href="#" class="btn btn-success btn-block">Edit Profile</a>
                        @endif
                    </div>
                    <p class="card-text">Web Developer</p>
                    <p class="card-text">Location: New York</p>
                    <p class="card-text">Joined: January 2022</p>
                </div>
            </div>

            <div class="card text-center mt-3" style="display:flex; flex-flow: wrap;">
                <div class="card-body">
                    <h5 class="card-title">Workouts</h5>
                    <p class="card-text">0</p>
                </div>
                <div class="card-body">
                    <a href="#" style="text-decoration: none; color: inherit" data-bs-toggle="modal" data-bs-target="#followsModal">
                        <h5 class="card-title">Follows</h5>
                        <p id="followers" class="card-text">{{ $user->follows->count() }}</p>
                    </a>
                </div>
                <div class="card-body">
                    <a href="#" style="text-decoration: none; color: inherit" data-bs-toggle="modal" data-bs-target="#followersModal">
                        <h5 class="card-title">Followers</h5>
                        <p id="followers" class="card-text">{{ $user->followers->count() }}</p>
                    </a>
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

<script>
    const button = document.querySelector('.follow-button');
    const followers = document.querySelector('#followers');
    button.addEventListener('click', async () => {
        const userId = button.getAttribute('data-user-id');
        const isFollowing = button.textContent.trim() === 'Unfollow';

        try {
            const response = await axios.post(`/users/${isFollowing ? 'unfollow' : 'follow'}/${userId}`);
            console.log(response.data.message);

            // Update button text
            button.textContent = isFollowing ? 'Follow' : 'Unfollow';
            if(isFollowing){
                button.classList.remove('btn-danger');
                button.classList.add('btn-primary');
                followers.textContent = parseInt(followers.textContent) - 1;
            } else {
                button.classList.remove('btn-primary');
                button.classList.add('btn-danger');
                followers.textContent = parseInt(followers.textContent) + 1;
            }
        } catch (error) {
            console.error(error);
        }
    });

    
</script>


@endsection