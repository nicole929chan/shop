@extends('layouts.app')

@section('content')

<div class="card-deck w-50">
  <div class="card shadow-sm">
    <div class="card-header">
      <h4 class="my-0 font-weitht-normal">
        Get Points
      </h4>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ action('Admin\Point\PointController@store') }}">
        @csrf
        <div class="form-group row">
          <label for="code" class="col-sm-3 col-form-label">User's code</label>
          <div class="col-sm-9">
            <input type="text" name="user_code" class="form-control" 
              value="@if($code) {{ $code }} @else {{ old('use_code') }} @endif">
            @error('user_code')
                <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label for="member_code" class="col-sm-3 col-form-label">Your code</label>
          <div class="col-sm-9">
            <input type="text" name="member_code" class="form-control" 
              value="@if(old('member_code')) {{ old('member_code') }} @endif">
            @error('member_code')
                <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label for="points" class="col-sm-3 col-form-label">Points</label>
          <div class="col-sm-9">
            <input type="text" name="points" class="form-control">
            @error('points')
                <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-primary w-25">Submit</button>
        </div>
      </form>
    </div>  
  </div>
 </div>

@endsection