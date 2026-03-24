@extends('backend.layout.app')
@section('Title', 'Edit User')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-account-edit"></i></span>
                <span class="ml-1">Edit User</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit User</a></li>
            </ol>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-xl-8 col-xxl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit User - {{ $user->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Role *</label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="organizer" {{ old('role', $user->role) == 'organizer' ? 'selected' : '' }}>Organizer</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Changing role gives different access levels</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      name="bio" rows="4" placeholder="Describe the user...">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="{{ route('users.index') }}" class="btn btn-danger text-white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-xxl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>User ID:</strong> #{{ $user->id }}</p>
                    <p><strong>Member Since:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                    <p><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
