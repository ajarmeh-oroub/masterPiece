@extends('layouts.layoutAdmin')

@section('title', isset($review) ? 'View Review Details' : 'Add Review')

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
                                {{ isset($contact) ? 'View Contact Details' : 'Add New Contact' }}
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $contact->name ?? old('name') }}"  readonly required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                   value="{{ $contact->email ?? old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject"
                                   value="{{ $contact->subject ?? old('subject') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="price" class="form-label">Message</label>
                            <input type="text" step="0.01" class="form-control" id="price" name="price"
                                   value="{{ $contact->message ?? old('price') }}"
                                   {{ isset($contact) ? 'readonly' : '' }} required>
                        </div>

<div class="form-group">
    @if( $contact->status=='responded' )
        <span class="badge badge-sm bg-gradient-success">Responded</span>
    @elseif($contact->status=='unread')
        <span class="badge badge-sm bg-gradient-danger">Unread</span>
    @else
        <span class="badge badge-sm bg-gradient-warning">read</span>
    @endif
</div>




                        <a href="{{ route('contact.index')}}">
                            <button class="btn btn-secondary btn-large">Go back to Contacts</button>
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
