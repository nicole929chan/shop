@extends('layouts.app')

@section('content')

    <div class="container">
        <div>
            <a href="{{ route('manager.create') }}" class="btn btn-primary">New</a>
        </div>

        @foreach($members as $member)
            @include('manager.member')
        @endforeach

        {{ $members->links() }}
    </div>

@endsection