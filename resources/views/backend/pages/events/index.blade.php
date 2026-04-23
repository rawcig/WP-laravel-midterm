@extends('backend.layout.app')
@section('Title', 'Events List')
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
{{-- Content body start --}}
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="icon-calender"></i></span>
                <span class="ml-1">Events</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Events</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
               
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Filters -->
                    <form action="{{ route('events.index') }}" method="GET" class="mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Search</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search events..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="mdi mdi-filter"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-3">
                                @if($events->count() > 0)
                                    <button type="button" class="btn btn-danger btn-block" 
                                            onclick="confirmBulkDelete()">
                                        <i class="mdi mdi-delete"></i> Delete Selected
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)">
                                    </th>
                                    <th>#</th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('sort') == 'title' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none">
                                            Title 
                                            @if(request('sort') == 'title')
                                                <i class="mdi mdi-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>Organizer</th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'date', 'direction' => request('sort') == 'date' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none">
                                            Date 
                                            @if(request('sort') == 'date')
                                                <i class="mdi mdi-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>Location</th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none">
                                            Status 
                                            @if(request('sort') == 'status')
                                                <i class="mdi mdi-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events as $event)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="event_ids[]" value="{{ $event->id }}" class="event-checkbox">
                                        </td>
                                        <th>{{ $event->id }}</th>
                                        <td>{{ $event->title }}</td>
                                        <td>
                                            @if($event->organizer)
                                                <a href="{{ route('organizer.show', $event->organizer) }}">{{ $event->organizer->name }}</a>
                                            @else
                                                {{ $event->organizer ?? 'N/A' }}
                                            @endif
                                        </td>
                                        <td>{{ $event->date->format('M d, Y h:i A') }}</td>
                                        <td>{{ $event->location ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{
                                                $event->status === 'published' ? 'success' :
                                                ($event->status === 'cancelled' ? 'danger' :
                                                ($event->status === 'completed' ? 'info' : 'warning'))
                                                }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-primary text-white">View</a>
                                            @can('update', $event)
                                                <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                            @endcan
                                            @can('viewGuests', $event)
                                                <a href="{{ route('events.guests', $event) }}" class="btn btn-sm btn-success text-white">
                                                    <i class="mdi mdi-check-circle"></i> Check-in
                                                </a>
                                            @endcan
                                            @can('delete', $event)
                                                <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this event?')) this.closest('form').submit();" class="btn btn-sm btn-danger text-white">Delete</a>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No events available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Delete Form -->
<form id="bulkDeleteForm" action="{{ route('events.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="event_ids" id="bulkEventIds">
</form>

<script>
function toggleCheckboxes(source) {
    checkboxes = document.querySelectorAll('.event-checkbox');
    for (checkbox of checkboxes) {
        checkbox.checked = source.checked;
    }
}

function confirmBulkDelete() {
    checkboxes = document.querySelectorAll('.event-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('Please select at least one event to delete.');
        return;
    }
    
    if (confirm('Are you sure you want to delete ' + checkboxes.length + ' selected event(s)? This action cannot be undone.')) {
        // Collect selected IDs
        eventIds = [];
        for (checkbox of checkboxes) {
            eventIds.push(checkbox.value);
        }
        
        // Set hidden input and submit
        document.getElementById('bulkEventIds').value = eventIds.join(',');
        document.getElementById('bulkDeleteForm').submit();
    }
}
</script>
@endsection