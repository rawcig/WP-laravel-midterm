@extends('backend.layout.app')
@section('Title', 'User Details')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-account"></i></span>
                <span class="ml-1">User Details</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">User Details</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        @if($user->avatar)
                            <img class="rounded-circle" src="{{ asset('storage/' . $user->avatar) }}" width="120" height="120" alt="{{ $user->name }}">
                        @else
                            <div class="rounded-circle bg-primary text-white d-inline-flex" style="width: 120px; height: 120px; align-items: center; justify-content: center; font-size: 48px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    
                    <h3 class="mb-1">{{ $user->name }}</h3>
                    <span class="badge badge-{{ $user->isAdmin() ? 'danger' : ($user->isOrganizer() ? 'primary' : 'secondary') }} mb-3">
                        {{ ucfirst($user->role) }}
                    </span>
                    
                    @if($user->bio)
                        <p class="text-muted">{{ $user->bio }}</p>
                    @endif

                    <ul class="card-profile__info text-left mt-4">
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
            </div>
        </div>

        <div class="col-lg-8 col-md-7">
            <!-- User Statistics -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary">
                                    <i class="mdi mdi-calendar"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="mb-0">{{ $user->events ? $user->events->count() : 0 }}</h4>
                                    <p class="mb-0 text-muted">Events Created</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-success">
                                    <i class="mdi mdi-ticket"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="mb-0">{{ $user->guests ? $user->guests->count() : 0 }}</h4>
                                    <p class="mb-0 text-muted">Event Registrations</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Account Information</h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">User ID:</th>
                            <td>#{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Role:</th>
                            <td>
                                <span class="badge badge-{{ $user->isAdmin() ? 'danger' : ($user->isOrganizer() ? 'primary' : 'secondary') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Member Since:</th>
                            <td>{{ $user->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $user->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin Actions</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary text-white">
                        <i class="mdi mdi-pencil"></i> Edit User
                    </a>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-white">
                                Delete User
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-box {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 28px;
    color: white;
}
.icon-box.bg-primary { background: linear-gradient(45deg, #7366ff, #5c4dff); }
.icon-box.bg-success { background: linear-gradient(45deg, #11c15b, #0cae52); }
</style>
@endsection
