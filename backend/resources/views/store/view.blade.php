@extends('layouts.layoutAdmin')

@section('title', isset($store) ? 'View Store Details' : 'Add Store')

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
    </style>
@endsection

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">
                                {{ isset($store) ? 'View Pharmacy Details' : 'Add New Pharmacy' }}
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Store Name -->
                        <div class="form-group">
                            <label for="name" class="form-label">Pharmacy Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $store->name ?? old('name') }}" required>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                   value="{{ $store->description ?? old('description') }}" required>
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                   value="{{ $store->address ?? old('address') }}" required>
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="phone" name="phone"
                                   value="{{ $store->phone ?? old('phone') }}" required>
                        </div>

                        <!-- Owner Name -->
                        <div class="form-group">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name"
                                   value="{{ $store->owner_name?? old('owner_name') }}" required>
                        </div>

                        <!-- Store Email -->
                        <div class="form-group">
                            <label for="store_email" class="form-label">Pharmacy Email</label>
                            <input type="email" class="form-control" id="store_email" name="store_email"
                                   value="{{ $store->email ?? old('store_email') }}" required>
                        </div>

                        <!-- Logo -->
                        <div class="form-group">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" onchange="previewImage(event, 'logo-preview')">
                            @if (isset($store) && $store->logo)
                                <img id="logo-preview" src="{{ asset('storage/'.$store->logo) }}" class="image-preview" />
                            @else
                                <img id="logo-preview" class="image-preview" style="display:none;" />
                            @endif
                        </div>

                        <!-- Additional Fields -->
                        <div class="form-group">
                            <label for="pharm_phone" class="form-label">Pharmacy Phone</label>
                            <input type="text" class="form-control" id="pharm_phone" name="pharm_phone"
                                   value="{{ $store->pharm_phone ?? old('pharm_phone') }}">
                        </div>

                        <div class="form-group">
                            <label for="pharm_email" class="form-label">Pharmacy Email</label>
                            <input type="email" class="form-control" id="pharm_email" name="pharm_email"
                                   value="{{ $store->pharm_email ?? old('pharm_email') }}">
                        </div>

                        <div class="form-group">
                            <label for="owner_phone" class="form-label">Owner Phone</label>
                            <input type="text" class="form-control" id="owner_phone" name="owner_phone"
                                   value="{{ $store->owner_phone ?? old('owner_phone') }}">
                        </div>

                        <div class="form-group">
                            <label for="owner_email" class="form-label">Owner Email</label>
                            <input type="email" class="form-control" id="owner_email" name="owner_email"
                                   value="{{ $store->owner_email ?? old('owner_email') }}">
                        </div>

                        <div class="form-group">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="url" class="form-control" id="facebook" name="facebook"
                                   value="{{ $store->facebook ?? old('facebook') }}">
                        </div>

                        <div class="form-group">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="url" class="form-control" id="instagram" name="instagram"
                                   value="{{ $store->instagram ?? old('instagram') }}">
                        </div>

                        <div class="form-group">
                            <label for="twitter" class="form-label">Twitter</label>
                            <input type="url" class="form-control" id="twitter" name="twitter"
                                   value="{{ $store->twitter ?? old('twitter') }}">
                        </div>

                        <div class="form-group">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                   value="{{ $store->latitude ?? old('latitude') }}">
                        </div>

                        <div class="form-group">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                   value="{{ $store->longitude ?? old('longitude') }}">
                        </div>

                        <div class="form-group">
                            <label for="delivers" class="form-label">Delivers</label>
                            <select class="form-control" id="delivers" name="delivers" required>
                                <option value="1" {{ (isset($store) && $store->delivers == 1) ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ (isset($store) && $store->delivers == 0) ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <a href="{{ route('store.index') }}">
                            <button class="btn btn-primary btn-large">Go back to Stores</button>
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
