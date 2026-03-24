@extends('backend.layout.app')
@section('Title', 'Add Organizer')
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
                <span><i class="mdi mdi-account-plus"></i></span>
                <span class="ml-1">Add Organizer</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('organizer.index') }}">Organizers</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Organizer</a></li>
            </ol>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Organizer</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('organizer.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Organizer Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" placeholder="Enter organizer name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Phone Number *</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Website</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                           name="website" value="{{ old('website') }}" placeholder="https://example.com">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description" rows="4" placeholder="Enter organizer description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Create Organizer</button>
                            <a href="javascript:history.back()" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
