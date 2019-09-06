@extends('layouts.app')

@section('content')

    <div class="container">
        @include('manager.member')

        <activity :member="{{ $member }}"></activity>

    </div>

@endsection