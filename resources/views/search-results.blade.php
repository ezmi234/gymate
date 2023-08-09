<!-- resources/views/search-results.blade.php -->

@if($users->count() > 0)
    <ul class="list-group">
        @foreach($users as $user)
            <li class="list-group-item">
                <a href="{{ route('users.show',$user->id) }}" style="text-decoration: none; color: inherit">
                    {{ $user->name }}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <ul class="list-group">
        <li class="list-group-item">No results found</li>
    </ul>
@endif
