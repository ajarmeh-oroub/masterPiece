@extends('layouts.layoutAdmin')

@section('title', isset($blog) ? 'View Blog Details' : 'Add Blog')

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
                                {{ isset($blog) ? 'View Blog Details' : 'Add New Blog' }}
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name" class="form-label">Blog Title</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $blog->title ?? old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="form-label">Content</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $blog->content ?? old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="price" class="form-label">Author</label>
                            <input type="text" step="0.01" class="form-control" id="price" name="price"
                                   value="{{ $blog->user->first_name . ' ' . $blog->user->last_name ?? old('user_name') }}"

                                   {{ isset($blog) ? 'readonly' : '' }} required>
                        </div>


                        <!-- For images -->
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="front_image" class="form-label">Featured Image</label>
                                @if(isset($blog) && $blog->image)
                                    <img class="image-preview" src="{{ asset('storage/' . $blog->image) }}" alt="Front Image">
                                @else
                                    <input type="file" class="form-control" id="front_image" name="front_image" accept="image/*" onchange="previewImage(event, 'frontPreview')" required>
                                    <img id="frontPreview" class="image-preview" src="#" alt="Front Image Preview" style="display:none;">
                                @endif
                            </div>


                        </div>


                        <a href="{{ route('blog.index')}}">
                            <button class="btn btn-secondary btn-large">Go back to Blogs</button>
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
