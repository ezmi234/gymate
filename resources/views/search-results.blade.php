<!-- resources/views/search-results.blade.php -->

@if($users->count() > 0)
    <ul class="list-group">
        @foreach($users as $user)
            <li class="list-group-item">{{ $user->name }}</li>
        @endforeach
    </ul>
@else
    <ul class="list-group">
        <li class="list-group-item">No results found</li>
    </ul>
@endif
