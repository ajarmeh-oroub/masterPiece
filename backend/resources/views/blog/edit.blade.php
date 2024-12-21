@extends('layouts.layoutAdmin')

@section('title', isset($blog) ? 'Edit Blog' : 'Add Blog')

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

        .invalid-feedback {
            display: block;
            color: #dc3545;
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
                                {{ isset($blog) ? 'Edit Blog' : 'Add New Blog' }}
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Open the form for editing or creating -->
                        <form method="POST" enctype="multipart/form-data" action="{{ isset($blog) ? route('blog.update', $blog->id) : route('blog.store') }}">
                            @csrf
                            @if(isset($blog))
                                @method('PUT') <!-- For update request -->
                            @endif

                            <div class="form-group">
                                <label for="title" class="form-label">Blog Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                       value="{{ old('title', $blog->title ?? '') }}" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5" required>{{ old('content', $blog->content ?? '') }}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author"
                                       value="{{ old('author', $blog->user->first_name . ' ' . $blog->user->last_name ?? '') }}" readonly>
                                @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- For images -->
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="front_image" class="form-label">Featured Image</label>
                                    @if(isset($blog) && $blog->image)
                                        <img class="image-preview" src="{{ asset('storage/' . $blog->image) }}" alt="Featured Image">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="front_image" name="image" accept="image/*" onchange="previewImage(event, 'frontPreview')">
                                    @else
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="front_image" name="image" accept="image/*" onchange="previewImage(event, 'frontPreview')" required>
                                        <img id="frontPreview" class="image-preview" src="#" alt="Front Image Preview" style="display:none;">
                                    @endif
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group text-start mt-2">
                                <button type="submit" class="btn btn-primary btn-large">{{ isset($blog) ? 'Update Blog' : 'Add Blog' }}</button>
                                <a href="{{ route('blog.index') }}">
                                    <button type="button" class="btn btn-secondary btn-large">Go back to Blogs</button>
                                </a>
                            </div>
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
