<div class="container my-2">
    <span id="like-count">{{ $workout->likes->count() }}</span> {{ Str::plural('like', $workout->likes->count()) }}
    <button class="btn btn-primary" id="like-button" data-workout-id="{{ $workout->id }}">
        {{ auth()->user()->hasLiked($workout) ? 'Dislike' : 'Like' }}
    </button>
    <span id="join-count">{{ $workout->joins->count() }}</span> {{ Str::plural('join', $workout->joins->count()) }}
    <button class="btn btn-primary" id="join-button" data-workout-id="{{ $workout->id }}">
        {{ auth()->user()->hasJoined($workout) ? 'Leave' : 'Join' }}
    </button>
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
            } else {
                likes.textContent = parseInt(likes.textContent) + 1;
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

            // Update button text
            joinButton.textContent = isJoined ? 'Join' : 'Leave';
            if(isJoined){
                joins.textContent = parseInt(joins.textContent) - 1;
            } else {
                joins.textContent = parseInt(joins.textContent) + 1;
            }
        } catch (error) {
            console.error(error);
        }
    });


</script>
