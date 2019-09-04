@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ action('Admin\Manager\ManagerController@store') }}">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-sm-1 col-form-label">Name: </label>
                <div class="col-sm-11">
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-1 col-form-label">Email: </label>
                <div class="col-sm-11">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="phone_number" class="col-sm-1 col-form-label">Phone: </label>
                <div class="col-sm-11">
                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
                    @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-1 col-form-label">Address: </label>
                <div class="col-sm-11">
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label">Active: </label>
                <div class="col-sm-11">
                    <div class="d-flex">
                        <input type="date" name="active_start" class="form-control" value="{{ old('active_start') }}">
                        <div>~</div>
                        <input type="date" name="active_end" class="form-control" value="{{ old('active_end') }}">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="logo" class="col-sm-1 col-form-label">Logo: </label>
                <div class="col-sm-11 custom-file">
                    <input type="file" name="logo" class="custom-file-input">
                    <label class="custom-file-label">Choose file</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection