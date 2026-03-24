@extends('backend.layout.app')
@section('Title', 'Organizer List')
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
                <span class="ml-1">Organizers</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Organizers</a></li>
            </ol>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm">
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
                                        <th>{{ $organizer->id }}</th>
                                        <td>{{ $organizer->name }}</td>
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
                                            <span class="badge badge-primary">{{ $organizer->events->count() }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('organizer.show', $organizer) }}" class="btn btn-sm btn-primary text-light">View</a>
                                            <a href="{{ route('organizer.edit', $organizer) }}" class="btn btn-sm btn-info text-light">Edit</a>
                                            <form action="{{ route('organizer.destroy', $organizer) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this organizer?')) this.closest('form').submit();" class="btn btn-sm btn-danger text-light">Delete</a>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No organizers available.</td>
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
