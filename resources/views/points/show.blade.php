@extends('layouts.app')

@section('content')

<div>
  <form action="#">
    @csrf
    <div>
      <label for="code">使用者代碼</label>
      <input type="text" name="user_code" value="{{ $code }}">
    </div>
    <div>
      <label for="member_id">店家代碼</label>
      <input type="text" name="member_code">
    </div>
    <div>
      <label for="points">贈與點數</label>
      <input type="text" name="points">
    </div>
  </form>
</div>


@endsection