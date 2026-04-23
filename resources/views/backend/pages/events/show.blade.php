@extends('backend.layout.app')
@section('Title','Event Details')
@section('content')

<style>
    .border-left-primary { border-left: 4px solid #007bff !important; }
    .border-left-success { border-left: 4px solid #28a745 !important; }
    .border-left-warning { border-left: 4px solid #ffc107 !important; }
    .border-left-danger { border-left: 4px solid #dc3545 !important; }
    .border-left-info { border-left: 4px solid #17a2b8 !important; }
    
    .badge-lg { padding: 6px 12px; font-size: 14px; }
    
    .btn-group > .btn {
        flex: 1;
    }
</style>

{{-- Content body start --}}
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="icon-calender"></i></span>
                <span class="ml-1">Event Details</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ Str::limit($event->title, 20) }}</a></li>
            </ol>
        </div>
    </div>

    <!-- Event Preview Alert -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="mdi mdi-eye"></i>
                <strong>Event Preview:</strong> This is how the event will appear to public visitors.
                <a href="{{ route('events.show.public', $event) }}" target="_blank" class="alert-link">
                    View Public Page <i class="mdi mdi-open-in-new"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- row -->
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Event Description -->
            <div class="card mb-4">
                <div class="event-image-container" data-image="{{ $event->cover_image ? asset('storage/' . $event->cover_image) : asset('images/placeholder-event.svg') }}">
                    <img class="card-img-top img-fluid" src="{{ $event->cover_image ? asset('storage/' . $event->cover_image) : asset('images/placeholder-event.svg') }}"
                         alt="{{ $event->title }}" style="max-height: 400px; object-fit: contain; width: 100%; position: relative; z-index: 1;">
                </div>
                <div class="card-header text-white">
                    <h4 class="mb-0">{{ $event->title }}</h4>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">About This Event</h5>
                    <p>{{ $event->description }}</p>

                    <!-- Event Detail Image -->
                    @if($event->detail_image)
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $event->detail_image) }}"
                                 class="img-fluid rounded" alt="Event Detail"
                                 style="max-height: 500px; width: auto;">
                        </div>
                    @endif

                    <hr>

                    <!-- Event Details -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-calendar text-primary" style="font-size: 24px;"></i>
                                <div class="ml-3">
                                    <strong>Date & Time</strong>
                                    <p class="mb-0">{{ $event->date->format('l, F d, Y') }}</p>
                                    <small class="text-muted">{{ $event->date->format('h:i A') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-map-marker text-danger" style="font-size: 24px;"></i>
                                <div class="ml-3">
                                    <strong>Location</strong>
                                    <p class="mb-0">{{ $event->location ?? 'TBA' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-account text-success" style="font-size: 24px;"></i>
                                <div class="ml-3">
                                    <strong>Organizer</strong>
                                    <p class="mb-0">
                                        @if($event->organizer)
                                            {{ $event->organizer->name }}
                                        @else
                                            TBA
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-information text-info" style="font-size: 24px;"></i>
                                <div class="ml-3">
                                    <strong>Status</strong>
                                    <p class="mb-0">
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
                </div>
            </div>

            <!-- Admin Statistics Dashboard -->
            @if(auth()->user() && (auth()->user()->is_admin || auth()->user()->is_organizer))
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="mdi mdi-chart-box-outline"></i> Event Analytics
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Statistics Grid -->
                        <div class="row">
                            <div class="col-sm-6 col-md-3 mb-4">
                                <div class="card bg-light border-left-primary">
                                    <div class="card-body py-3">
                                        <div class="text-primary font-weight-bold text-uppercase mb-1">
                                            <i class="mdi mdi-account-multiple"></i> Total Guests
                                        </div>
                                        <div class="h3 mb-0">{{ $statistics['total_registered'] ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3 mb-4">
                                <div class="card bg-light border-left-success">
                                    <div class="card-body py-3">
                                        <div class="text-success font-weight-bold text-uppercase mb-1">
                                            <i class="mdi mdi-check-circle"></i> Confirmed
                                        </div>
                                        <div class="h3 mb-0">{{ $statistics['confirmed'] ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3 mb-4">
                                <div class="card bg-light border-left-warning">
                                    <div class="card-body py-3">
                                        <div class="text-warning font-weight-bold text-uppercase mb-1">
                                            <i class="mdi mdi-clock-outline"></i> Pending
                                        </div>
                                        <div class="h3 mb-0">{{ $statistics['pending'] ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3 mb-4">
                                <div class="card bg-light border-left-danger">
                                    <div class="card-body py-3">
                                        <div class="text-danger font-weight-bold text-uppercase mb-1">
                                            <i class="mdi mdi-cancel"></i> Cancelled
                                        </div>
                                        <div class="h3 mb-0">{{ $statistics['cancelled'] ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Attendance & Occupancy -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6 class="mb-3">
                                    <i class="mdi mdi-account-check"></i> Check-in Status
                                </h6>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Checked In</span>
                                        <strong>{{ $statistics['checked_in'] ?? 0 }}</strong>
                                    </div>
                                    <div class="progress" style="height: 20px;">
                                        @php
                                            $checkedInPercentage = $statistics['total_registered'] > 0 
                                                ? (($statistics['checked_in'] / $statistics['total_registered']) * 100) 
                                                : 0;
                                        @endphp
                                        <div class="progress-bar bg-success" 
                                             role="progressbar" 
                                             style="width: {{ $checkedInPercentage }}%">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Not Checked In</span>
                                        <strong>{{ $statistics['not_checked_in'] ?? 0 }}</strong>
                                    </div>
                                    <div class="progress" style="height: 20px;">
                                        @php
                                            $notCheckedInPercentage = 100 - $checkedInPercentage;
                                        @endphp
                                        <div class="progress-bar bg-warning" 
                                             role="progressbar" 
                                             style="width: {{ $notCheckedInPercentage }}%">
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info mt-3" style="padding: 10px;">
                                    <strong>Attendance Rate: {{ $statistics['attendance_rate'] ?? 0 }}%</strong>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="mb-3">
                                    <i class="mdi mdi-seat"></i> Seat Occupancy
                                </h6>
                                @if($event->max_attendees)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Capacity Used</span>
                                            <strong>{{ $statistics['occupancy_percentage'] ?? 0 }}%</strong>
                                        </div>
                                        <div class="progress" style="height: 20px;">
                                            @php
                                                $occupancy = $statistics['occupancy_percentage'] ?? 0;
                                                $occupancyColor = $occupancy >= 90 ? 'danger' : ($occupancy >= 70 ? 'warning' : 'success');
                                            @endphp
                                            <div class="progress-bar bg-{{ $occupancyColor }}" 
                                                 role="progressbar" 
                                                 style="width: {{ min(100, $occupancy) }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            {{ $event->ticket_count }} / {{ $event->max_attendees }} tickets taken
                                        </small>
                                    </div>
                                    
                                    @if($event->available_seats !== 'Unlimited')
                                        <div class="alert alert-success mt-3" style="padding: 10px;">
                                            <strong>{{ $event->available_seats }} seats still available</strong>
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-info" style="padding: 10px;">
                                        <i class="mdi mdi-infinity"></i> <strong>Unlimited Capacity</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <!-- Participation Types -->
                        @if($statistics['participation_breakdown'] && $statistics['participation_breakdown']->count() > 0)
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h6 class="mb-3">
                                        <i class="mdi mdi-tag-multiple"></i> Participation Breakdown
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <tbody>
                                                @foreach($statistics['participation_breakdown'] as $type => $breakdown)
                                                    <tr>
                                                        <td width="50%">
                                                            <i class="mdi mdi-tag"></i> {{ ucfirst($type) }}
                                                        </td>
                                                        <td class="text-right">
                                                            <span class="badge badge-primary badge-lg">{{ $breakdown->count }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <hr>

                        <!-- Quick Actions -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3">
                                    <i class="mdi mdi-lightning-bolt"></i> Quick Actions
                                </h6>
                                <div class="btn-group btn-block" role="group">
                                    <a href="{{ route('guests.create', ['event_id' => $event->id]) }}" class="btn btn-outline-success">
                                        <i class="mdi mdi-account-plus"></i> Register Guest
                                    </a>
                                    <a href="{{ route('guests.index', ['event_id' => $event->id]) }}" class="btn btn-outline-primary">
                                        <i class="mdi mdi-account-multiple"></i> Guest List
                                    </a>
                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-secondary">
                                        <i class="mdi mdi-pencil"></i> Edit Event
                                    </a>
                                    <a href="#" class="btn btn-outline-info" onclick="alert('Export feature coming soon!')">
                                        <i class="mdi mdi-download"></i> Export
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Guest Details Section -->
            @if(auth()->user() && (auth()->user()->is_admin || auth()->user()->is_organizer))
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">
                            <i class="mdi mdi-account-group"></i> Guest Details & Attendance
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Guest Statistics Summary -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-primary">{{ $allGuests->total() }}</h5>
                                    <small class="text-muted">Total Guests</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-success">{{ $checkedInGuests->total() }}</h5>
                                    <small class="text-muted">Checked In</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-warning">{{ $notCheckedInGuests->total() }}</h5>
                                    <small class="text-muted">Not Checked In</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-danger">{{ $cancelledGuests->total() }}</h5>
                                    <small class="text-muted">Cancelled</small>
                                </div>
                            </div>
                        </div>

                        <!-- Guest Tabs -->
                        <ul class="nav nav-tabs" id="guestTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all-guests" role="tab">
                                    <i class="mdi mdi-account-multiple"></i> All Guests ({{ $allGuests->total() }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="checked-in-tab" data-toggle="tab" href="#checked-in" role="tab">
                                    <i class="mdi mdi-check-circle"></i> Checked In ({{ $checkedInGuests->total() }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="not-checked-in-tab" data-toggle="tab" href="#not-checked-in" role="tab">
                                    <i class="mdi mdi-clock-outline"></i> Not Checked In ({{ $notCheckedInGuests->total() }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tab">
                                    <i class="mdi mdi-cancel"></i> Cancelled ({{ $cancelledGuests->total() }})
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3" id="guestTabsContent">
                            <!-- All Guests Tab -->
                            <div class="tab-pane fade show active" id="all-guests" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Check-in</th>
                                                <th>Registered</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($allGuests as $guest)
                                                <tr>
                                                    <td>{{ $guest->name }}</td>
                                                    <td>{{ $guest->email }}</td>
                                                    <td>{{ $guest->phone ?? '-' }}</td>
                                                    <td>
                                                        <span class="badge badge-{{
                                                            $guest->status === 'confirmed' ? 'success' :
                                                            ($guest->status === 'pending' ? 'warning' : 'danger')
                                                        }}">
                                                            {{ ucfirst($guest->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($guest->checked_in)
                                                            <span class="badge badge-success">
                                                                <i class="mdi mdi-check"></i> Yes
                                                            </span>
                                                        @else
                                                            <span class="badge badge-secondary">
                                                                <i class="mdi mdi-close"></i> No
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $guest->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            @if($guest->status === 'pending')
                                                                <form action="{{ route('guests.confirm', $guest) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-success btn-sm" title="Confirm Registration">
                                                                        <i class="mdi mdi-check"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            @if(!$guest->checked_in)
                                                                <form action="{{ route('guests.checkin', $guest) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary btn-sm" title="Mark as Checked In">
                                                                        <i class="mdi mdi-login"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('guests.edit', $guest) }}" class="btn btn-warning btn-sm" title="Edit Guest">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted">No guests registered yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{ $allGuests->appends(request()->query())->links() }}
                            </div>

                            <!-- Checked In Tab -->
                            <div class="tab-pane fade" id="checked-in" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Check-in Time</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($checkedInGuests as $guest)
                                                <tr>
                                                    <td>{{ $guest->name }}</td>
                                                    <td>{{ $guest->email }}</td>
                                                    <td>{{ $guest->phone ?? '-' }}</td>
                                                    <td>{{ $guest->updated_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <a href="{{ route('guests.edit', $guest) }}" class="btn btn-warning btn-sm">
                                                            <i class="mdi mdi-pencil"></i> Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No guests checked in yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{ $checkedInGuests->appends(request()->query())->links() }}
                            </div>

                            <!-- Not Checked In Tab -->
                            <div class="tab-pane fade" id="not-checked-in" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Registered</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($notCheckedInGuests as $guest)
                                                <tr>
                                                    <td>{{ $guest->name }}</td>
                                                    <td>{{ $guest->email }}</td>
                                                    <td>{{ $guest->phone ?? '-' }}</td>
                                                    <td>
                                                        <span class="badge badge-{{
                                                            $guest->status === 'confirmed' ? 'success' :
                                                            ($guest->status === 'pending' ? 'warning' : 'danger')
                                                        }}">
                                                            {{ ucfirst($guest->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $guest->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            @if($guest->status === 'pending')
                                                                <form action="{{ route('guests.confirm', $guest) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-success btn-sm" title="Confirm Registration">
                                                                        <i class="mdi mdi-check"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <form action="{{ route('guests.checkin', $guest) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary btn-sm" title="Mark as Checked In">
                                                                    <i class="mdi mdi-login"></i>
                                                                </button>
                                                            </form>
                                                            <a href="{{ route('guests.edit', $guest) }}" class="btn btn-warning btn-sm" title="Edit Guest">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">All guests have checked in!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{ $notCheckedInGuests->appends(request()->query())->links() }}
                            </div>

                            <!-- Cancelled Tab -->
                            <div class="tab-pane fade" id="cancelled" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Cancelled Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($cancelledGuests as $guest)
                                                <tr>
                                                    <td>{{ $guest->name }}</td>
                                                    <td>{{ $guest->email }}</td>
                                                    <td>{{ $guest->phone ?? '-' }}</td>
                                                    <td>{{ $guest->updated_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <a href="{{ route('guests.edit', $guest) }}" class="btn btn-warning btn-sm">
                                                            <i class="mdi mdi-pencil"></i> Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No cancelled registrations.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{ $cancelledGuests->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Related Events -->
            @if(isset($relatedEvents) && $relatedEvents->count() > 0)
                <div class="card">
                    <div class="card-header text-white">
                        <h4 class="mb-0">Related Events</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($relatedEvents as $relatedEvent)
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="event-image-container-small" data-image="{{ $relatedEvent->cover_image ? asset('storage/' . $relatedEvent->cover_image) : asset('images/placeholder-event.svg') }}">
                                    <img class="card-img-top img-fluid" src="{{ $relatedEvent->cover_image ? asset('storage/' . $relatedEvent->cover_image) : asset('images/placeholder-event.svg') }}"
                                         alt="{{ $relatedEvent->title }}" style="height: 150px; object-fit: contain; width: 100%; position: relative; z-index: 1;">
                                </div>
                                        <div class="card-body p-3">
                                            <h6 class="card-title">
                                                <a href="{{ route('events.show', $relatedEvent) }}">
                                                    {{ Str::limit($relatedEvent->title, 50) }}
                                                </a>
                                            </h6>
                                            <p class="text-muted small mb-2">
                                                <i class="mdi mdi-calendar"></i>
                                                {{ $relatedEvent->date->format('M d, Y') }}
                                            </p>
                                            <p class="text-muted small mb-2">
                                                <i class="mdi mdi-map-marker"></i>
                                                {{ $relatedEvent->location ?? 'TBA' }}
                                            </p>
                                            @php
                                                $relatedRegistration = auth()->check() ? $relatedEvent->getUserRegistration() : null;
                                            @endphp
                                            @if($relatedRegistration)
                                                <span class="badge badge-success">
                                                    <i class="mdi mdi-check-circle"></i> Registered
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Registration Card -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h5 class="mb-0">Event Registration</h5>
                </div>
                <div class="card-body">
                    <!-- Seat Availability -->
                    <div class="mb-4">
                        @if(is_null($event->max_attendees))
                            <div class="alert alert-info mb-2">
                                <i class="mdi mdi-infinity"></i> <strong>Unlimited Seats Available</strong>
                            </div>
                        @elseif($event->is_full)
                            <div class="alert alert-danger mb-2">
                                <i class="mdi mdi-close-circle"></i> <strong>Sold Out!</strong>
                            </div>
                        @else
                            <div class="alert alert-success mb-2">
                                <i class="mdi mdi-check-circle"></i>
                                <strong>{{ $event->available_seats }} seats available</strong>
                            </div>
                        @endif

                        @if($event->max_attendees)
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Occupancy</small>
                                    <small>{{ number_format(($event->ticket_count / $event->max_attendees) * 100, 0) }}% full</small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    @php
                                        $percentage = min(100, ($event->ticket_count / $event->max_attendees) * 100);
                                    @endphp
                                    <div class="progress-bar bg-{{ $event->is_full ? 'danger' : ($percentage > 80 ? 'warning' : 'success') }}"
                                         role="progressbar"
                                         style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                                <small class="text-muted">
                                    {{ $event->ticket_count }} of {{ $event->max_attendees }} tickets taken
                                </small>
                            </div>
                        @endif
                    </div>

                    <!-- Attendance Statistics -->
                    <div class="mb-4">
                        <h6 class="mb-3">Attendance Statistics</h6>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <div class="text-center p-2 bg-light rounded">
                                    <i class="mdi mdi-account-multiple text-primary" style="font-size: 24px;"></i>
                                    <h4 class="mb-0 mt-1">{{ $event->registered_count }}</h4>
                                    <small class="text-muted">Registered</small>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="text-center p-2 bg-light rounded">
                                    <i class="mdi mdi-ticket text-success" style="font-size: 24px;"></i>
                                    <h4 class="mb-0 mt-1">{{ $event->ticket_count }}</h4>
                                    <small class="text-muted">Tickets</small>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="text-center p-2 bg-light rounded">
                                    <i class="mdi mdi-check-circle text-info" style="font-size: 24px;"></i>
                                    <h4 class="mb-0 mt-1">{{ $event->confirmed_count }}</h4>
                                    <small class="text-muted">Confirmed</small>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="text-center p-2 bg-light rounded">
                                    <i class="mdi mdi-clipboard-check text-warning" style="font-size: 24px;"></i>
                                    <h4 class="mb-0 mt-1">{{ $event->checked_in_count }}</h4>
                                    <small class="text-muted">Checked In</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Statistics Panel -->
                    @if(auth()->user() && (auth()->user()->is_admin || auth()->user()->is_organizer))
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h6 class="mb-3">
                                <i class="mdi mdi-chart-line"></i> Admin Statistics
                            </h6>
                            
                            <!-- Status Breakdown -->
                            <div class="row mb-3">
                                <div class="col-6 mb-2">
                                    <div class="text-center p-2 bg-white rounded border">
                                        <i class="mdi mdi-clock-outline text-warning" style="font-size: 20px;"></i>
                                        <h5 class="mb-0 mt-1">{{ $statistics['pending'] ?? 0 }}</h5>
                                        <small class="text-muted">Pending</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="text-center p-2 bg-white rounded border">
                                        <i class="mdi mdi-cancel text-danger" style="font-size: 20px;"></i>
                                        <h5 class="mb-0 mt-1">{{ $statistics['cancelled'] ?? 0 }}</h5>
                                        <small class="text-muted">Cancelled</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Attendance Rate -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong>Attendance Rate</strong>
                                    <strong>{{ $statistics['attendance_rate'] ?? 0 }}%</strong>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    @php
                                        $attendanceRate = $statistics['attendance_rate'] ?? 0;
                                        $bgColor = $attendanceRate >= 80 ? 'success' : ($attendanceRate >= 50 ? 'info' : 'warning');
                                    @endphp
                                    <div class="progress-bar bg-{{ $bgColor }}"
                                         role="progressbar"
                                         style="width: {{ $attendanceRate }}%">
                                    </div>
                                </div>
                            </div>

                            <!-- Not Checked In -->
                            @if($statistics['not_checked_in'] > 0)
                                <div class="alert alert-info mb-2" style="padding: 8px; margin: 0;">
                                    <small>
                                        <i class="mdi mdi-information-outline"></i>
                                        <strong>{{ $statistics['not_checked_in'] }}</strong> guest(s) not checked in yet
                                    </small>
                                </div>
                            @endif

                            <!-- Participation Breakdown -->
                            @if($statistics['participation_breakdown'] && $statistics['participation_breakdown']->count() > 0)
                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted d-block mb-2"><strong>Participation Types</strong></small>
                                    @foreach($statistics['participation_breakdown'] as $type => $breakdown)
                                        <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                                            <span>
                                                <i class="mdi mdi-tag"></i>
                                                {{ ucfirst($type) }}
                                            </span>
                                            <span class="badge badge-primary">{{ $breakdown->count }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Event Actions -->
                            <div class="mt-3 pt-3 border-top">
                                <a href="{{ route('guests.index', ['event_id' => $event->id]) }}" class="btn btn-sm btn-outline-primary btn-block">
                                    <i class="mdi mdi-account-multiple"></i> View Guest List
                                </a>
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-outline-secondary btn-block mt-2">
                                    <i class="mdi mdi-pencil"></i> Edit Event
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Registration Button -->
                    @php
                        $userRegistration = auth()->check() ? $event->getUserRegistration() : null;
                    @endphp

                    @if($userRegistration)
                        <a href="{{ route('my-events') }}" class="btn btn-success btn-block btn-lg text-white">
                            <i class="mdi mdi-ticket"></i> View My Ticket
                        </a>
                        <p class="text-center text-muted mt-2">
                            <small>You're registered for this event!</small>
                        </p>
                    @elseif(auth()->check() && !$event->is_full)
                        <a href="{{ route('events.register', $event) }}" class="btn btn-primary btn-block btn-lg text-white">
                            <i class="mdi mdi-account-plus"></i> Register Now
                        </a>
                    @elseif($event->is_full)
                        <button class="btn btn-secondary btn-block btn-lg" disabled>
                            <i class="mdi mdi-close-circle"></i> Event Full
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-info btn-block btn-lg text-white">
                            <i class="mdi mdi-login"></i> Login to Register
                        </a>
                    @endif
                </div>
            </div>

            <!-- Organizer Info -->
            @if($event->organizer)
                <div class="card">
                    <div class="event-image-container-org" data-image="{{ $event->organizer->logo ? asset('storage/' . $event->organizer->logo) : asset('images/placeholder-organizer.svg') }}">
                        <img class="card-img-top img-fluid" src="{{ $event->organizer->logo ? asset('storage/' . $event->organizer->logo) : asset('images/placeholder-organizer.svg') }}"
                             alt="{{ $event->organizer->name }}" style="height: 150px; object-fit: contain; width: 100%; position: relative; z-index: 1;">
                    </div>
                    <div class="card-header text-white">
                        <h5 class="mb-0">Organizer</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                 style="width: 50px; height: 50px; font-size: 20px;">
                                {{ strtoupper(substr($event->organizer->name, 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <h6 class="mb-0">{{ $event->organizer->name }}</h6>
                                @if($event->organizer->email)
                                    <small class="text-muted">{{ $event->organizer->email }}</small>
                                @endif
                            </div>
                        </div>
                        @if($event->organizer->phone || $event->organizer->website)
                            <hr>
                            @if($event->organizer->phone)
                                <p class="mb-2">
                                    <i class="mdi mdi-phone"></i>
                                    {{ $event->organizer->phone }}
                                </p>
                            @endif
                            @if($event->organizer->website)
                                <p class="mb-0">
                                    <i class="mdi mdi-web"></i>
                                    <a href="{{ $event->organizer->website }}" target="_blank">Visit Website</a>
                                </p>
                            @endif
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Admin Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Admin Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2 ">
                            <a href="{{ route('events.index') }}" class="btn btn-secondary btn-block text-white">
                                <i class="mdi mdi-arrow-left"></i> Back to Events
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-primary btn-block text-white">
                                <i class="mdi mdi-pencil"></i> Edit Event
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('events.show.public', $event) }}" target="_blank" class="btn btn-info btn-block text-white">
                                <i class="mdi mdi-eye"></i> View Public Page
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="mdi mdi-delete"></i> Delete Event
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: none;
    border-radius: 10px;
    overflow: hidden;
}

.card:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    transition: box-shadow 0.3s ease;
}

.card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.card-header {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.event-image-container,
.event-image-container-small,
.event-image-container-org {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background-color: #e4e4e4;
    background-image: var(--bg-image);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.event-image-container {
    height: 400px;
}

.event-image-container-small {
    height: 150px;
}

.event-image-container-org {
    height: 150px;
}

.event-image-container::before,
.event-image-container-small::before,
.event-image-container-org::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: var(--bg-image);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    filter: blur(18px);
    transform: scale(1.08);
    z-index: 0;
}

.event-image-container > img,
.event-image-container-small > img,
.event-image-container-org > img {
    position: relative;
    z-index: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-image]').forEach(container => {
        const imageUrl = container.getAttribute('data-image');
        container.style.setProperty('--bg-image', `url('${imageUrl}')`);
        container.style.backgroundImage = `var(--bg-image)`;
    });
});
</script>
@endsection