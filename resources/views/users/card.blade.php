<div class="card mb-4" style="border-radius: 15px;">
<div class="card-body p-4">
    <div class="d-sm-flex text-black">
    <div class="flex-shrink-0">
        @if($user->profile_image)
            <img src="{{ asset('storage/images/profile/' . $user->profile_image) }}" alt="Profile Image" class="img-fluid"
            style="width: 180px; border-radius: 10px;">
        @else
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp"
            alt="Generic placeholder image" class="img-fluid"
            style="width: 180px; border-radius: 10px;">
        @endif
    </div>
    <div class="flex-grow-1 ms-3">
        <h5 class="mb-1">{{ $user->name }}</h5>
        <p class="mb-2 pb-1" style="color: #2b2a2a;">Senior Journalist</p>
        <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
        style="background-color: #efefef;">
        <div>
            <p class="small text-muted mb-1">Workouts</p>
            <p class="mb-0">0</p>
        </div>
        <div class="px-3">
            <p class="small text-muted mb-1">Follows</p>
            <p id="{{ (Auth::user()->id == $user->id) ? 'followsAuth' : ''}}" 
                class="mb-0">{{ $user->follows->count() }}</p>
        </div>
        <div>
            <p class="small text-muted mb-1">Followers</p>
            <p id="followers{{ $user->id }}" class="mb-0">{{ $user->followers->count() }}</p>
        </div>
        </div>
        <div class="d-flex pt-1">
        <a href="{{ route('users.show',$user->id) }}" class="btn btn-outline-primary me-1 flex-grow-1">View profile</a>
        @if($show && Auth::user()->id != $user->id)
            @if(auth()->user()->isFollowing($user))
                <a href="{{ route('users.followModal', $user->id) }}" class="btn btn-danger flex-grow-1">Unfollow</a>
            @else
                <a href="{{ route('users.followModal', $user->id) }}" class="btn btn-primary flex-grow-1">Follow</a>
            @endif
        @else    
            @if(Auth::user()->id != $user->id)
                <button class="follow-button-card btn btn-block flex-grow-1 {{ auth()->user()->isFollowing($user) ? 'btn-danger' : 'btn-primary' }}"
                    data-user-id="{{ $user->id }}">
                    {{ auth()->user()->isFollowing($user) ? 'Unfollow' : 'Follow' }}
                </button>
            @else
                <a href="#" class="btn btn-success btn-block flex-grow-1">Edit Profile</a>
            @endif
        @endif
        </div>
    </div>
    </div>
</div>
</div>

