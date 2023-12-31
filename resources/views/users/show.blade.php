@extends('layouts.app')

@section('content')

<div class="modal fade" id="followersModal" tabindex="-1" role="dialog" aria-labelledby="followersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followersModalLabel">Followers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($user->followers->count() > 0)
                    @foreach ($user->followers as $follower)
                        @include('users.card', ['user' => $follower, 'show' => 'followers'])
                    @endforeach
                @else
                    <p class="text-center">No followers yet.</p>
                @endif
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
                @if($user->follows->count() > 0)
                    @foreach ($user->follows as $follow)
                        @include('users.card', ['user' => $follow, 'show' => 'follows'])
                    @endforeach
                @else
                    <p class="text-center">No follows yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add new workout modal -->
<div class="modal fade" id="newWorkoutModal" tabindex="-1" aria-labelledby="newWorkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="newWorkoutModalLabel">New Workout</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Form -->
        <form id="newWorkoutForm" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location">
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" class="form-control" id="time" name="time">
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="number" class="form-control" id="duration" name="duration" placeholder="Enter duration">
                </div>
                <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Enter capacity">
                </div>
                <div class="mb-3">
                    <label class="form-errors text-danger"></label>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>


<div class="container mt-md-2">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="image-container d-flex align-items-center">
                @if($user->profile_image)
                    <img src="{{ asset('storage/images/profile/' . $user->profile_image) }}" alt="Profile Image" class="img-fluid rounded">
                @else
                    <img src="{{ asset('images/jk-placeholder-image.jpg') }}" alt="Your Image" class="img-fluid rounded">
                @endif
                </div>
                <div class="card-body">
                    <div style="display:flex; flex-flow: wrap; align-items:baseline; justify-content: space-between;">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        @if(Auth::user()->id != $user->id)
                            <button class="follow-button btn btn-block {{ auth()->user()->isFollowing($user) ? 'btn-danger' : 'btn-primary' }}"
                             data-user-id="{{ $user->id }}">
                                {{ auth()->user()->isFollowing($user) ? 'Unfollow' : 'Follow' }}
                            </button>
                        @else
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-block">Edit Profile</a>
                        @endif
                    </div>
                    <p class="card-text">Location: {{ $user->location ?: 'N/A' }}</p>
                    <p class="card-text">Joined: {{ $user->created_at->diffForHumans() }}</p>
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
                        <p id="follows" class="card-text">{{ $user->follows->count() }}</p>
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
                    <p class="card-text">{{ $user->about_me ?: 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-md-0 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title" style="display: flex; align-items: baseline;
                    justify-content: space-between;
                    margin-inline: 4px;">
                        <h5>Workouts</h5>
                        @if(Auth::user()->id == $user->id)
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newWorkoutModal">
                                Add Workout
                            </button>
                        @endif
                    </div>
                    <div class="posts-container">
                        <div id="workouts">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div style="width: 100px; height: 10px;">

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

<script>
    $(function() {
        //add new workout ajax request
        $("#newWorkoutForm").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('workouts.store') }}',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    if(data.status == 200) {
                        fetchAllWorkouts();
                        $('#newWorkoutForm').trigger('reset');
                        $('#newWorkoutModal').modal('hide');
                    } else if(data.status == 400) {
                        console.log(data.errors);
                        $('.form-errors').html(data.errors);
                    }
                },
                error: function(error) {
                    console.log('error');
                    console.log(error);
                },
            });
        });

        // delete workout ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        $.ajax({
            url: '{{ route('workouts.delete') }}',
            method: 'delete',
            data: {
            id: id,
            _token: csrf
            },
            success: function(data) {
                console.log('success');
                console.log(data);
                if(data.status == 200) {
                    fetchAllWorkouts();
                }
            },
            error: function(error) {
                console.log('error');
                console.log(error);
            }
        });
        });

        // like workout ajax request
        $(document).on('click', '.like-button', function(e) {
            e.preventDefault();
            let workoutId = $(this).attr('data-workout-id');
            let csrf = '{{ csrf_token() }}';
            let likeButton = document.querySelector('#like-button' + workoutId);
            let isLiked = likeButton.textContent.trim() === 'Dislike';
            $.ajax({
                url: `/workouts/${isLiked ? 'dislike' : 'like'}/${workoutId}`,
                method: 'post',
                data: {
                _token: csrf
                },
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    if(data.status == 200) {
                        console.log(data.message);
                        // Update button text
                        likeButton.textContent = isLiked ? 'Like' : 'Dislike';
                        if(isLiked){
                            $('#like-count' + workoutId).text(parseInt($('#like-count' + workoutId).text()) - 1);
                            likeButton.classList.remove('btn-secondary');
                            likeButton.classList.add('btn-primary');
                        } else {
                            $('#like-count' + workoutId).text(parseInt($('#like-count' + workoutId).text()) + 1);
                            likeButton.classList.remove('btn-primary');
                            likeButton.classList.add('btn-secondary');
                        }
                    }
                },
                error: function(error) {
                    console.log('error');
                    console.log(error);
                }
            });
        });

        // join workout ajax request
        $(document).on('click', '.join-button', function(e) {
            e.preventDefault();
            let workoutId = $(this).attr('data-workout-id');
            let csrf = '{{ csrf_token() }}';
            let joinButton = document.querySelector('#join-button' + workoutId);
            let isJoined = joinButton.textContent.trim() === 'Leave';
            $.ajax({
                url: `/workouts/${isJoined ? 'leave' : 'join'}/${workoutId}`,
                method: 'post',
                data: {
                _token: csrf
                },
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    if(data.status == 200) {
                        console.log(data.message);
                        // Update button text
                        joinButton.textContent = isJoined ? 'Join' : 'Leave';
                        if(isJoined){
                            $('#join-count' + workoutId).text(parseInt($('#join-count' + workoutId).text()) - 1);
                            joinButton.classList.remove('btn-secondary');
                            joinButton.classList.add('btn-primary');
                        } else {
                            $('#join-count' + workoutId).text(parseInt($('#join-count' + workoutId).text()) + 1);
                            joinButton.classList.remove('btn-primary');
                            joinButton.classList.add('btn-secondary');
                        }
                    } else if(data.status == 400) {
                        console.log(data.message);
                        $('#join-count' + workoutId).text(parseInt($('#join-count' + workoutId).text()) + 1);
                        joinButton.textContent = 'Full';
                        joinButton.disabled = true;
                    }
                },
                error: function(error) {
                    console.log('error');
                    console.log(error);
                }
            });
        });

        fetchAllWorkouts();

        function fetchAllWorkouts() {
            $.ajax({
                url: '{{ route('workouts.fetchAll') }}',
                type: 'GET',
                data: {
                    user_id: '{{ $user->id }}'
                },
                dataType: 'json',
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    $('#workouts').html(data.html);
                },
                error: function(error) {
                    console.log('error');
                    console.log(error);
                    $('#workouts').html('<p class="text-center">No workouts yet.</p>');
                }
            });
        }
    });
</script>



@endsection
