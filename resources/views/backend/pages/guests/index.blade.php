@extends('backend.layout.app')
@section('Title', 'Guest List')
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
                <span><i class="mdi mdi-account-multiple"></i></span>
                <span class="ml-1">Guest List</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Guests</a></li>
            </ol>
        </div>
    </div>

    <!-- Filters & Export -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('guests.index') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search name or email..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Event</label>
                                <select name="event_id" class="form-control">
                                    <option value="">All Events</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                            {{ Str::limit($event->title, 25) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined</option>
                                    <option value="attended" {{ request('status') == 'attended' ? 'selected' : '' }}>Attended</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Type</label>
                                <select name="participation_type" class="form-control">
                                    <option value="">All Types</option>
                                    <option value="attendee" {{ request('participation_type') == 'attendee' ? 'selected' : '' }}>Attendee</option>
                                    <option value="speaker" {{ request('participation_type') == 'speaker' ? 'selected' : '' }}>Speaker</option>
                                    <option value="sponsor" {{ request('participation_type') == 'sponsor' ? 'selected' : '' }}>Sponsor</option>
                                    <option value="volunteer" {{ request('participation_type') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                                    <option value="vip" {{ request('participation_type') == 'vip' ? 'selected' : '' }}>VIP</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Checked In</label>
                                <select name="checked_in" class="form-control">
                                    <option value="">All</option>
                                    <option value="1" {{ request('checked_in') == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ request('checked_in') == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-filter"></i> Filter
                                </button>
                                <a href="{{ route('guests.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-refresh"></i> Reset
                                </a>
                                <a href="{{ route('guests.export', request()->all()) }}" class="btn btn-success" target="_blank">
                                    <i class="mdi mdi-download"></i> Export CSV
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary">
                            <i class="mdi mdi-account-multiple"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="mb-0">{{ $totalGuests }}</h4>
                            <p class="mb-0 text-muted">Total Guests</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-success">
                            <i class="mdi mdi-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="mb-0">{{ $confirmedGuests }}</h4>
                            <p class="mb-0 text-muted">Confirmed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-warning">
                            <i class="mdi mdi-clock"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="mb-0">{{ $pendingGuests }}</h4>
                            <p class="mb-0 text-muted">Pending</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-info">
                            <i class="mdi mdi-party-popper"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="mb-0">{{ $attendedGuests }}</h4>
                            <p class="mb-0 text-muted">Attended</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('guests.index') }}" method="GET" class="filter-form">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Filter by Event</label>
                                <select name="event_id" class="form-control">
                                    <option value="">All Events</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                            {{ $event->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined</option>
                                    <option value="attended" {{ request('status') == 'attended' ? 'selected' : '' }}>Attended</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-lg btn-primary btn-block">
                                    <i class="mdi mdi-filter"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('guests.create') }}" class="btn btn-lg btn-success btn-block text-light">
                                    <i class="mdi mdi-plus"></i> Add Guest
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Guests Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('guests.bulk-update') }}" method="POST" id="bulkForm">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)">
                                        </th>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Event</th>
                                        <th>Tickets</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($guests as $guest)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="guest_ids[]" value="{{ $guest->id }}" class="guest-checkbox">
                                            </td>
                                            <td>{{ $guest->id }}</td>
                                            <td><strong>{{ $guest->name }}</strong></td>
                                            <td>{{ $guest->email }}</td>
                                            <td>
                                                <a href="{{ route('events.show', $guest->event) }}" class="text-primary">
                                                    {{ $guest->event->title }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $guest->ticket_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{
                                                    $guest->status === 'confirmed' ? 'success' :
                                                    ($guest->status === 'declined' ? 'danger' :
                                                    ($guest->status === 'attended' ? 'info' : 'warning'))
                                                    }}">
                                                    {{ ucfirst($guest->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('guests.show', $guest) }}" class="btn btn-sm btn-primary text-white">View</a>
                                                <a href="{{ route('guests.edit', $guest) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                                <form action="{{ route('guests.destroy', $guest) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to remove this guest?')) this.closest('form').submit();" class="btn btn-sm btn-danger text-white">Delete</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No guests found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <select name="status" id="bulkStatus" class="form-control d-inline-block" style="width: auto;" required>
                                    <option value="">Change status to...</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="declined">Declined</option>
                                    <option value="attended">Attended</option>
                                    <option value="pending">Pending</option>
                                </select>
                                <button type="submit" class="btn btn-lg btn-warning" onclick="return validateBulkUpdate()">
                                    <i class="mdi mdi-update"></i> Update Selected
                                </button>
                            </div>
                            {{ $guests->withQueryString()->links() }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-box {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 28px;
    color: white;
}
.icon-box.bg-primary { background: linear-gradient(45deg, #7366ff, #5c4dff); }
.icon-box.bg-success { background: linear-gradient(45deg, #11c15b, #0cae52); }
.icon-box.bg-warning { background: linear-gradient(45deg, #f73164, #e12a5a); }
.icon-box.bg-info { background: linear-gradient(45deg, #00bcd4, #00acc1); }
</style>

<script>
function toggleCheckboxes(source) {
    checkboxes = document.querySelectorAll('.guest-checkbox');
    for (checkbox of checkboxes) {
        checkbox.checked = source.checked;
    }
}

function validateBulkUpdate() {
    // check if any guests are selected
    var checkboxes = document.querySelectorAll('.guest-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('Please select at least one guest to update.');
        return false;
    }
    
    // check if status is selected
    var status = document.getElementById('bulkStatus').value;
    if (!status) {
        alert('Please select a status to update to.');
        return false;
    }
    
    return confirm('Update status for ' + checkboxes.length + ' selected guest(s)?');
}
</script>
@endsection
