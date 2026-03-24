@extends('backend.layout.app')
@section('Title', 'User Management')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-account-multiple"></i></span>
                <span class="ml-1">User Management</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
            </ol>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
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
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Phone</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                            @if($user->id === auth()->id())
                                                <span class="badge badge-info ml-1">You</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge badge-{{
                                                $user->role === 'admin' ? 'danger' :
                                                ($user->role === 'organizer' ? 'primary' : 'secondary')
                                                }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>{{ $user->phone ?? 'N/A' }}</td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-primary text-white">View</a>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger text-white">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
