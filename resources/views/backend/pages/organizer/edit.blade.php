@extends('backend.layout.app')
@section('Title', 'Edit Organizer')
@section('CreateEvent')
    <li class="nav-item border-0">
        <a class="btn btn-secondary create-event-btn" href="{{ route('create-event') }}">Create Event</a>
    </li>
@endsection
@section('AddOrganizer')
    <li class="nav-item border-0">
        <a class="btn btn-secondary create-event-btn" href="{{ route('organizer.create') }}">Add Organizer</a>
    </li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-account-edit"></i></span>
                <span class="ml-1">Edit Organizer</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('organizer.index') }}">Organizers</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Organizer</a></li>
            </ol>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Organizer</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('organizer.update', $organizer) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Organizer Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name', $organizer->name) }}" placeholder="Enter organizer name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email', $organizer->email) }}" placeholder="Enter email address" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Phone Number *</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           name="phone" value="{{ old('phone', $organizer->phone) }}" placeholder="Enter phone number" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Website</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                           name="website" value="{{ old('website', $organizer->website) }}" placeholder="https://example.com">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description" rows="4" placeholder="Enter organizer description">{{ old('description', $organizer->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update Organizer</button>
                            <a href="{{ route('organizer.index') }}" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
