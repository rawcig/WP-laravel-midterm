@extends('backend.layout.app')
@section('Title', 'Edit Event')
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
                <span><i class="icon-calender"></i></span>
                <span class="ml-1">Edit Event</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Event</a></li>
            </ol>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Event - {{ $event->title }}</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Event Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           name="title" value="{{ old('title', $event->title) }}" placeholder="Enter event title" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Organizer *</label>
                                    <select name="organizer" id="organizer" class="form-control @error('organizer') is-invalid @enderror" required>
                                        <option value="">Select Organizer</option>
                                        @if ($organizers->isEmpty())
                                            <option value="" disabled>No organizers available</option>
                                        @else
                                            @foreach ($organizers as $organizer)
                                                <option value="{{ $organizer->name }}"
                                                    {{ old('organizer', $event->organizer ? $event->organizer->name : '') == $organizer->name ? 'selected' : '' }}>
                                                    {{ $organizer->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('organizer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($organizers->isEmpty())
                                        <small class="text-danger">Please create an organizer first!</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description" rows="4" placeholder="Enter event description" required>{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Cover Image</label>
                                @if($event->cover_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $event->cover_image) }}" alt="Current cover" style="max-width: 300px; border-radius: 8px;">
                                        <p class="text-muted small mt-1">Current cover image</p>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                       name="cover_image" accept="image/*">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended size: 1200x600px (JPG, PNG). Leave empty to keep current image.</small>
                            </div>
                            <div class="form-group">
                                <label>Detail Image</label>
                                @if($event->detail_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $event->detail_image) }}" alt="Current detail" style="max-width: 300px; border-radius: 8px;">
                                        <p class="text-muted small mt-1">Current detail image</p>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('detail_image') is-invalid @enderror"
                                       name="detail_image" accept="image/*">
                                @error('detail_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended size: 800x600px (JPG, PNG, max 5MB). Leave empty to keep current image.</small>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Event Date *</label>
                                    <input type="datetime-local" class="form-control @error('date') is-invalid @enderror"
                                           name="date" value="{{ old('date', $event->date->format('Y-m-d\TH:i')) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                           name="location" value="{{ old('location', $event->location) }}" placeholder="Enter event location">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                        <option value="">Select status</option>
                                        <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Event</button>
                            <a href="{{ route('events.index') }}" class="btn btn-danger text-white">
                                Cancel
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
