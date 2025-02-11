@extends('dashboard.layouts.main')
@section('content')

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Edit Property</h5>
    <form action="{{ route('property.update', $property['id']) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" value="{{ $property['id'] }}">
    
      <div class="mb-3">
        <label for="edit_name" class="form-label">Name Property</label>
        <input type="text" class="form-control" id="edit_name" name="name" value="{{ old('name', $property['name']) }}">
      </div>
    
      <select class="form-control" id="edit_category_id" name="category_id">
        <option value="{{ $property['category']['id'] }}">{{ $property['category']['name'] }}</option>
        @foreach ($categories as $category)
          <option value="{{ $category['id'] }}" 
            {{ $category['id'] == $property['category']['id'] ? 'selected' : '' }}>
            {{ $category['name'] }}
          </option>
        @endforeach
      </select>
    
      <div class="mb-3">
        <label for="edit_alamat" class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" id="edit_alamat" cols="30" rows="10">{{ old('alamat', $property['alamat']) }}</textarea>
      </div>
    
      <div class="mb-3">
        <label for="edit_image" class="form-label">Image</label>
        <input type="file" class="form-control" id="edit_image" name="image">
        @if($property['image']) 
          <img src="{{ asset('storage/'.$property['image']) }}" alt="Current Property Image" class="mt-2" style="max-width: 150px;">
        @endif
      </div>
    
      <button type="submit" class="btn btn-primary">Update Property</button>
    </form>
    
    
  </div>
</div>

@endsection
