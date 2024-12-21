@extends('layouts.layoutAdmin')

@section('title', 'Add products')

@section('style')
    <style>
        .btn-large {
            padding: 8px 16px !important; /* Adjust padding */
            font-size: 14px !important;   /* Font size */
            line-height: 1.4 !important;  /* Adjust line height */
        }

        .btn {
            margin-right: 5px; /* Add spacing between buttons */
        }

        .form-group {
            margin-bottom: 20px !important;
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
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3"> Add new Product</h6>
                        </div>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Product Name -->
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <!-- Description -->
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" required></textarea>
    </div>

    <!-- Price -->
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" step="0.01" name="price" id="price" class="form-control" required>
    </div>

    <!-- Stock -->
    <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" name="stock" id="stock" class="form-control" required>
    </div>

    <!-- Subcategory -->
    <div class="form-group">
        <label for="subcategory_id">Subcategory</label>
        <select name="subcategory_id" id="subcategory_id" class="form-control" required>
            <!-- Populate subcategories dynamically -->
            @foreach ($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Visible -->
    <div class="form-group">
        <label for="visible">Visible</label>
        <input type="checkbox" name="visible" id="visible" value="1">
    </div>

    <!-- Main Image -->
    <div class="form-group">
        <label for="main_image">Main Image</label>
        <input type="file" name="main_image" id="main_image" class="form-control" required>
    </div>

    <!-- Sub Images (Up to 6) -->
    <div class="form-group">
        <label for="sub_images">Sub Images (Max 6)</label>
        <input type="file" name="sub_images[]" id="sub_images" class="form-control" multiple>
    </div>

    <!-- Warnings -->
    <div class="form-group">
        <label for="warnings">Warnings</label>
        <textarea name="warnings" id="warnings" class="form-control"></textarea>
    </div>

    <!-- Disclaimer -->
    <div class="form-group">
        <label for="disclaimer">Disclaimer</label>
        <textarea name="disclaimer" id="disclaimer" class="form-control"></textarea>
    </div>

    <!-- Other Ingredients -->
    <div class="form-group">
        <label for="other_ingredients">Other Ingredients</label>
        <textarea name="other_ingredients" id="other_ingredients" class="form-control"></textarea>
    </div>

    <!-- Nutritional Information -->
    <div class="form-group">
        <label for="nutritional_information">Nutritional Information</label>
        <textarea name="nutritional_information" id="nutritional_information" class="form-control"></textarea>
    </div>

    <!-- Brand -->
    <div class="form-group">
        <label for="brand_id">Brand</label>
        <select name="brand_id" id="brand_id" class="form-control" required>
            <!-- Populate brands dynamically -->
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Skin Type -->
    <div class="form-group">
        <label for="skin_type">Skin Type</label>
        <input type="text" name="skin_type" id="skin_type" class="form-control">
    </div>

    <!-- Active Ingredients -->
    <div class="form-group">
        <label for="active_ingredients">Active Ingredients</label>
        <input type="text" name="active_ingredients" id="active_ingredients" class="form-control">
    </div>

    <!-- Usage Instructions -->
    <div class="form-group">
        <label for="usage_instructions">Usage Instructions</label>
        <input type="text" name="usage_instructions" id="usage_instructions" class="form-control">
    </div>

    <!-- Bottle Volume -->
    <div class="form-group">
        <label for="bottle_volume">Bottle Volume (ml/oz)</label>
        <input type="number" name="bottle_volume" id="bottle_volume" class="form-control" step="0.01">
    </div>

    <!-- Bottle Material -->
    <div class="form-group">
        <label for="bottle_material">Bottle Material</label>
        <input type="text" name="bottle_material" id="bottle_material" class="form-control">
    </div>

    <!-- Bottle Type -->
    <div class="form-group">
        <label for="bottle_type">Bottle Type</label>
        <input type="text" name="bottle_type" id="bottle_type" class="form-control">
    </div>

    <!-- Cap Type -->
    <div class="form-group">
        <label for="cap_type">Cap Type</label>
        <input type="text" name="cap_type" id="cap_type" class="form-control">
    </div>

    <!-- Submit Button -->
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Create Product</button>
    </div>
</form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Image preview function
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
                document.getElementById(previewId).style.display = "block";
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }



    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subImageWrapper = document.getElementById('subImageWrapper');

        // Add a new sub-image input field
        subImageWrapper.addEventListener('click', function (e) {
            if (e.target && e.target.matches('.add-sub-image')) {
                const newField = `
                    <div class="input-group mb-3">
                        <input type="file" name="sub_images[]" class="form-control">
                        <button type="button" class="btn btn-danger remove-sub-image">
                             <i class="material-icons">delete</i>
                        </button>
                    </div>`;
                subImageWrapper.insertAdjacentHTML('beforeend', newField);
            }
        });

        // Remove an existing sub-image input field
        subImageWrapper.addEventListener('click', function (e) {
            if (e.target && e.target.matches('.remove-sub-image, .remove-sub-image *')) {
                const inputGroup = e.target.closest('.input-group');
                inputGroup.remove();
            }
        });
    });
</script>

@endsection
