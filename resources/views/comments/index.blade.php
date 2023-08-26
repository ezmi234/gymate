<div>
    <h5 class="card-title">Comments:</h5>
    <div class="comments">
        @foreach ($workout->comments as $comment)
            <div class="comment">
                <p>
                    <a href="{{ route('users.show', $comment->user->id) }}" style="text-decoration: none; font-weight: bold; color: inherit">
                        {{ $comment->user->name }}:
                    </a>
                    {{ $comment->body }}
                </p>
            </div>
        @endforeach
    </div>

    <form action="/comments/store/{{ $workout->id }}" method="POST">
        @csrf
        <div>
            <textarea name="body" class="form-control" rows="3" placeholder="Write a comment"></textarea>
            <input type="hidden" name="workout_id" value="{{ $workout->id }}">
        </div>
        <div>
            <button type="submit" class="btn btn-primary mt-2">Add Comment</button>
        </div>
    </form>
</div>

