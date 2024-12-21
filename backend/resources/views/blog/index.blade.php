
@extends('layouts.layoutAdmin')
@section('title' ,'Manage products')

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
    </style>
@endsection

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="action-buttons">
                    <!-- Add Product Button -->
                    <button class="btn btn-success btn-large" onclick="window.location.href='{{ route('blog.create')}}'" data-toggle="tooltip" data-original-title="Add Product">
                        <i class="material-symbols-rounded">add_circle</i> Add Blog
                    </button>

                    <!-- View Categories Button -->

                </div>

                <div class="card my-4 px-3 mx-3">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Blogs</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Blog</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>

                                    <th class="text-secondary opacity-7">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blogs as $blog)

                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">


                                                    <img src="{{ asset('storage/' . $blog->image) }}" alt="Product Image " class="avatar avatar-sm me-3 border-radius-lg">


                                                {{--                                            <h6 class="mb-0 text-sm text-danger">{{$productimage}}</h6>--}}
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$blog->title}}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{$blog->created_at}}</p>
                                                </div>
                                            </div>
                                        </td>


                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$blog->user->first_name}} {{$blog->user->last_name}}</h6> </div>
                                        </td>



                                        <td class="align-middle">


                                            <a href="{{ route('blog.show', $blog->id) }}">
                                                <button class="btn btn-info btn-large" data-toggle="tooltip" data-original-title="View product">
                                                    <i class="material-symbols-rounded">visibility</i> View
                                                </button>
                                            </a>

                                            <a href="{{ route('blog.edit', $blog->id) }}">
                                                <button class="btn btn-warning btn-large" data-toggle="tooltip" data-original-title="Edit product">
                                                    <i class="material-symbols-rounded">edit</i> Edit
                                                </button>
                                            </a>

                                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                        <form id="deleteForm" action="{{ route('blog.destroy', $blog->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                                        </td>


                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        function confirmDelete() {
            // Trigger SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with deletion (you can submit a form or make an Ajax call)
                    // Example: Trigger the delete action using a form submission
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
@endsection

