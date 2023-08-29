@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Auth::user()->profile_completed == 0)
                <!-- Button trigger modal -->
                <button style="display: none;" id="profileModalTrigger" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Launch static backdrop modal
                </button>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Complete your profile</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          It's important to complete your profile to get the best experience of our website.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="{{ route('users.profile', Auth::user()) }}" class="btn btn-primary">Complete Profile</a>
                        </div>
                    </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#profileModalTrigger').trigger('click');
                    });
                </script>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="card-title" style="display: flex; align-items: baseline;
                    justify-content: space-between;
                    margin-inline: 4px;">
                        <h3>Workouts</h3>
                    </div>
                    <div class="posts-container">
                        <div id="workouts">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
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
                url: '{{ route('fetchAllWorkouts') }}',
                type: 'GET',
                data: {
                    explore: true,
                    _token: '{{ csrf_token() }}'
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
