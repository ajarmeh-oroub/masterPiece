@extends('layouts.layoutAdmin')
@section('title', 'Manage Orders')

@section('style')
<style>
    /* Custom styles remain the same */
    .btn-large {
        padding: 6px 12px !important;
        font-size: 12px !important;
        line-height: 1.3 !important;
    }
    .btn {
        margin-right: 5px;
    }
    .btn-info,
    .btn-warning,
    .btn-danger {
        min-width: 100px;
    }
    .action-buttons {
        margin-bottom: 15px;
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
</style>
@endsection

@section('content')
@if (session('message'))
<div class="alert alert-{{ session('alert-type', 'info') }}">
    {{ session('message') }}
</div>
@endif

<div class="container-fluid py-2">
    <div class="row ">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Orders</h6>
                    </div>
                </div>

                <div class="card-body px-3 pb-2 mx-3">
                    <form method="GET" action="{{ route('order.index') }}" class="mb-4">
                        <div class="row">
                            <!-- Filter by Status -->
                            <div class="col-md-3">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="" selected>All Orders</option>
                                 
                                    <option value="Processing" {{ request()->status == 'Processing' ? 'selected' : '' }}>Completed</option>
                                    <option value="Pending" {{ request()->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Delivered" {{ request()->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="Shipped" {{ request()->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="Canceled" {{ request()->status == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                            </div>

                            <!-- Filter by Pharmacy -->
                            <div class="col-md-3">
                                <select name="pharmacy" class="form-control" onchange="this.form.submit()">
                                <option value="" selected>All pharmacies</option>
                                    @foreach($pharmacies as $pharmacy)
                                    
                                        <option value="{{ $pharmacy->id }}" {{ request()->pharmacy == $pharmacy->id ? 'selected' : '' }}>
                                            {{ $pharmacy->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pharmacy</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $order->user->first_name }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $order->pharmacy->name }}</h6>
                                        </div>
                                    </td>

                                    <td class="align-middle text-center text-sm">
                                        @if($order->status == 'Processing')
                                            <span class="badge badge-sm bg-gradient-success">Completed</span>
                                        @elseif($order->status == 'Pending')
                                            <span class="badge badge-sm bg-gradient-secondary">Pending</span>
                                        @elseif($order->status == 'Delivered')
                                            <span class="badge badge-sm bg-gradient-success">Delivered</span>
                                        @elseif($order->status == 'Shipped')
                                            <span class="badge badge-sm bg-gradient-warning">Shipped</span>
                                        @elseif($order->status == 'Canceled')
                                            <span class="badge badge-sm bg-gradient-danger">Canceled</span>
                                        @else
                                            <span ></span>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center text-sm">
                                        <span class="text-sm">${{ number_format($order->total, 2) }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center mt-4">
                    <div>
                        {{ $orders->links('pagination::bootstrap-4') }}
                        <p class="text-muted">
                            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
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
</script>
@endsection
