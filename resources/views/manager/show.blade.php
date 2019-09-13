@extends('layouts.app')

@section('content')

    <div class="container">
        <a href="{{ route('manager.edit', [$member->id]) }}" class="btn btn-primary">Edit</a>

        @include('manager.member')
    
        @if(!$member->admin)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$member->image) }}" class="img-fluid" alt="">
            </div>
    
            <activity :member="{{ $member }}"></activity>
        @endif
    </div>

@endsection