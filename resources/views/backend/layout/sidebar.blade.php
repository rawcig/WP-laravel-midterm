<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Navigation</li>
            
            @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isOrganizer()))
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-home"></i><span class="nav-text">Dashboard</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('home') }}">Analytics</a></li>
                    </ul>
                </li>
            @endif

            @if(Auth::check() && Auth::user()->isAdmin())
                <!-- Admin Menu -->
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="nav-text">Admin</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('users.index') }}">Manage Users</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-eventbrite"></i><span class="nav-text">Event</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('create-event') }}">Create Event</a></li>
                        <li><a href="{{ route('events.index') }}">Event List</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account"></i><span class="nav-text">Organizer</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('organizer.index') }}">Organizer List</a></li>
                        <li><a href="{{ route('organizer.create') }}">Add Organizer</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="nav-text">Guests</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('guests.index') }}">Guest List</a></li>
                        <li><a href="{{ route('guests.create') }}">Register Guest</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="nav-text">Reports</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('reports.index') }}">Dashboard</a></li>
                        <li><a href="{{ route('reports.events') }}">Events Report</a></li>
                        <li><a href="{{ route('reports.organizers') }}">Organizers Report</a></li>
                    </ul>
                </li>
            @elseif(Auth::check() && Auth::user()->isOrganizer())
                <!-- Organizer Menu -->
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-eventbrite"></i><span class="nav-text">Event</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('create-event') }}">Create Event</a></li>
                        <li><a href="{{ route('events.index') }}">Event List</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account"></i><span class="nav-text">Organizer</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('organizer.index') }}">Organizer List</a></li>
                        <li><a href="{{ route('organizer.create') }}">Add Organizer</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="nav-text">Guests</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('guests.index') }}">Guest List</a></li>
                        <li><a href="{{ route('guests.create') }}">Register Guest</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="nav-text">Reports</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('reports.index') }}">Dashboard</a></li>
                        <li><a href="{{ route('reports.events') }}">Events Report</a></li>
                        <li><a href="{{ route('reports.organizers') }}">Organizers Report</a></li>
                    </ul>
                </li>
            @elseif(Auth::check() && Auth::user()->role === 'user')
                <!-- Regular User Menu -->
                <li><a href="{{ route('events.public') }}"><i class="mdi mdi-calendar"></i><span class="nav-text">Browse Events</span></a></li>
                <li><a href="{{ route('my-events') }}"><i class="mdi mdi-ticket"></i><span class="nav-text">My Events</span></a></li>
            @else
                <!-- Guest Menu -->
                <li><a href="{{ route('events.public') }}"><i class="mdi mdi-calendar"></i><span class="nav-text">Browse Events</span></a></li>
            @endif

            <li class="nav-label">Account</li>
            <li>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Are you sure you want to logout?');">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link w-100 text-left">
                        <i class="mdi mdi-arrow-right badge-pill badge-pill badge-danger" style="color: white;"></i>
                        <span class="nav-text">Logout</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</div>
