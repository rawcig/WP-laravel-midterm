<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="header-left">
                <div class="nav-item dropdown search_bar">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-magnify"></i>
                    </a>
                    <div class="dropdown-menu">
                        <form class="form-inline">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                        </form>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse justify-content-end">

                <ul class="navbar-nav header-right">
                    @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isOrganizer()))
                        <li class="nav-item border-0">
                            <a class="btn btn-secondary create-event-btn" href="{{ route('create-event') }}">Create Event</a>
                        </li>
                        <li class="nav-item border-0">
                            <a class="btn btn-secondary create-event-btn" href="{{ route('organizer.create') }}">Add Organizer</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-bell"></i>
                            <span class="badge badge-primary">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header">
                                <h5 class="notification_title">Notifications</h5>
                            </div>
                            <ul class="list-unstyled">
                                <li class="media dropdown-item">
                                    <span class="text-primary"><i class="mdi mdi-chart-areaspline mr-3"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <div class="d-flex justify-content-between">
                                                <h5>New order has been received</h5>
                                            </div>
                                            <p class="m-0">2 hours ago</p>
                                        </a>
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="text-success"><i class="mdi mdi-chart-pie mr-3"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <div class="d-flex justify-content-between">
                                                <h5>New customer is registered</h5>
                                            </div>
                                            <p class="m-0">3 hours ago</p>
                                        </a>
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="text-warning"><i class="mdi mdi-file-document mr-3"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <div class="d-flex justify-content-between">
                                                <h5>New file has been uploaded</h5>
                                            </div>
                                            <p class="m-0">3 hours ago</p>
                                        </a>
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </li>
                            </ul>
                            <a class="all-notification" href="#">All Notifications</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(Auth::check())
                                <img src="{{ asset(Auth::user()->avatar_url) }}" alt="{{ Auth::user()->name }}">
                            @else
                                <img src="{{ asset('images/avatar/avatar-media.png') }}" alt="Guest">
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @if(Auth::check())
                                <div class="dropdown-profile-header">
                                    <img src="{{ asset(Auth::user()->avatar_url) }}" alt="{{ Auth::user()->name }}">
                                    <div class="ml-2">
                                        <span class="avatar-name">{{ Auth::user()->name }}</span>
                                        <span class="badge badge-{{ Auth::user()->isAdmin() ? 'danger' : (Auth::user()->isOrganizer() ? 'primary' : 'secondary') }} ml-0">
                                            {{ ucfirst(Auth::user()->role) }}
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('app-profile') }}" class="dropdown-item">
                                    <i class="mdi mdi-account"></i>
                                    <span>Profile</span>
                                </a>
                                @if(Auth::user()->isAdmin() || Auth::user()->isOrganizer())
                                    <a href="{{ route('create-event') }}" class="dropdown-item">
                                        <i class="mdi mdi-ticket"></i>
                                        <span>Create Event</span>
                                    </a>
                                    <a href="{{ route('organizer.index') }}" class="dropdown-item">
                                        <i class="mdi mdi-account-multiple"></i>
                                        <span>Organizers</span>
                                    </a>
                                @endif
                                <a href="{{ route('events.index') }}" class="dropdown-item">
                                    <i class="mdi mdi-calendar"></i>
                                    <span>Events</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Are you sure you want to logout?');">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="mdi mdi-power"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="dropdown-item">
                                    <i class="mdi mdi-login"></i>
                                    <span>Login</span>
                                </a>
                                <a href="{{ route('register') }}" class="dropdown-item">
                                    <i class="mdi mdi-account-plus"></i>
                                    <span>Register</span>
                                </a>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
