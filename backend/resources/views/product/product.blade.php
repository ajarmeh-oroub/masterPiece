@extends('layouts.layoutAdmin')
@section('title' ,'Manage products')

@section('style')
<style>
    .btn-large {
        padding: 6px 12px !important;
        /* Adjust padding */
        font-size: 12px !important;
        /* Font size */
        line-height: 1.3 !important;
        /* Adjust line height */
    }

    .btn {
        margin-right: 5px;
        margin-top: 12px !important;
   
    }

    .btn-info,
    .btn-warning,
    .btn-danger {
        min-width: 100px;
        /* Set minimum width for consistency */
    }

    .action-buttons {
        margin-bottom: 15px;
        /* Add some space between buttons and table */
    }

    .form-control {
        margin-left: 10px !important;
        margin-top: 12px !important;
        padding: 6px !important;
        border-color: lightgray !important;
    }

    .filter-dropdown {
        margin-bottom: 20px;
        /* Space below the dropdown */
    }

    .form-select {
        border-radius: 5px !important;
        border: 1px solid #ccc !important;
        padding: 8px 14px !important;
        max-width: 250px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-2">
    <div class="row">
    @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display Error Message -->
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        <div class="col-12">
            <div class="action-buttons">
                <!-- Add Product Button -->
                <button class="btn btn-success btn-large" onclick="window.location.href='{{ route('product.create')}}'" data-toggle="tooltip" data-original-title="Add Product">
                    <i class="material-symbols-rounded">add_circle</i> Add Product
                </button>

                <!-- View Categories Button -->

                <button class="btn btn-primary btn-large" onclick="window.location.href='{{route('category.index')}}'" data-toggle="tooltip" data-original-title="View Categories">
                    <i class="material-symbols-rounded">category</i> View Categories
                </button>

            
            </div>

            <div class="card my-4 mx-3 px-3">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Products</h6>
                    </div>
                </div>
                <form action="{{ route('product.index') }}" method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ $searchQuery }}">
                        </div>
                        <div class="col-md-4">
                            <select name="store_id" class="form-control">
                                <option value="">All Stores</option>
                                @foreach($stores as $store) <!-- Assume you load stores -->
                                <option value="{{ $store->id }}" {{ $storeId == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">product</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-secondary opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)

                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">


                                        <img src="{{ asset('storage/'.$product->main_image) }}" alt="Product Image"  class="avatar avatar-sm me-3 border-radius-lg">


                                            {{-- <h6 class="mb-0 text-sm text-danger">{{$productimage}}</h6>--}}
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$product->name}}</h6>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            @if($product->stock <=10)
                                                <h6 class="mb-0 text-sm text-danger">{{$product->stock}}</h6>
                                                @else
                                                <h6 class="mb-0 text-sm">{{$product->stock}}</h6>
                                                @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{$product->price}}JOD</h6>
                                        </div>
                                    </td>

                                    <td class="align-middle text-center text-sm">
                                        @if( $product->visible==1 )
                                        <span class="badge badge-sm bg-gradient-success">activated</span>
                                        @else
                                        <span class="badge badge-sm bg-gradient-danger">deactivated</span>
                                        @endif
                                    </td>

                                    <td class="align-middle">
                                        <a href="javascript:void(0);" onclick="confirmStatusChange('{{ route('product.Status', ['id' => $product->id, 'visible' => $product->visible]) }}', '{{ $product->visible ? 'Deactivate' : 'Activate' }}')">
                                            <button
                                                class="btn btn-{{ $product->visible ? 'danger' : 'success' }} btn-large"
                                                data-toggle="tooltip"
                                                data-original-title="{{ $product->visible ? 'Deactivate product' : 'Activate product' }}">
                                                <i class="material-symbols-rounded">
                                                    {{ $product->visible ? 'block' : 'check_circle' }}
                                                </i>
                                                {{ $product->visible ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </a>

                                        <a href="{{ route('product.show', $product->id) }}">
                                            <button class="btn btn-info btn-large" data-toggle="tooltip" data-original-title="View product">
                                                <i class="material-symbols-rounded">visibility</i> View
                                            </button>
                                        </a>

                                        <a href="{{ route('product.edit', $product->id) }}">
                                            <button class="btn btn-warning btn-large" data-toggle="tooltip" data-original-title="Edit product">
                                                <i class="material-symbols-rounded">edit</i> Edit
                                            </button>
                                        </a>
                                    </td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-4">

            {{ $products->links('pagination::bootstrap-4') }}
            <p class="text-muted">
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
            </p>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function confirmStatusChange(url, action) {
        // Use SweetAlert2 to confirm action
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you really want to ${action.toLowerCase()} this product?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, ' + action.toLowerCase() + ' it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, redirect to the route
                window.location.href = url;
            }
        });
    }
</script>
@endsection