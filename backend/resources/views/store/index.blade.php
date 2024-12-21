@extends('layouts.layoutAdmin')
@section('title' ,'Manage Pharmacies')

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
        /* Add spacing between buttons */
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

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #155724;
        border-color: #c3e6cb;

    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }

    .filter-dropdown {
        margin-bottom: 20px;
        margin-left: 12px !important;
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
@if (session('message'))
<div class="alert alert-{{ session('alert-type', 'info') }}">
    {{ session('message') }}
</div>
@endif

<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="action-buttons">
                <!-- Add Product Button -->
                <button class="btn btn-success btn-large" onclick="window.location.href='{{ route('store.create')}}'" data-toggle="tooltip" data-original-title="Add Product">
                    <i class="material-symbols-rounded">add_circle</i> Add Pharmacy
                </button>


            </div>

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Pharmacies</h6>
                    </div>
                </div>

                <div class="card-body px-3 mx-3 pb-2">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('store.index') }}" class="filter-dropdown">
                                <label for="activeFilter" class="form-label">Filter by Status</label>
                                <select class="form-select form-select-sm" id="activeFilter" name="active" onchange="this.form.submit()">
                                    <option value="" {{ request('active') === null ? 'selected' : '' }}>All Pharmacies</option>
                                    <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Activated</option>
                                    <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Deactivated</option>
                                </select>
                            </form>
                        </div>
                    </div>



                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Store</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-secondary opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stores as $store)

                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">



                                            {{-- <h6 class="mb-0 text-sm text-danger">{{$productimage}}</h6>--}}
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$store->name}}</h6>
                                                <p class="text-xs text-secondary mb-0">Owner:{{$store->owner_name}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">

                                            <h6 class="mb-0 text-sm">{{$store->address}}</h6>
                                        </div>
                                    </td>


                                    <td class="align-middle text-center text-sm">
                                        @if( $store->active==1 )
                                        <span class="badge badge-sm bg-gradient-success">activated</span>
                                        @else
                                        <span class="badge badge-sm bg-gradient-danger">deactivated</span>
                                        @endif
                                    </td>

                                    <td class="align-middle">
                                        <!-- Activation/Deactivation Button -->
                                        <a href="javascript:void(0);"
                                            onclick="confirmStatusChange('{{ route('store.Status', ['id' => $store->id, 'visible' => $store->active]) }}', '{{ $store->active ? 'Deactivate' : 'Activate' }}')">
                                            <button class="btn btn-{{ $store->active ? 'danger' : 'success' }} btn-large"
                                                data-toggle="tooltip"
                                                data-original-title="{{ $store->active ? 'Deactivate store' : 'Activate store' }}">
                                                <i class="material-symbols-rounded">
                                                    {{ $store->active ? 'block' : 'check_circle' }}
                                                </i>
                                                {{ $store->active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </a>

                                        <!-- View Button -->
                                        <a href="{{ route('store.show', $store->id) }}">
                                            <button class="btn btn-info btn-large" data-toggle="tooltip" data-original-title="View store">
                                                <i class="material-symbols-rounded">visibility</i> View
                                            </button>
                                        </a>
                                    </td>


                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center mt-4">
                    <div>


                        {{ $stores->links('pagination::bootstrap-4') }}
                        <p class="text-muted">
                            Showing {{ $stores->firstItem() }} to {{ $stores->lastItem() }} of {{ $stores->total() }} results
                        </p>
                    </div>
                </div>
            </div>
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
            text: `Do you really want to ${action.toLowerCase()} this user?`,
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