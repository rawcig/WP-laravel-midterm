@extends('backend.layout.app')
@section('Title', 'Guest Details')
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
                <span><i class="mdi mdi-account"></i></span>
                <span class="ml-1">Guest Details</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('guests.index') }}">Guests</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Guest Details</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex p-4 mb-3">
                            <i class="mdi mdi-account" style="font-size: 48px;"></i>
                        </div>
                        <h3 class="mb-0">{{ $guest->name }}</h3>
                        <span class="badge badge-{{
                            $guest->status === 'confirmed' ? 'success' :
                            ($guest->status === 'declined' ? 'danger' :
                            ($guest->status === 'attended' ? 'info' : 'warning'))
                            }} mt-2">
                            {{ ucfirst($guest->status) }}
                        </span>
                    </div>

                    <hr>

                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <strong><i class="mdi mdi-email mr-2"></i>Email:</strong>
                            <br>
                            <a href="mailto:{{ $guest->email }}">{{ $guest->email }}</a>
                        </li>
                        @if($guest->phone)
                            <li class="mb-3">
                                <strong><i class="mdi mdi-phone mr-2"></i>Phone:</strong>
                                <br>
                                <a href="tel:{{ $guest->phone }}">{{ $guest->phone }}</a>
                            </li>
                        @endif
                        <li class="mb-3">
                            <strong><i class="mdi mdi-ticket mr-2"></i>Tickets:</strong>
                            <br>
                            <span class="badge badge-secondary">{{ $guest->ticket_count }} ticket(s)</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('guests.edit', $guest) }}" class="btn btn-primary btn-block">Edit</a>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('guests.destroy', $guest) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this guest?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Event Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Event</label>
                            <h5><a href="{{ route('events.show', $guest->event) }}">{{ $guest->event->title }}</a></h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Event Date</label>
                            <h5>{{ $guest->event->date->format('M d, Y h:i A') }}</h5>
                        </div>
                        @if($guest->event->location)
                            <div class="col-md-6 mb-3">
                                <label class="text-muted">Location</label>
                                <h5>{{ $guest->event->location }}</h5>
                            </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Event Status</label>
                            <h5>
                                <span class="badge badge-{{
                                    $guest->event->status === 'published' ? 'success' :
                                    ($guest->event->status === 'cancelled' ? 'danger' :
                                    ($guest->event->status === 'completed' ? 'info' : 'warning'))
                                    }}">
                                    {{ ucfirst($guest->event->status) }}
                                </span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            @if($guest->notes)
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Notes</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $guest->notes }}</p>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Activity Log</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="mdi mdi-clock text-muted mr-2"></i>
                            <strong>Created:</strong> {{ $guest->created_at->format('M d, Y h:i A') }}
                        </li>
                        <li class="list-group-item">
                            <i class="mdi mdi-clock text-muted mr-2"></i>
                            <strong>Last Updated:</strong> {{ $guest->updated_at->format('M d, Y h:i A') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
