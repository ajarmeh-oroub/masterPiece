@extends('layouts.layoutAdmin')

@section('title', isset($comment) ? 'View Comment Details' : 'Add Comment')

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
                                {{ isset($comment) ? 'View Comment Details' : 'Add New Comment' }}
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name" class="form-label">Blog Title</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $comment->blog->title ?? old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $comment->user->first_name ?? old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="form-label">Comment</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $comment->content ?? old('name') }}" required>
                        </div>







                        <a href="{{ route('comment.index')}}">
                            <button class="btn btn-secondary btn-large">Go back to Comments</button>
                        </a>

                        <a href="{{ route('comment.status', ['id' => $comment->id, 'visible' => $comment->approved]) }}">
                            <button
                                class="btn btn-{{ $comment->approved ? 'danger' : 'success' }} btn-large"
                                data-toggle="tooltip"
                                data-original-title="{{ $comment->approved  ? 'Deactivate product' : 'Activate product' }}">
                                <i class="material-symbols-rounded">
                                    {{ $comment->approved  ? 'block' : 'check_circle' }}
                                </i>
                                {{ $comment->approved  ? 'Deactivate' : 'Activate' }}
                            </button>
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
