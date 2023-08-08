@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            @foreach ($users as $user)
                <div class="card mt-2">
                    <div class="card-header">
                        <a href="{{-- route('profile',$user->id) --}}">{{ $user->name }}</a>
                    </div>
                    <div class="card-body">
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
@endsection