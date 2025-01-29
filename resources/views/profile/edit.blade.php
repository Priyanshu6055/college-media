<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        
                    </div>

                    <div class="card-body">
                        <!-- Profile Update Form -->
                        @include('profile.partials.update-profile-information-form')

                        <!-- Change Password Form -->
                        @include('profile.partials.update-password-form')

                        <!-- Delete User Form -->
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
