@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Auth::user()->profile_completed == 0)
                <!-- Button trigger modal -->
                <button style="display: none;" id="profileModalTrigger" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Launch static backdrop modal
                </button>
                
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Complete your profile</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          It's important to complete your profile to get the best experience of our website.  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="{{ route('users.profile', Auth::user()) }}" class="btn btn-primary">Complete Profile</a>
                        </div>
                    </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#profileModalTrigger').trigger('click');
                    });
                </script>
            @endif
        </div>
    </div>
</div>
@endsection
