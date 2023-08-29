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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


</head>
<body>
    <div id="app">

        <div class="modal fade" id="notificationsModal" tabindex="-1" role="dialog" aria-labelledby="notificationsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div id="notificationsModalBody" class="modal-body">
                        <!-- AJAX results will be displayed here -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" style="font-size: x-large; font-weight: 500" href="{{ url('/') }}">
                    Gymate
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
                                <a class="nav-link  {{ request()->is('explore*') ? 'text-primary' : '' }}"
                                    href="{{ route('explore') }}">Explore</a>
                            </li>

                            <li class="nav-item">
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
                            </li>



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
                            <li class="nav-item" style="margin-right: 15px">
                                <div style="display: flex">
                                    <a class="nav-link btn position-relative" href="" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                                        Notifications

                                        <span id="notificationCounter" class="position-absolute start-100 translate-middle badge rounded-pill bg-danger d-none"
                                        style="top: auto">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>

                                    </a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right fade-in" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}">
                                        Profile
                                    </a>

                                    <a class="dropdown-item" href="{{-- route('settings') --}}">
                                        Settings
                                    </a>

                                    <hr class="dropdown-divider">

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            Logout
                                        </a>
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main style="margin-top: 80px;">
            @yield('content')
        </main>
    </div>
</body>

<script>
    // Function to trigger the search on input change
    function triggerSearch() {
        const searchTerm = document.getElementById('searchInput').value;
        const searchResults = document.getElementById('searchResults');

        if (searchTerm.trim() === '' || searchTerm.length < 3) {
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

    document.getElementById('searchButton').addEventListener('click', function () {
    const searchTerm = document.getElementById('searchInput').value;
    window.location.href = '{{ route('searchView') }}?term=' + searchTerm;
    });
</script>

<script>
    $(function() {

        // mark notification as read ajax request
        $(document).on('click', '.read-notification', function(e) {
            e.preventDefault();
            const notificationId = $(this).attr('id');
            $.ajax({
                url: '{{ route('markAsRead') }}',
                method: 'post',
                data: {
                    notificationId: notificationId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    if (data.status == 200) {
                        fetchAllNotifications();
                        $('#notificationCounter').html(data.unreadNotificationsCount);
                    }
                },
                error: function(error) {
                    console.log('error');
                    console.log(error);
                }
            });
        });

        // mark all notifications as read ajax request
        $(document).on('click', '.read-all-notifications', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('markAllAsRead') }}',
                method: 'post',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    if (data.status == 200) {
                        fetchAllNotifications();
                        $('#notificationCounter').html(data.unreadNotificationsCount);
                    }
                },
                error: function(error) {
                    console.log('error');
                    console.log(error);
                }
            });
        });

        // delete notification ajax request
        $(document).on('click', '.delete-notification', function(e) {
            e.preventDefault();
            const notificationId = $(this).attr('id');
            $.ajax({
                url: '{{ route('deleteNotification') }}',
                method: 'delete',
                data: {
                    notificationId: notificationId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    if (data.status == 200) {
                        fetchAllNotifications();
                        $('#notificationCounter').html(data.unreadNotificationsCount);
                    }
                },
                error: function(error) {
                    console.log('error');
                    console.log(error);
                }
            });
        });

        // delete all notifications ajax request
        $(document).on('click', '.delete-all-notifications', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('deleteAllNotifications') }}',
                method: 'delete',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    if (data.status == 200) {
                        fetchAllNotifications();
                        $('#notificationCounter').html(data.unreadNotificationsCount);
                    }
                },
                error: function(error) {
                    console.log('error');
                    console.log(error);
                }
            });
        });

        fetchAllNotifications();

        // Call fetchAllNotifications every 5 seconds
        setInterval(fetchAllNotifications, 5000); // 5000 milliseconds = 5 seconds

        function fetchAllNotifications() {
            $.ajax({
                url: '{{ route('fetchAllNotifications') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    $('#notificationsModalBody').html(data.html);
                    $('#notificationCounter').html(data.unreadNotificationsCount);
                    if (data.unreadNotificationsCount > 0) {
                        $('#notificationCounter').removeClass('d-none');
                    }else{
                        $('#notificationCounter').addClass('d-none');
                    }
                },
                error: function(error) {
                    console.log('error');
                    console.log(error);
                    $('#notificationsModalBody').html('<p class="text-center">No notifications found</p>');
                    $('#notificationCounter').addClass('d-none');
                }
            });
        }
    });
</script>

</html>
