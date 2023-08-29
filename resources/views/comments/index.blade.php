
<div>
    <h5 class="card-title">Comments:</h5>
    <ul class="list-group list-group-flush">
        @foreach ($workout->comments->take(3) as $comment)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="user-profile-image d-flex justify-content-between align-items-start">
                    @if($comment->user->profile_image)
                        <img class="img-fluid" style="max-width: 40px; max-height: 40px; border-radius: 10px; margin-right: 10px;"
                        src="{{ asset('storage/images/profile/' . $comment->user->profile_image) }}" alt="User Profile Image">
                    @else
                        <img class="img-fluid" style="max-width: 40px; max-height: 40px; border-radius: 10px; margin-right: 10px;"
                        src="{{ asset('images/profile-placeholder.png') }}" alt="Generic placeholder profile">
                    @endif
                    <p>
                        <a href="{{ route('users.show', $comment->user->id) }}" style="text-decoration: none; color: inherit; font-weight: 500">
                            {{ $comment->user->name }}:
                        </a>
                        {{ $comment->body }}
                    </p>
                </div>

                <div class="d-flex align-items-center">
                <span class="badge bg-secondary" style="height: fit-content">{{ $comment->created_at->diffForHumans() }}</span>


                @if ($comment->user->id == Auth::user()->id)
                    <form action="{{ route('comments.delete', $comment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" style="margin-left: 3px">
                            <i class="bi-trash h5"></i>
                        </button>
                    </form>
                @endif
                </div>
            </li>
        @endforeach

        @if ($workout->comments->count() > 3)
            <button id="showMoreButton" class="btn btn-outline-primary">Show all comments</button>
        <div id="hiddenComments" style="display: none;">
            @foreach ($workout->comments->slice(3) as $comment)
                <div class="comment d-flex align-items-baseline justify-content-between">
                    <p>
                        <a href="{{ route('users.show', $comment->user->id) }}" style="text-decoration: none; color: inherit; font-weight: 500">
                            {{ $comment->user->name }}:
                        </a>
                        {{ $comment->body }}
                    </p>

                    <div class="d-flex align-items-center">
                        <span class="badge bg-secondary" style="height: fit-content">{{ $comment->created_at->diffForHumans() }}</span>


                        @if ($comment->user->id == Auth::user()->id)
                            <form action="{{ route('comments.delete', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" style="margin-left: 3px">
                                    <i class="bi-trash h5"></i>
                                </button>
                            </form>
                        @endif
                        </div>
                </div>
            @endforeach
        </div>
        @endif
    </ul>

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
