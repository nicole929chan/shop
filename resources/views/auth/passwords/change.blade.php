@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <form method="POST" action="{{ action('Admin\Auth\ChangePasswordController@change', [$member->id]) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="{{ $member->name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Email:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="{{ $member->email }}" disabled>
                            <input type="hidden" name="email" value="{{ $member->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">New Password:<em class="text-danger">*</em></label>
                        <div class="col-sm-8">
                            <input type="password" name="password" class="form-control">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-4 col-form-label">Confirmed Password:<em class="text-danger">*</em></label>
                        <div class="col-sm-8">
                            <input type="password" name="password_confirmation" class="form-control">
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