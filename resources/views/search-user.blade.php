@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                 @foreach ($users as $user)
                    @include('users.card', ['user' => $user], ['show' => false])
                 @endforeach
            </div>
        </div>
    </div>

    <script>
        const buttons = document.querySelectorAll('.follow-button-card');
        const followsAuth = document.querySelector('#followsAuth');
        buttons.forEach(button => {
            button.addEventListener('click', async () => {
            const userId = button.getAttribute('data-user-id');
            const isFollowing = button.textContent.trim() === 'Unfollow';
            const followers = document.querySelector(`#followers${userId}`);
            try {
                const response = await axios.post(`/users/${isFollowing ? 'unfollow' : 'follow'}/${userId}`);
                console.log(response.data.message);
    
                // Update button text
                button.textContent = isFollowing ? 'Follow' : 'Unfollow';
                if(isFollowing){
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-primary');
                    followers.textContent = parseInt(followers.textContent) - 1;
                    followsAuth.textContent = parseInt(followsAuth.textContent) - 1;
                } else {
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-danger');
                    followers.textContent = parseInt(followers.textContent) + 1;
                    followsAuth.textContent = parseInt(followsAuth.textContent) + 1;
                }
            } catch (error) {
                console.error(error);
            }
        });
        });
    </script>

@endsection