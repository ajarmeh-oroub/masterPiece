@extends('layouts.layoutAdmin')

@section('title', 'Edit Subcategory')

@section('style')
    <style>
        .btn-large {
            padding: 8px 16px !important; /* Adjust padding */
            font-size: 14px !important;   /* Font size */
            line-height: 1.4 !important;  /* Adjust line height */
        }

        .btn {
            margin-left: 12px !important; /* Add spacing between buttons */
        }

        .form-group {
            margin-bottom: 20px !important;
            margin-left: 12px !important;
            margin-right: 12px !important;
        }

        .form-control, .form-select {
            border-radius: 5px !important;
            border: 1px solid #ccc !important; /* Added border */
            padding: 8px 14px !important;
        }

        .card-body {
            padding: 30px !important;
        }

        .image-preview {
            max-width: 150px !important;
            max-height: 150px !important;
            object-fit: cover !important;
            margin-top: 10px !important;
            border: 1px solid #ccc !important; /* Added border to image preview */
            padding: 5px !important;
        }

        .text-danger {
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    <!-- Edit Subcategory Form -->
    <div class="card my-4 mt-5">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Edit Subcategory</h6>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <!-- Form to update subcategory -->
                <form action="{{ route('subcategory.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Subcategory Name -->
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">Subcategory Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter subcategory name" value="{{ old('name', $subcategory->name) }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parent Category -->
                    <div class="form-group mb-4">
                        <label for="category_id" class="form-label">Parent Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">Select Parent Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Preview (optional) -->
                    <div class="form-group">
                        <img id="imagePreview" class="image-preview" src="#" alt="Image Preview" style="display:none;">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Subcategory</button>

                    <a href="{{ route('category.index') }}">
                        <button type="button" class="btn btn-outline-secondary">Cancel</button>
                    </a>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // JavaScript for image preview functionality
        document.getElementById('image').addEventListener('change', function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function (event) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.style.display = 'block';
                imagePreview.src = event.target.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
