@extends('layouts.layoutAdmin')

@section('title', 'Edit Product')

@section('style')
<style>
    .btn-large {
        padding: 8px 16px !important;
        font-size: 14px !important;
        line-height: 1.4 !important;
    }

    .btn {
        margin-right: 5px;
    }

    .form-group {
        margin-bottom: 20px !important;
    }

    .form-control,
    .form-select {
        border-radius: 5px !important;
        border: 1px solid #ccc !important;
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
        border: 1px solid #ccc !important;
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
                        <h6 class="text-white text-capitalize ps-3"> Edit Product Details</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" required>{{ $product->description }}</textarea>
                        </div>

                        <!-- Price -->
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                        </div>

                        <!-- Stock -->
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
                        </div>

                        <!-- Subcategory -->
                        <div class="form-group">
                            <label for="subcategory_id">Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-select" required>
                                <option value="{{ $product->category->id }}" selected>{{ $product->category->name }}</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Visible -->
                        <div class="form-group">
                            <label for="visible">Visible</label>
                            <select name="visible" id="visible" class="form-select" required>
                                <option value="1" {{ $product->visible ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$product->visible ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Main Image -->
                        <div class="form-group">
                            <label for="main_image">Main Image</label>
                            <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*">
                            <img src="{{ asset('storage/'.$product->main_image) }}" class="image-preview" alt="Main Image">
                        </div>

                        <!-- Sub Images -->
                        <div class="form-group">
                            <label for="sub_images">Sub Images</label>
                            <input type="file" name="sub_images[]" id="sub_images" class="form-control" accept="image/*" multiple>
                            <div class="row mt-3">
                                @foreach ($product->images as $image)
                                <div class="col-4 mb-3">
                                    <img src="{{ asset('storage/'.$image->image) }}" class="image-preview" alt="Sub Image">
                                </div>
                                @endforeach
                            </div>
                        </div>


                        <!-- Is Package -->
                        <div class="form-group">
                            <label for="is_package">Is Package</label>
                            <select name="is_package" id="is_package" class="form-select" required>
                                <option value="1" {{ $product->is_package ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$product->is_package ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Warnings -->
                        <div class="form-group">
                            <label for="warnings">Warnings</label>
                            <textarea name="warnings" id="warnings" class="form-control">{{ $product->warnings }}</textarea>
                        </div>

                        <!-- Disclaimer -->
                        <div class="form-group">
                            <label for="disclaimer">Disclaimer</label>
                            <textarea name="disclaimer" id="disclaimer" class="form-control">{{ $product->disclaimer }}</textarea>
                        </div>

                        <!-- Other Ingredients -->
                        <div class="form-group">
                            <label for="other_ingredients">Other Ingredients</label>
                            <textarea name="other_ingredients" id="other_ingredients" class="form-control">{{ $product->other_ingredients }}</textarea>
                        </div>

                   


                        <!-- Nutritional Information -->
                        <div class="form-group">
                            <label for="nutritional_information">Nutritional Information</label>
                            <textarea name="nutritional_information" id="nutritional_information" class="form-control">{{ $product->nutritional_information }}</textarea>
                        </div>

                        <!-- Brand -->
                        <div class="form-group">
                            <label for="brand_id">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-select" required>
                                <option value="{{ $product->brand->id }}" selected>{{ $product->brand->name }}</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Skin Type -->
                        <div class="form-group">
                            <label for="skin_type">Skin Type</label>
                            <input type="text" name="skin_type" id="skin_type" class="form-control" value="{{ $product->skin_type }}">
                        </div>

                        <!-- Active Ingredients -->
                        <div class="form-group">
                            <label for="active_ingredients">Active Ingredients</label>
                            <textarea name="active_ingredients" id="active_ingredients" class="form-control">{{ $product->active_ingredients }}</textarea>
                        </div>

                        <!-- Usage Instructions -->
                        <div class="form-group">
                            <label for="usage_instructions">Usage Instructions</label>
                            <textarea name="usage_instructions" id="usage_instructions" class="form-control">{{ $product->usage_instructions }}</textarea>
                        </div>

                        <!-- Bottle Volume -->
                        <div class="form-group">
                            <label for="bottle_volume">Bottle Volume (ml)</label>
                            <input type="number" name="bottle_volume" id="bottle_volume" class="form-control" value="{{ $product->bottle_volume }}">
                        </div>

                        <!-- Bottle Material -->
                        <div class="form-group">
                            <label for="bottle_material">Bottle Material</label>
                            <input type="text" name="bottle_material" id="bottle_material" class="form-control" value="{{ $product->bottle_material }}">
                        </div>

                        <!-- Bottle Type -->
                        <div class="form-group">
                            <label for="bottle_type">Bottle Type</label>
                            <input type="text" name="bottle_type" id="bottle_type" class="form-control" value="{{ $product->bottle_type }}">
                        </div>

                        <!-- Cap Type -->
                        <div class="form-group">
                            <label for="cap_type">Cap Type</label>
                            <input type="text" name="cap_type" id="cap_type" class="form-control" value="{{ $product->cap_type }}">
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-large">Save Changes</button>
                            <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
@endsection