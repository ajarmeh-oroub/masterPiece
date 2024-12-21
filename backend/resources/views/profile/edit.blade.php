@extends('layouts.layoutAdmin')

@section('title', 'Manage your profile')

@section('content')
    <div class="container py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Information Section -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="max-w-xl mx-auto">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Update Profile Information</h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Update Section -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="max-w-xl mx-auto">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Update Password</h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User Section -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="max-w-xl mx-auto">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Delete Account</h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
@endsection
