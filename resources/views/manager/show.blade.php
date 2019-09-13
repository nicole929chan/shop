@extends('layouts.app')

@section('content')

    <div class="container">
        <a href="{{ route('manager.edit', [$member->id]) }}" class="btn btn-primary">Edit</a>

        @include('manager.member')

        @if(!$member->admin)
            <activity :member="{{ $member }}"></activity>
        @endif
    </div>

@endsection