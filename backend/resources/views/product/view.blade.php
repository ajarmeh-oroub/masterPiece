@extends('layouts.layoutAdmin')

@section('title', isset($product) ? 'View Product Details' : 'Add Product')



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

        .form-control, .form-select {
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
                            <h6 class="text-white text-capitalize ps-3"> View Product Details</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" readonly>{{ $product->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="subcategory_id">Category</label>
                            <input type="text" name="subcategory_id" id="subcategory_id" class="form-control" value="{{ $categories }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="visible">Visible</label>
                            <input type="checkbox" name="visible" id="visible" {{ $product->visible ? 'checked' : '' }} disabled>
                        </div>

                        <div class="form-group">
                            <label for="main_image">Main Image</label>
                            <img src="{{ asset('storage/'.$product->main_image) }}" class="image-preview" alt="Main Image">
                        </div>

                        <div class="form-group">
                            <label for="sub_images">Sub Images</label>
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/'.$image->image) }}" class="image-preview" alt="Sub Image">
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="warnings">Warnings</label>
                            <textarea name="warnings" id="warnings" class="form-control" readonly>{{ $product->warnings }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="disclaimer">Disclaimer</label>
                            <textarea name="disclaimer" id="disclaimer" class="form-control" readonly>{{ $product->disclaimer }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="other_ingredients">Other Ingredients</label>
                            <textarea name="other_ingredients" id="other_ingredients" class="form-control" readonly>{{ $product->other_ingredients }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="nutritional_information">Nutritional Information</label>
                            <textarea name="nutritional_information" id="nutritional_information" class="form-control" readonly>{{ $product->nutritional_information }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="brand_id">Brand</label>
                            <input type="text" name="brand_id" id="brand_id" class="form-control" value="{{ $product->brand->name }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="skin_type">Skin Type</label>
                            <input type="text" name="skin_type" id="skin_type" class="form-control" value="{{ $product->skin_type }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="active_ingredients">Active Ingredients</label>
                            <input type="text" name="active_ingredients" id="active_ingredients" class="form-control" value="{{ $product->active_ingredients }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="usage_instructions">Usage Instructions</label>
                            <input type="text" name="usage_instructions" id="usage_instructions" class="form-control" value="{{ $product->usage_instructions }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="bottle_volume">Bottle Volume</label>
                            <input type="number" name="bottle_volume" id="bottle_volume" class="form-control" value="{{ $product->bottle_volume }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="bottle_material">Bottle Material</label>
                            <input type="text" name="bottle_material" id="bottle_material" class="form-control" value="{{ $product->bottle_material }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="bottle_type">Bottle Type</label>
                            <input type="text" name="bottle_type" id="bottle_type" class="form-control" value="{{ $product->bottle_type }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="cap_type">Cap Type</label>
                            <input type="text" name="cap_type" id="cap_type" class="form-control" value="{{ $product->cap_type }}" readonly>
                        </div>

                        <a href="{{ route('product.index')}}">
                            <button class="btn btn-primary btn-large">Go back to Products</button>
                        </a>
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
