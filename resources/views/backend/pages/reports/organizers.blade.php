@extends('backend.layout.app')
@section('Title', 'Organizers Report')
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
                <span><i class="mdi mdi-account-multiple"></i></span>
                <span class="ml-1">Organizers Report</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Organizers</a></li>
            </ol>
        </div>
    </div>

    <!-- Organizers Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Website</th>
                                    <th>Events Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($organizers as $organizer)
                                    <tr>
                                        <td>{{ $organizer->id }}</td>
                                        <td><strong>{{ $organizer->name }}</strong></td>
                                        <td>{{ $organizer->email }}</td>
                                        <td>{{ $organizer->phone }}</td>
                                        <td>
                                            @if($organizer->website)
                                                <a href="{{ $organizer->website }}" target="_blank" class="text-primary">
                                                    <i class="mdi mdi-web"></i> Visit
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $organizer->events_count }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('organizer.show', $organizer) }}" class="btn btn-sm btn-primary text-white">View Profile</a>
                                            <a href="{{ route('organizer.edit', $organizer) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No organizers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $organizers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
