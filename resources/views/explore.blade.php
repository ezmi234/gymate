@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title" style="display: flex; align-items: baseline;
                    justify-content: space-between;
                    margin-inline: 4px;">
                        <h3>Workouts</h3>
                    </div>
                    <div class="posts-container">
                        <div id="workouts">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        fetchAllWorkouts();

        function fetchAllWorkouts() {
            $.ajax({
                url: '{{ route('fetchAllWorkouts') }}',
                type: 'GET',
                data: {
                    explore: true,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    $('#workouts').html(data.html);
                },
                error: function(error) {
                    console.log('error');
                    console.log(error);
                    $('#workouts').html('<p class="text-center">No workouts yet.</p>');
                }
            });
        }
    });
</script>
@endsection
