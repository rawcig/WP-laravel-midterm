<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Event Management') - G8 Events</title>
    @include('backend.assets.css.css')
    <style>
        .frontend-header {
            background: linear-gradient(135deg, #7366ff 0%, #5c4dff 100%);
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .frontend-header .navbar {
            background: transparent;
        }
        .frontend-header .nav-link {
            color: white !important;
        }
        .event-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
    <!-- Frontend Header -->
    <div class="frontend-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand text-white font-weight-bold" href="{{ route('home') }}">
                    <i class="mdi mdi-calendar"></i> G8 Events
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('events.public') }}">
                                <i class="mdi mdi-calendar"></i> Browse Events
                            </a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('my-events') }}">
                                    <i class="mdi mdi-ticket"></i> My Events
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('app-profile') }}">
                                    <i class="mdi mdi-account"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-light btn-sm">
                                        <i class="mdi mdi-logout"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="mdi mdi-login"></i> Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-light btn-sm" href="{{ route('register') }}">
                                    <i class="mdi mdi-account-plus"></i> Sign Up
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="mdi mdi-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mdi mdi-alert-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-muted">&copy; {{ date('Y') }} G8 Event Management System. All rights reserved.</p>
        </div>
    </footer>

    @include('backend.assets.js.js')
</body>
</html>
