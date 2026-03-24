@extends('backend.layout.app')
@section('Title', 'My Registered Events')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-ticket"></i></span>
                <span class="ml-1">My Registered Events</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">My Events</a></li>
            </ol>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Participation Type</th>
                                    <th>Tickets</th>
                                    <th>Status</th>
                                    <th>Checked In</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($guests as $guest)
                                    <tr>
                                        <td>
                                            <strong>{{ $guest->event->title }}</strong>
                                        </td>
                                        <td>{{ $guest->event->date->format('M d, Y') }}</td>
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
                                                <span class="badge badge-success"><i class="mdi mdi-check"></i> Yes</span>
                                            @else
                                                <span class="badge badge-secondary"><i class="mdi mdi-close"></i> No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('events.show.public', $guest->event) }}" class="btn btn-sm btn-primary text-white">
                                                 View Event
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            You haven't registered for any events yet.
                                            <a href="{{ route('events.public') }}" class="text-primary">Browse Events</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $guests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
