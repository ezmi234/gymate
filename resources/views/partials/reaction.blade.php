<div class="container my-2 d-flex">
    <div style="margin-right: 15px">
        <span id="like-count{{ $workout->id }}">{{ $workout->likes->count() }}</span> {{ Str::plural('like', $workout->likes->count()) }}
        <button class="btn btn-{{ auth()->user()->hasLiked($workout) ? 'secondary' : 'primary' }} like-button" id="like-button{{ $workout->id }}" data-workout-id="{{ $workout->id }}">
            {{ auth()->user()->hasLiked($workout) ? 'Dislike' : 'Like' }}
        </button>
    </div>
    <div>
        {{ Str::plural('join', $workout->joins->count()) }}:
        <span id="join-count{{ $workout->id }}">{{ $workout->joins->count() }}</span>/{{ $workout->capacity }}
        <button class="btn btn-{{ auth()->user()->hasJoined($workout) ? 'secondary' : 'primary' }} join-button" {{ (!auth()->user()->hasJoined($workout) && $workout->joins->count() == $workout->capacity) ?
        'disabled' : '' }}
            id="join-button{{ $workout->id }}" data-workout-id="{{ $workout->id }}">
            {{ auth()->user()->hasJoined($workout) ? 'Leave' : ($workout->joins->count() == $workout->capacity ? 'Full' : 'Join') }}
        </button>
    </div>
</div>


