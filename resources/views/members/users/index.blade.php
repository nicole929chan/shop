@extends('layouts.app')

@section('content')

    @foreach($users as $user)
        <div>
            <h5>{{ $user->name }}</h5>
            <div>{{ $user->email }}</div>
        </div>
    @endforeach

@endsection