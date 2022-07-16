@extends('frontend.layouts.master')

@section('main-content')
@include('frontend.layouts.notification')
<div class="card">
    <h5 class="card-header">Edit User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.update')}}">
        @csrf 
        @method('PUT')
        <input id="inputId" type="hidden" name="id" value="{{$user->id}}" />
        <div class="form-group">
          <label for="first_name" class="col-form-label">First Name</label>
        <input id="first_name" type="text" name="first_name" placeholder="Enter name"  value="{{$user->first_name}}" class="form-control">
        @error('first_name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="last_name" class="col-form-label">Last Name</label>
        <input id="last_name" type="text" name="last_name" placeholder="Enter name"  value="{{$user->last_name}}" class="form-control">
        @error('last_name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" type="email" name="email" placeholder="Enter email"  value="{{$user->email}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Phone</label>
          <input id="inputEmail" type="text" name="phone" placeholder="Enter phone"  value="{{$user->phone}}" class="form-control">
          @error('phone')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        {{-- <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{$user->password}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> --}}

        <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo</label>
        <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary choose">
                <i class="fa fa-picture-o"></i> Choose
                </a>
            </span>
            <input id="thumbnail" class="form-control" type="text" name="avatar" value="{{$user->avatar}}">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">
          @error('avatar')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
            <label for="role" class="col-form-label">Role</label>
            <select name="role" class="form-control">
                <option value="">-----Select Role-----</option>
                @foreach($roles as $role)
                  <option value="{{ $role->id }}" {{(($user->roleName() == $role->name) ? 'selected' : '')}}>{{ $role->name }}</option>
                @endforeach
            </select>
          @error('role')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')

<style type="text/css">
  .choose{
    color: white !important;
  }
</style>

@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush