@extends('layouts.layoutAdmin')
@section('title' ,'Manage Reviews')

@section('style')
    <style>
        .btn-large {
            padding: 6px 12px !important; /* Adjust padding */
            font-size: 12px !important;   /* Font size */
            line-height: 1.3 !important;  /* Adjust line height */
        }

        .btn {
            margin-right: 5px; /* Add spacing between buttons */
        }

        .btn-info, .btn-warning, .btn-danger {
            min-width: 100px; /* Set minimum width for consistency */
        }

        .action-buttons {
            margin-bottom: 15px; /* Add some space between buttons and table */
        }
        .filter-dropdown {
            margin-bottom: 20px;
            margin-left:12px !important; /* Space below the dropdown */
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
            <div class="col-12">


                <div class="card my-4 mx-3 px-3">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Contacts</h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('contact.index') }}" class="filter-dropdown">
                                <label for="activeFilter" class="form-label">Filter by Status</label>
                                <select class="form-select form-select-sm" id="activeFilter" name="status" onchange="this.form.submit()">
                                    <option value="" {{ request('status') === null ? 'selected' : '' }}>All comments</option>
                                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                                    <option value="responded" {{ request('status') == 'responded' ? 'selected' : '' }}>Responded</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contact Id</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $contacts as $contact)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">

                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$contact->id}}</h6>

                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex px-2 py-1">

                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$contact->name}} </h6>

                                                </div>
                                            </div>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            @if( $contact->status=='responded' )
                                                <span class="badge badge-sm bg-gradient-success">Responded</span>
                                            @elseif($contact->status=='unread')
                                                <span class="badge badge-sm bg-gradient-danger">Unread</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-warning">read</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('contact.show', $contact->id) }}">
                                                <button class="btn btn-info btn-large" data-toggle="tooltip" data-original-title="View product">
                                                    <i class="material-symbols-rounded">visibility</i> View and replay
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


                            {{ $contacts->links('pagination::bootstrap-4') }}
                            <p class="text-muted">
                                Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of {{ $contacts->total() }} results
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
