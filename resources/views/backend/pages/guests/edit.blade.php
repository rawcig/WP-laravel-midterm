@extends('backend.layout.app')
@section('Title', 'Edit Guest')
@section('CreateEvent')
    <li class="nav-item border-0">
        <a class="btn btn-secondary create-event-btn" href="{{ route('create-event') }}">Create Event</a>
    </li>
@endsection
@section('AddGuest')
    <li class="nav-item border-0">
        <a class="btn btn-success create-event-btn" href="{{ route('guests.create') }}">Add Guest</a>
    </li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-account-edit"></i></span>
                <span class="ml-1">Edit Guest</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('guests.index') }}">Guests</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Guest</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-xxl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Guest - {{ $guest->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('guests.update', $guest) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Guest Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name', $guest->name) }}" placeholder="Enter guest name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email', $guest->email) }}" placeholder="Enter email address" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone', $guest->phone) }}" placeholder="Enter phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Event *</label>
                                <select name="event_id" class="form-control @error('event_id') is-invalid @enderror" required>
                                    <option value="">Select Event</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" {{ old('event_id', $guest->event_id) == $event->id ? 'selected' : '' }}>
                                            {{ $event->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('event_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Status *</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">Select status</option>
                                    <option value="pending" {{ old('status', $guest->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status', $guest->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="declined" {{ old('status', $guest->status) == 'declined' ? 'selected' : '' }}>Declined</option>
                                    <option value="attended" {{ old('status', $guest->status) == 'attended' ? 'selected' : '' }}>Attended</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Number of Tickets *</label>
                                <input type="number" class="form-control @error('ticket_count') is-invalid @enderror"
                                       name="ticket_count" value="{{ old('ticket_count', $guest->ticket_count) }}" min="1" max="10" required>
                                @error('ticket_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>&nbsp;</label>
                                <p class="text-muted small">Maximum 10 tickets per guest</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      name="notes" rows="3" placeholder="Additional notes about this guest">{{ old('notes', $guest->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Guest</button>
                        <a href="{{ route('guests.index') }}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
