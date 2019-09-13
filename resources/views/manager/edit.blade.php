@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ action('Admin\Manager\ManagerController@update', [$member->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group row">
                <label for="name" class="col-sm-1 col-form-label">Name:<em class="text-danger">*</em></label>
                <div class="col-sm-8">
                    <input type="text" name="name" class="form-control" value="{{ $member->name }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <select name="admin" class="form-control">
                        <option value="0" @if(!$member->admin) selected @endif>Member</option>
                        <option value="1" @if($member->admin) selected @endif>Admin</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-1 col-form-label">Email:<em class="text-danger">*</em></label>
                <div class="col-sm-11">
                    <input type="email" name="email" class="form-control" value="{{ $member->email }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="phone_number" class="col-sm-1 col-form-label">Phone:<em class="text-danger">*</em></label>
                <div class="col-sm-11">
                    <input type="text" name="phone_number" class="form-control" value="{{ $member->phone_number }}">
                    @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-1 col-form-label">Address:<em class="text-danger">*</em></label>
                <div class="col-sm-11">
                    <input type="text" name="address" class="form-control" value="{{ $member->address }}">
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label">Active:<em class="text-danger">*</em></label>
                <div class="col-sm-11">
                    <div class="d-flex">
                        <input type="date" name="start_date" class="form-control" value="{{ $member->start_date->format('Y-m-d') }}">
                        <div>~</div>
                        <input type="date" name="finish_date" class="form-control" value="{{ $member->finish_date->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="logo" class="col-sm-1 col-form-label">Logo: </label>
                <div class="col-sm-11">
                    <div class="custom-file">
                        <input type="file" name="logo" class="custom-file-inputx">
                    </div>
                    <small class="text-info">Upload new logo if you want to replace the old one.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-1 col-form-label">Image:</label>
                <div class="col-sm-11">
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-inputx">
                    </div>
                    <small class="text-info">Upload new image if you want to replace the old one.</small>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary px-md-5">Update</button>
            </div>
        </form>
    </div>

@endsection