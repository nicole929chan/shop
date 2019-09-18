@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table table-sm">
        <thead class="bg-info">
            <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">code</th>
                <th scope="col">email</th>
                <th scope="col">points</th>
                <th scope="col">birthday</th>
                <th scope="col">created at</th>
                <th scope="col">updated at</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr class="text-center">
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->code }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($item = $user->pointByMember($member->id))
                            <div>{{ $item->pivot->points }}</div>
                        @endif
                    </td>
                    <td>
                        {{ $user->birth_year }} / {{ $user->birth_month }}
                    </td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection