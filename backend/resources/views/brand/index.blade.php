@extends('layouts.layoutAdmin')

@section('title', 'View Brands')

@section('content')

<div class="action-buttons">
    <!-- Add Brand Button -->
    <button class="btn btn-success btn-large" onclick="window.location.href='{{ route('brand.create') }}'" data-toggle="tooltip" data-original-title="Add Brand">
        <i class="material-symbols-rounded">add_circle</i> Add Brand
    </button>
</div>

<div class="card my-4 mt-5">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Brands</h6>
        </div>
    </div>
    <div class="card-body px-3 mx-3 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Brand</th>
                        <th class="text-secondary opacity-7">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $brand)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <!-- Display Brand Name and Image -->
                                        <h6 class="mb-0 text-sm">{{ $brand->name }}</h6>
                                        <img src="{{ asset('storage/' . $brand->image) }}" class="rounded-circle w-20" alt="{{ $brand->name }}">
                                    </div>
                                </div>
                            </td>

                            <td class="align-middle">
                                <!-- Delete Brand Form -->
                                <form action="" method="POST" class="delete-brand-form" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-large" data-toggle="tooltip" data-original-title="Delete Brand">
                                        <i class="material-symbols-rounded">delete</i> Delete
                                    </button>
                                </form>

                                <!-- Edit Brand Button -->
                                <!-- <a href="{{ route('brand.edit', $brand->id) }}">
                                    <button class="btn btn-warning btn-large" data-toggle="tooltip" data-original-title="Edit Brand">
                                        <i class="material-symbols-rounded">edit</i> Edit
                                    </button>
                                </a> -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    // SweetAlert for Delete Confirmation
    document.querySelectorAll('.delete-brand-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent the form from submitting immediately

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    form.submit();
                }
            });
        });
    });
</script>

@endsection
