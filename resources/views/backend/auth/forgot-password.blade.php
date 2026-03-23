<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Forgot Password - Event Management</title>
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
                                    <h3 class="welcome-title">Forgot Password</h3>
                                    <p class="text-muted">Enter your email address and we'll send you a link to reset your password.</p>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Reset Password</h4>
                                    
                                    @if(session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('password.email') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3 text-center">
                                        <a class="text-primary" href="{{ route('login') }}">Back to Login</a>
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
