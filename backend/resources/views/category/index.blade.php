@extends('layouts.layoutAdmin')

@section('title', 'View Categories')

@section('content')

<div class="action-buttons">
    <!-- Add Category Button -->
    <button class="btn btn-success btn-large" onclick="window.location.href='{{ route('category.create') }}'" data-toggle="tooltip" data-original-title="Add Category">
        <i class="material-symbols-rounded">add_circle</i> Add Category
    </button>
</div>

<div class="card my-4 mt-5">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Categories</h6>
        </div>
    </div>
    <div class="card-body px-3 mx-3 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                        <th class="text-secondary opacity-7">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $category->name }}</h6>
                                    </div>
                                </div>
                            </td>

                            <td class="align-middle">
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="delete-category-form" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-large" data-toggle="tooltip" data-original-title="Delete Category">
                                        <i class="material-symbols-rounded">delete</i> Delete
                                    </button>
                                </form>

                                <a href="{{ route('category.edit', $category->id) }}">
                                    <button class="btn btn-warning btn-large" data-toggle="tooltip" data-original-title="Edit Category">
                                        <i class="material-symbols-rounded">edit</i> Edit
                                    </button>
                                </a>

                                <!-- Button to Show Subcategories -->
                                @if($category->sub_category->count() > 0)
                                    <button class="btn btn-info btn-large" data-toggle="collapse" data-target="#subcategories_{{ $category->id }}">
                                        <i class="material-symbols-rounded">expand_more</i> Show Subcategories
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Subcategories Section -->
                        @if($category->sub_category->count() > 0)
                            <tr id="subcategories_{{ $category->id }}" class="collapse">
                                <td colspan="2">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-secondary opacity-7">Subcategory</th>
                                                <th class="text-secondary opacity-7">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category->sub_category as $subcategory)
                                                <tr>
                                                    <td>{{ $subcategory->name }}</td>
                                                    <td>
                                                        <form action="{{ route('subcategory.destroy', $subcategory->id) }}" method="POST" class="delete-subcategory-form" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-small" data-toggle="tooltip" data-original-title="Delete Subcategory">
                                                                <i class="material-symbols-rounded">delete</i> Delete
                                                            </button>
                                                        </form>

                                                        <a href="{{ route('subcategory.edit', $subcategory->id) }}">
                                                            <button class="btn btn-warning btn-small" data-toggle="tooltip" data-original-title="Edit Subcategory">
                                                                <i class="material-symbols-rounded">edit</i> Edit
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endif
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
    document.querySelectorAll('.delete-category-form').forEach(function (form) {
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

    document.querySelectorAll('.delete-subcategory-form').forEach(function (form) {
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

        // This script is for toggling the display of subcategories when the button is clicked
        document.addEventListener('DOMContentLoaded', function () {
        // Loop through all 'Show Subcategories' buttons
        const buttons = document.querySelectorAll('[data-toggle="collapse"]');
        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const target = document.querySelector(button.getAttribute('data-target'));
                if (target) {
                    // Toggle the collapse behavior
                    target.classList.toggle('collapse');
                }
            });
        });
    });
</script>
@endsection
