<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - Event Management</title>
    @include('backend.assets.css.css')
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-10">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-6">
                                <div class="welcome-content">
                                    <div class="brand-logo">
                                        <a href="{{ route('home') }}">G8 Events</a>
                                    </div>
                                    <h3 class="welcome-title">Welcome to Event Management</h3>
                                    <div class="intro-social">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    
                                    <!-- Success Message -->
                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="mdi mdi-check-circle mr-2"></i>
                                            {{ session('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <!-- Error Message -->
                                    @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="mdi mdi-alert-circle mr-2"></i>
                                            {{ session('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   name="password" placeholder="Enter your password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <div class="form-check ml-2">
                                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                                    <label class="form-check-label" for="remember">Remember me</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign me in</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="{{ route('register') }}">Sign up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.assets.js.js')
</body>
</html>
