@extends('backend.layout.app')
@section('Title', 'Edit Profile')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-account-edit"></i></span>
                <span class="ml-1">Edit Profile</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('app-profile') }}">Profile</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Profile</a></li>
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
                    <h4 class="card-title">Profile Information</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Avatar Upload -->
                        <div class="form-group text-center mb-4">
                            <label class="d-block">
                                @if($user->avatar)
                                    <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" 
                                         alt="Avatar" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div id="avatar-preview" class="rounded-circle bg-primary text-white d-inline-flex" 
                                         style="width: 120px; height: 120px; align-items: center; justify-content: center; font-size: 48px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </label>
                            <div class="mt-2">
                                <input type="file" class="form-control d-inline-block" style="width: auto;" 
                                       name="avatar" id="avatar-input" accept="image/*" onchange="previewAvatar(event)">
                                <small class="text-muted d-block mt-1">JPG, PNG or GIF. Max size 2MB</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name', $user->name) }}" placeholder="Enter your name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email', $user->email) }}" placeholder="Enter your email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Enter your phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Role</label>
                                <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                                <small class="text-muted">Contact admin to change role</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      name="bio" rows="4" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maximum 500 characters</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-check"></i> Save Changes
                            </button>
                            <a href="{{ route('app-profile') }}" class="btn btn-secondary">
                                <i class="mdi mdi-close"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="col-xl-4 col-xxl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Quick Info</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>User ID:</strong> #{{ $user->id }}
                        </li>
                        <li class="list-group-item">
                            <strong>Member Since:</strong> {{ $user->created_at->format('M d, Y') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Last Login:</strong> {{ now()->format('M d, Y h:i A') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Account Status:</strong>
                            <span class="badge badge-success">Active</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Need Help?</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Having trouble editing your profile? Contact support for assistance.</p>
                    <a href="mailto:support@example.com" class="btn btn-info btn-block">
                        <i class="mdi mdi-email"></i> Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewAvatar(event) {
    var input = event.target;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('avatar-preview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                preview.outerHTML = '<img id="avatar-preview" src="' + e.target.result + '" alt="Avatar" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">';
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
