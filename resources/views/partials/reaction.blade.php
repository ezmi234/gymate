<div class="container my-2 d-flex">
    <div style="margin-right: 15px">
        <span id="like-count">{{ $workout->likes->count() }}</span> {{ Str::plural('like', $workout->likes->count()) }}
        <button class="btn btn-{{ auth()->user()->hasLiked($workout) ? 'secondary' : 'primary' }}" id="like-button" data-workout-id="{{ $workout->id }}">
            {{ auth()->user()->hasLiked($workout) ? 'Dislike' : 'Like' }}
        </button>
    </div>
    <div>
        {{ Str::plural('join', $workout->joins->count()) }}:
        <span id="join-count">{{ $workout->joins->count() }}</span>/{{ $workout->capacity }}
        <button class="btn btn-{{ auth()->user()->hasJoined($workout) ? 'secondary' : 'primary' }}" {{ (!auth()->user()->hasJoined($workout) && $workout->joins->count() == $workout->capacity) ?
        'disabled' : '' }}
            id="join-button" data-workout-id="{{ $workout->id }}">
            {{ auth()->user()->hasJoined($workout) ? 'Leave' : ($workout->joins->count() == $workout->capacity ? 'Full' : 'Join') }}
        </button>
    </div>
</div>


<script>
    const likeButton = document.querySelector('#like-button');
    const likes = document.querySelector('#like-count');
    likeButton.addEventListener('click', async () => {
        const workoutId = likeButton.dataset.workoutId;
        const isLiked = likeButton.textContent.trim() === 'Dislike';

        try {
            const response = await axios.post(`/workouts/${isLiked ? 'dislike' : 'like'}/${workoutId}`);
            console.log(response.data.message);

            // Update button text
            likeButton.textContent = isLiked ? 'Like' : 'Dislike';
            if(isLiked){
                likes.textContent = parseInt(likes.textContent) - 1;
                likeButton.classList.remove('btn-secondary');
                likeButton.classList.add('btn-primary');
            } else {
                likes.textContent = parseInt(likes.textContent) + 1;
                likeButton.classList.remove('btn-primary');
                likeButton.classList.add('btn-secondary');
            }
        } catch (error) {
            console.error(error);
        }
    });

    const joinButton = document.querySelector('#join-button');
    const joins = document.querySelector('#join-count');
    joinButton.addEventListener('click', async () => {
        const workoutId = joinButton.dataset.workoutId;
        const isJoined = joinButton.textContent.trim() === 'Leave';

        try {
            const response = await axios.post(`/workouts/${isJoined ? 'leave' : 'join'}/${workoutId}`);
            console.log(response.data.message);
            if (response.data.status === 400)
            {
                joins.textContent = parseInt(joins.textContent) + 1;
                joinButton.textContent = 'Full';
                joinButton.disabled = true;
                return;
            }
            // Update button text
            joinButton.textContent = isJoined ? 'Join' : 'Leave';
            if(isJoined){
                joins.textContent = parseInt(joins.textContent) - 1;
                joinButton.classList.remove('btn-secondary');
                joinButton.classList.add('btn-primary');
            } else {
                joins.textContent = parseInt(joins.textContent) + 1;
                joinButton.classList.remove('btn-primary');
                joinButton.classList.add('btn-secondary');
            }
        } catch (error) {
            console.error(error);
        }
    });


</script>
