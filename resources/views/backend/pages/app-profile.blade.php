@extends('backend.layout.app')
@section('Title', 'My Profile')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-account"></i></span>
                <span class="ml-1">My Profile</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
            </ol>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4 col-md-5 col-xxl-4 col-xl-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img class="rounded-circle" src="{{ $user->avatar_url }}" width="120" height="120" alt="{{ $user->name }}">
                    </div>
                    
                    <h3 class="mb-1">{{ $user->name }}</h3>
                    <span class="badge badge-{{ $user->isAdmin() ? 'danger' : ($user->isOrganizer() ? 'primary' : 'secondary') }} mb-3">
                        {{ ucfirst($user->role) }}
                    </span>
                    
                    @if($user->bio)
                        <p class="text-muted">{{ $user->bio }}</p>
                    @endif

                    <div class="row mb-4">
                        @if($user->isOrganizer() || $user->isAdmin())
                            <div class="col-6">
                                <div class="card-profile border-0 text-center">
                                    <span class="mb-1 text-primary"><i class="mdi mdi-calendar"></i></span>
                                    <h4 class="mb-0">{{ $eventsCount }}</h4>
                                    <p class="text-muted">Events</p>
                                </div>
                            </div>
                        @endif
                        <div class="col-6">
                            <div class="card-profile border-0 text-center">
                                <span class="mb-1 text-info"><i class="mdi mdi-account"></i></span>
                                <h4 class="mb-0">{{ $user->id }}</h4>
                                <p class="text-muted">User ID</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-block mb-2 text-white">
                        <i class="mdi mdi-pencil"></i> Edit Profile
                    </a>

                    <ul class="card-profile__info text-left">
                        @if($user->email)
                            <li class="mb-2">
                                <strong><i class="mdi mdi-email mr-2"></i>Email:</strong>
                                <br>
                                <span class="ml-4">{{ $user->email }}</span>
                            </li>
                        @endif
                        @if($user->phone)
                            <li class="mb-2">
                                <strong><i class="mdi mdi-phone mr-2"></i>Phone:</strong>
                                <br>
                                <span class="ml-4">{{ $user->phone }}</span>
                            </li>
                        @endif
                        <li class="mb-2">
                            <strong><i class="mdi mdi-clock mr-2"></i>Member Since:</strong>
                            <br>
                            <span class="ml-4">{{ $user->created_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer border-0 pb-4">
                    <div class="card-action social-icons text-center">
                        <a class="facebook" href="javascript:void(0)"><span><i class="fa fa-facebook"></i></span></a>
                        <a class="twitter" href="javascript:void(0)"><span><i class="fa fa-twitter"></i></span></a>
                        <a class="youtube" href="javascript:void(0)"><span><i class="fa fa-youtube"></i></span></a>
                        <a class="googlePlus" href="javascript:void(0)"><span><i class="fa fa-google"></i></span></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="col-lg-8 col-md-7 col-xxl-8 col-xl-9">
            <!-- Account Settings -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Account Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Full Name</label>
                            <h5>{{ $user->name }}</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email Address</label>
                            <h5>{{ $user->email }}</h5>
                        </div>
                        @if($user->phone)
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Phone Number</label>
                                <h5>{{ $user->phone }}</h5>
                            </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Account Role</label>
                            <h5>
                                <span class="badge badge-{{ $user->isAdmin() ? 'danger' : ($user->isOrganizer() ? 'primary' : 'secondary') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </h5>
                        </div>
                        @if($user->bio)
                            <div class="col-12 mb-3">
                                <label class="text-muted small">Bio</label>
                                <p class="mb-0">{{ $user->bio }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Password</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Current Password *</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       name="current_password" placeholder="Enter current password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>New Password *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" placeholder="Enter new password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Confirm Password *</label>
                                <input type="password" class="form-control"
                                       name="password_confirmation" placeholder="Confirm new password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-lock"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Account Activity</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="mdi mdi-account-circle text-primary mr-2"></i>
                            <strong>Account Created:</strong> {{ $user->created_at->format('M d, Y h:i A') }}
                        </li>
                        <li class="list-group-item">
                            <i class="mdi mdi-clock text-muted mr-2"></i>
                            <strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y h:i A') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
