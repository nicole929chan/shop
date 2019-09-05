@extends('layouts.app')

@section('content')

    <div class="container">
        @include('manager.member')

        @if($member->activity)
            <div class="rounded">
                <img src="{{ $member->activity->image_path }}">
            </div>
        @else
            <activity-form :member="{{ $member }}"></activity-form>            
        @endif
    </div>

@endsection