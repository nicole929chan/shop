@extends('layouts.app')

@section('content')

    @foreach($members as $member)
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
    @endforeach

@endsection