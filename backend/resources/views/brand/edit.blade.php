@extends('layouts.layoutAdmin')

@section('title', 'Edit Brand')

@section('content')

<div class="action-buttons">
    <button class="btn btn-success btn-large" onclick="window.location.href='{{ route('brand.index') }}'" data-toggle="tooltip" data-original-title="Back to Brands">
        <i class="material-symbols-rounded">arrow_back</i> Back to Brands
    </button>
</div>

<div class="card my-4 mt-5">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Edit Brand</h6>
        </div>
    </div>
    <div class="card-body px-3 mx-3 pb-2">
        <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Specify the HTTP method for update -->
            
            <div class="form-group">
                <label for="name" class="form-label">Brand Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $brand->name) }}" placeholder="Enter brand name" required>
            </div>

            <div class="form-group mt-3">
                <label for="image" class="form-label">Brand Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                @if($brand->image)
                    <img src="{{ asset('storage/' . $brand->image) }}" alt="Brand Image" class="mt-3" style="max-width: 150px;">
                @endif
            </div>

            <div class="form-group mt-3 text-end">
                <button type="submit" class="btn btn-primary btn-large">Update Brand</button>
            </div>
        </form>
    </div>
</div>

@endsection
