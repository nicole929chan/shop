@extends('layouts.app')

@section('content')

    <div class="media mb-4">
        <img src="{{ asset('storage/'.$member->logo) }}" class="mr-3" alt="">
        <div class="media-body">
            <h5 class="mt-0">{{ $member->name }}</h5>
            <div>{{ $member->email }}</div>
            <div>{{ $member->phone_number }}</div>
            <div>{{ $member->address }}</div>
            <div>
                <a href="#">Customers</a>
            </div>
        </div>
    </div>
    
    @if($member->activity)
        <div class="card mb-3">
            <img src="{{ asset('storage/'.$member->activity->image_path) }}" alt="">
            <div class="card-body">
                <h5 class="card-text">start date: {{ $member->activity->activity_start }}</h5>
                <h5 class="card-text">end date: {{ $member->activity->activity_end }}</h5>
                <p class="card-text">points: {{ $member->activity->points }}</p>
                <p class="card-text">{{ $member->activity->description }}</p>
            </div>
        </div>
    @endif

@endsection