@extends('backend.layout.app')
@section('Title', 'Event Check-in - ' . $event->title)
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-check-circle"></i></span>
                <span class="ml-1">Event Check-in</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Check-in</a></li>
            </ol>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Event Info Card -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title mb-3">{{ $event->title }}</h4>
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1">
                        <i class="mdi mdi-calendar text-primary"></i>
                        <strong>Date:</strong> {{ $event->date->format('l, F d, Y h:i A') }}
                    </p>
                    <p class="mb-0">
                        <i class="mdi mdi-map-marker text-danger"></i>
                        <strong>Location:</strong> {{ $event->location ?? 'TBA' }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1">
                        <i class="mdi mdi-account text-success"></i>
                        <strong>Organizer:</strong> {{ $event->organizer ? $event->organizer->name : 'TBA' }}
                    </p>
                    <p class="mb-0">
                        <i class="mdi mdi-information text-info"></i>
                        <strong>Status:</strong>
                        <span class="badge badge-{{
                            $event->status === 'published' ? 'success' :
                            ($event->status === 'cancelled' ? 'danger' :
                            ($event->status === 'completed' ? 'info' : 'warning'))
                        }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="mdi mdi-account-multiple" style="font-size: 40px;"></i>
                    <h3 class="mt-2 mb-0" style="color: white !important;">{{ $stats['total'] }}</h3>
                    <p class="mb-0">Total Registered</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="mdi mdi-check-circle" style="font-size: 40px;"></i>
                    <h3 class="mt-2 mb-0" style="color: white !important;">{{ $stats['confirmed'] }}</h3>
                    <p class="mb-0">Confirmed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="mdi mdi-account-check" style="font-size: 40px;"></i>
                    <h3 class="mt-2 mb-0" style="color: white !important;">{{ $stats['checked_in'] }}</h3>
                    <p class="mb-0">Checked In</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="mdi mdi-clock" style="font-size: 40px;"></i>
                    <h3 class="mt-2 mb-0" style="color: white !important;">{{ $stats['not_checked_in'] }}</h3>
                    <p class="mb-0">Not Checked In</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Guest List -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Guest List</h5>
            <a href="{{ route('events.index') }}" class="btn btn-secondary btn-sm">
                <i class="mdi mdi-arrow-left"></i> Back to Events
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Tickets</th>
                            <th>Status</th>
                            <th>Check-in</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guests as $guest)
                            <tr>
                                <td>{{ $guest->id }}</td>
                                <td>
                                    <strong>{{ $guest->name }}</strong>
                                    @if($guest->user)
                                        <br><small class="text-muted">User #{{ $guest->user_id }}</small>
                                    @endif
                                </td>
                                <td>{{ $guest->email }}</td>
                                <td>{{ $guest->phone ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{
                                        $guest->participation_type === 'vip' ? 'danger' :
                                        ($guest->participation_type === 'speaker' ? 'primary' :
                                        ($guest->participation_type === 'sponsor' ? 'success' :
                                        ($guest->participation_type === 'volunteer' ? 'info' : 'secondary')))
                                    }}">
                                        {{ ucfirst($guest->participation_type) }}
                                    </span>
                                </td>
                                <td>{{ $guest->ticket_count }}</td>
                                <td>
                                    <span class="badge badge-{{
                                        $guest->registration_status === 'confirmed' ? 'success' :
                                        ($guest->registration_status === 'cancelled' ? 'danger' :
                                        ($guest->registration_status === 'attended' ? 'info' : 'warning'))
                                    }}">
                                        {{ ucfirst($guest->registration_status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($guest->checked_in)
                                        <span class="badge badge-success">
                                            <i class="mdi mdi-check"></i> 
                                            Checked In
                                            <br><small>{{ $guest->checked_in_at->format('h:i A') }}</small>
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="mdi mdi-clock"></i> Not Checked In
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($guest->checked_in)
                                        <form action="{{ route('guests.check-out', $guest) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning text-white">
                                                <i class="mdi mdi-logout"></i> Check Out
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('guests.check-in', $guest) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="mdi mdi-check"></i> Check In
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('guests.show', $guest) }}" class="btn btn-sm btn-info text-white">
                                        <i class="mdi mdi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    No guests registered for this event yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
