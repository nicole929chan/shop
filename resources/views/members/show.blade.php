@extends('layouts.app')

@section('content')

    <div class="media mb-4">
        <img src="{{ asset('storage/'.$member->logo) }}" class="mr-3" alt="">
        <div class="media-body">
            <h4 class="mt-0">{{ $member->name }}</h4>
            <div>{{ $member->email }}</div>
            <div>{{ $member->phone_number }}</div>
            <div>{{ $member->address }}</div>
            <div class="mt-2">
                <a href="{{ route('user.index', [$member->id]) }}" class="btn btn-sm btn-outline-primary">Customers</a>
            </div>
        </div>
    </div>
    
    @if($member->activity)
        <div class="card mb-3">
            <img src="{{ asset('storage/'.$member->activity->image_path) }}" alt="">
            <div class="card-body">
                <div class="card-text">start date: {{ $member->activity->activity_start }}</div>
                <div class="card-text">end date: {{ $member->activity->activity_end }}</div>
                <p class="card-text">points: {{ $member->activity->points }}</p>
                <p class="card-text">{{ $member->activity->description }}</p>
            </div>
        </div>
    @endif

@endsection