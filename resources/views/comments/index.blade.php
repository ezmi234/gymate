<div>
    <h5 class="card-title">Comments:</h5>
    <div class="comments" style="margin-bottom: 15px">
        @foreach ($workout->comments->take(3) as $comment)
            <div class="comment d-flex align-items-baseline justify-content-between">
                <p>
                    <a href="{{ route('users.show', $comment->user->id) }}" style="text-decoration: none; font-weight: bold; color: inherit">
                        {{ $comment->user->name }}:
                    </a>
                    {{ $comment->body }}
                </p>

                @if ($comment->user->id == Auth::user()->id)
                    <form action="{{ route('comments.delete', $comment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi-trash h4"></i>
                        </button>
                    </form>
                @endif
            </div>
        @endforeach

        @if ($workout->comments->count() > 3)
            <button id="showMoreButton" class="btn btn-outline-primary">Show all comments</button>
        <div id="hiddenComments" style="display: none;">
            @foreach ($workout->comments->slice(3) as $comment)
                <div class="comment d-flex align-items-baseline justify-content-between">
                    <p>
                        <a href="{{ route('users.show', $comment->user->id) }}" style="text-decoration: none; font-weight: bold; color: inherit">
                            {{ $comment->user->name }}:
                        </a>
                        {{ $comment->body }}
                    </p>

                    @if ($comment->user->id == Auth::user()->id)
                    <form action="{{ route('comments.delete', $comment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi-trash h4"></i>
                        </button>
                    </form>
                @endif
                </div>
            @endforeach
        </div>
        @endif
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

<script>
    document.getElementById('showMoreButton').addEventListener('click', function() {
        document.getElementById('hiddenComments').style.display = 'block';
        this.style.display = 'none';
    });
</script>
