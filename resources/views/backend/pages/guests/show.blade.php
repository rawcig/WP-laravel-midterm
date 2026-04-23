@extends('backend.layout.app')
@section('Title', 'Guest Details')
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

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Guest Profile Card -->
        <div class="col-lg-4 col-md-5 col-xxl-4 col-xl-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex" style="width: 120px; height: 120px; align-items: center; justify-content: center; font-size: 48px;">
                            {{ strtoupper(substr($guest->name, 0, 1)) }}
                        </div>
                    </div>

                    <h3 class="mb-1">{{ $guest->name }}</h3>
                    <span class="badge badge-{{
                        $guest->status === 'confirmed' ? 'success' :
                        ($guest->status === 'declined' ? 'danger' :
                        ($guest->status === 'attended' ? 'info' : 'warning'))
                    }} mb-3">
                        {{ ucfirst($guest->status) }}
                    </span>

                    @if($guest->participation_type)
                        <p class="text-muted">
                            <i class="mdi mdi-badge-account"></i> {{ ucfirst($guest->participation_type) }}
                        </p>
                    @endif

                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="card-profile border-0 text-center">
                                <span class="mb-1 text-primary"><i class="mdi mdi-ticket"></i></span>
                                <h4 class="mb-0">{{ $guest->ticket_count }}</h4>
                                <p class="text-muted">Tickets</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-profile border-0 text-center">
                                <span class="mb-1 text-info"><i class="mdi mdi-account"></i></span>
                                <h4 class="mb-0">{{ $guest->id }}</h4>
                                <p class="text-muted">Guest ID</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('guests.edit', $guest) }}" class="btn btn-primary btn-block mb-2 text-white">
                        <i class="mdi mdi-pencil"></i> Edit Guest
                    </a>

                    <ul class="card-profile__info text-left">
                        @if($guest->email)
                            <li class="mb-2">
                                <strong><i class="mdi mdi-email mr-2"></i>Email:</strong>
                                <br>
                                <span class="ml-4"><a href="mailto:{{ $guest->email }}">{{ $guest->email }}</a></span>
                            </li>
                        @endif
                        @if($guest->phone)
                            <li class="mb-2">
                                <strong><i class="mdi mdi-phone mr-2"></i>Phone:</strong>
                                <br>
                                <span class="ml-4"><a href="tel:{{ $guest->phone }}">{{ $guest->phone }}</a></span>
                            </li>
                        @endif
                        @if($guest->company)
                            <li class="mb-2">
                                <strong><i class="mdi mdi-office mr-2"></i>Company:</strong>
                                <br>
                                <span class="ml-4">{{ $guest->company }}</span>
                            </li>
                        @endif
                        @if($guest->position)
                            <li class="mb-2">
                                <strong><i class="mdi mdi-account-details mr-2"></i>Position:</strong>
                                <br>
                                <span class="ml-4">{{ $guest->position }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-footer border-0 pb-4">
                    <form action="{{ route('guests.destroy', $guest) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this guest\'s ticket?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="mdi mdi-delete"></i> Delete Guest
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Guest Details -->
        <div class="col-lg-8 col-md-7 col-xxl-8 col-xl-9">
            <!-- Event Information -->
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

            <!-- Additional Information -->
            @if($guest->dietary_requirements || $guest->notes)
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Additional Information</h4>
                    </div>
                    <div class="card-body">
                        @if($guest->dietary_requirements)
                            <div class="mb-3">
                                <label class="text-muted"><i class="mdi mdi-food"></i> Dietary Requirements:</label>
                                <p class="mb-0">{{ $guest->dietary_requirements }}</p>
                            </div>
                        @endif
                        @if($guest->notes)
                            <div>
                                <label class="text-muted"><i class="mdi mdi-note"></i> Notes:</label>
                                <p class="mb-0">{{ $guest->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Activity Log -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Registration Activity</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="mdi mdi-clock text-muted mr-2"></i>
                            <strong>Registered:</strong> {{ $guest->created_at->format('M d, Y h:i A') }}
                        </li>
                        <li class="list-group-item">
                            <i class="mdi mdi-clock text-muted mr-2"></i>
                            <strong>Last Updated:</strong> {{ $guest->updated_at->format('M d, Y h:i A') }}
                        </li>
                        @if($guest->checked_in)
                            <li class="list-group-item">
                                <i class="mdi mdi-check-circle text-success mr-2"></i>
                                <strong>Checked In:</strong> {{ $guest->checked_in_at->format('M d, Y h:i A') }}
                            </li>
                        @else
                            <li class="list-group-item">
                                <i class="mdi mdi-alert-circle text-warning mr-2"></i>
                                <strong>Check-in Status:</strong> Not checked in yet
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
