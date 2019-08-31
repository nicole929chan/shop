@extends('layouts.app')

@section('content')

<div>
  <form action="#">
    @csrf
    <div>
      <label for="code">兌換代號</label>
      <input type="text" name="code" value="{{ $user->code }}">
    </div>
    <div>
      <label for="member_id">店家代號</label>
      <input type="text" name="member_id">
    </div>
    <div>
      <label for="points">贈與點數</label>
      <input type="text" name="points">
    </div>
  </form>
</div>


@endsection