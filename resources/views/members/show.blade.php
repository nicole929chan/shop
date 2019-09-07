@extends('layouts.app')

@section('content')

    <div class="container">
        @include('manager.member')

        @if($member->activity)
            <div class="card mb-3">
                <figure class="figure">
                    <img src="{{ asset('storage/'.$member->activity->image_path) }}" class="figure-img img-fluid rounded" alt="">
                </figure>
                <div class="card-body">
                    <p class="card-text">Points: {{ $member->activity->points }}</p>
                    <p class="card-text">Activity period: {{ $member->activity->activity_start }} ~ {{ $member->activity->activity_end }}</p>
                    <p class="card-text">Content: {{ $member->activity->description }}</p>
                </div>
            </div>
        @endif

    </div>

@endsection