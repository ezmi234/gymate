@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                 @foreach ($users as $user)
                    @include('users.card', ['user' => $user])
                 @endforeach
            </div>
        </div>
    </div>
@endsection