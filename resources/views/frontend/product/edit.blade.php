@extends('frontend.layouts.master')

@section('main-content')
@include('frontend.layouts.notification')
<div class="card">
    <h5 class="card-header">Edit Product</h5>
    <div class="card-body">
      <form method="post" action="{{route('product.update')}}">
        @csrf 
        @method('PUT')
        <input id="inputId" type="hidden" name="id" value="{{$product->id}}" />
        <div class="form-group">
          <label for="inputName" class="col-form-label">Name <span class="text-danger">*</span></label>
          <input id="inputName" type="text" name="name" placeholder="Enter name"  value="{{$product->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{$product->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="user_id">Assign To User <span class="text-danger">*</span></label>
          <select name="user_id" id="user_id" class="form-control">
              <option value="">--Select any category--</option>
              @foreach($users as $key => $user)
                  <option value='{{$user->id}}' {{ $product->user_id == $user->id ? 'selected' : '' }}>{{$user->first_name}}</option>
              @endforeach
          </select>
        </div>
        
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Image <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                  <i class="fas fa-image"></i> Choose
                  </a>
              </span>
          <input id="thumbnail" class="form-control" type="text" name="image" value="{{$product->image}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('image')
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
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail Description.....",
          tabsize: 2,
          height: 150
      });
    });
</script>

@endpush