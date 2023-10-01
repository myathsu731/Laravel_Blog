@extends('layouts.app')
@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::get('success') && Session::get('success') != null)
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @php
                Session::put('success', null)
            @endphp
        @endif
        <form method="post">
        @csrf
            <div class="mb-3 col-4">
                <label>Your Name:</label>
                <input type="text" name="name" value="{{$user->name}}" class="form-control" readonly="readonly">
            </div>
            <div class="mb-3 col-4">
                <label>Your Email:</label>
                <input type="text" name="email" value="{{$user->email}}" class="form-control" readonly="readonly">
            </div>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editProfile">Edit Profile</button>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#changePassword">Change Password</button>
        </form>
    </div>

    <!-- Profile Edit Modal -->
    <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="editProfileTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileTitle">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url("/profile/update") }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label>Your Name:</label>
                            <input type="text" name="name" value="{{$user->name}}" class="form-control">
                        </div>
                        <div class="mb-3 ">
                            <label>Your Email:</label>
                            <input type="text" name="email" value="{{$user->email}}" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Update Profile" class="btn btn-secondary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Modal-->
    <!-- Change Password Modal -->
    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordTitle">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url("/profile/change_password") }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Change Password" class="btn btn-secondary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Modal-->
@endsection