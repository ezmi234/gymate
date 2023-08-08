<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gymate</title>

    <!-- Fonts -->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

   
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                     <h3>Gymate</h3>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>
                    
                    <!-- Center Side Of Navbar -->
                    <ul class="navbar-nav mx-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link  {{ request()->is('home*') ? 'text-primary' : '' }}"
                                    href="{{ route('home') }}">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{-- route('workouts.index') --}}">Workouts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{-- route('exercises.index') --}}">Exercises</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{-- route('routines.index') --}}">Routines</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{-- route('programs.index') --}}">Programs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{-- route('users.index') --}}">Users</a>
                            </li>

                            <div class="search-container">
                                <!-- Search Users with ajax -->
                                <form id="searchForm" class="d-flex">
                                    <input id="searchInput" class="form-control me-2" type="search" placeholder="Search users" aria-label="Search">
                                    <button class="btn btn-outline-primary" type="button" id="searchButton">Search</button>
                                </form>
                            
                                <div id="searchResults" class="mt-1 border-0">
                                    <!-- AJAX results will be displayed here -->
                                </div>
                            </div>
                            


                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<script>
    // Function to trigger the search on input change
    function triggerSearch() {
        const searchTerm = document.getElementById('searchInput').value;
        const searchResults = document.getElementById('searchResults');

        if (searchTerm.trim() === '') {
            // If the search term is empty, hide the search results container
            searchResults.style.display = 'none';
        } else {
            // If there is a search term, show the search results container and make the AJAX request
            searchResults.style.display = 'block';
            fetch('{{ route('search') }}?term=' + searchTerm)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('searchResults').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }

    // AJAX Search functionality on input change
    document.getElementById('searchInput').addEventListener('input', function () {
        triggerSearch();
    });

    // Call the triggerSearch function on page load to show initial results
    document.addEventListener('DOMContentLoaded', function () {
        triggerSearch();
    });
</script>

</html>
