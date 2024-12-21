@extends('layouts.layoutAdmin')

@section('title', 'Add New Pharmacy')

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
        font-size: 0.9rem;
        margin-top: 5px;
    }

    #address + ul {
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 4px;
    max-height: 200px;
    overflow-y: auto;
    width: 100%;
    margin-top: 5px;
    z-index: 999;
}

#address + ul li {
    padding: 10px;
    cursor: pointer;
}

#address + ul li:hover {
    background-color: #f0f0f0;
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
                            Add New Pharmacy
                        </h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('store.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Store Name -->
                        <div class="form-group">
                            <label for="name" class="form-label">Pharmacy Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" required>
                            @error('description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                  

                        <!-- Phone -->
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="phone" class="form-label">Email</label>
                            <input type="Email" class="form-control" id="phone" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Owner Name -->
                        <div class="form-group">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ old('owner_name') }}" required>
                            @error('owner_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Store Email -->
                        <div class="form-group">
                            <label for="store_email" class="form-label">Pharmacy Email</label>
                            <input type="email" class="form-control" id="store_email" name="store_email" value="{{ old('store_email') }}" required>
                            @error('store_email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Logo -->
                        <div class="form-group">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" onchange="previewImage(event, 'logo-preview')">
                            <img id="logo-preview" class="image-preview" style="display:none;" />
                            @error('logo')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Additional Fields -->
                        <div class="form-group">
                            <label for="pharm_phone" class="form-label">Pharmacy Phone</label>
                            <input type="text" class="form-control" id="pharm_phone" name="pharm_phone" value="{{ old('pharm_phone') }}">
                            @error('pharm_phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="pharm_email" class="form-label">Pharmacy Email</label>
                            <input type="email" class="form-control" id="pharm_email" name="pharm_email" value="{{ old('pharm_email') }}">
                            @error('pharm_email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="owner_phone" class="form-label">Owner Phone</label>
                            <input type="text" class="form-control" id="owner_phone" name="owner_phone" value="{{ old('owner_phone') }}">
                            @error('owner_phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="owner_email" class="form-label">Owner Email</label>
                            <input type="email" class="form-control" id="owner_email" name="owner_email" value="{{ old('owner_email') }}">
                            @error('owner_email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="url" class="form-control" id="facebook" name="facebook" value="{{ old('facebook') }}">
                            @error('facebook')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="url" class="form-control" id="instagram" name="instagram" value="{{ old('instagram') }}">
                            @error('instagram')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="twitter" class="form-label">Twitter</label>
                            <input type="url" class="form-control" id="twitter" name="twitter" value="{{ old('twitter') }}">
                            @error('twitter')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" onblur="getCoordinatesFromAddress()" autocomplete="off">
    @error('address')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="latitude" class="form-label">Latitude</label>
    <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}">
    @error('latitude')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="longitude" class="form-label">Longitude</label>
    <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}">
    @error('longitude')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


                        <div class="form-group">

                            <div class="form-check form-switch">
                                <!-- Hidden input to ensure value is sent when unchecked -->
                                <input type="hidden" name="delivers" value="0">

                                <!-- Checkbox with Bootstrap switch style -->
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="delivers"
                                    name="delivers"
                                    value="1"
                                    {{ old('delivers') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="delivers">Does the pharmacy deliver?</label>
                            </div>



                            @error('delivers')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success btn-large">Save Pharmacy</button>

                        <a href="{{ route('store.index') }}">
                            <button type="button" class="btn btn-secondary btn-large">Cancel</button>
                        </a>
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
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById(previewId);
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

  


    const addressInput = document.getElementById('address');
    const addressList = document.createElement('ul'); // Create a list to show suggestions
    addressInput.parentElement.appendChild(addressList); // Append the list to the parent

    addressInput.addEventListener('input', function () {
        const query = addressInput.value.trim();
        if (query.length > 2) { // Only start fetching suggestions when 3 characters are entered
            fetch(`https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(query)}&key=&no_annotations=1`)
                .then(response => response.json())
                .then(data => {
                    if (data.results.length > 0) {
                        const suggestions = data.results.slice(0, 5); // Limit to 5 suggestions
                        addressList.innerHTML = ''; // Clear previous suggestions

                        suggestions.forEach(result => {
                            const li = document.createElement('li');
                            li.textContent = result.formatted;
                            li.addEventListener('click', () => selectAddress(result));
                            addressList.appendChild(li);
                        });
                    } else {
                        addressList.innerHTML = ''; // Clear if no results
                    }
                })
                .catch(error => console.error('Error fetching address suggestions:', error));
        } else {
            addressList.innerHTML = ''; // Clear if input is too short
        }
    });

    // Handle address selection
    function selectAddress(result) {
        addressInput.value = result.formatted; // Set input value to selected address
        document.getElementById('latitude').value = result.geometry.lat;
        document.getElementById('longitude').value = result.geometry.lng;
        addressList.innerHTML = ''; // Clear suggestions after selection
    }



</script>
@endsection