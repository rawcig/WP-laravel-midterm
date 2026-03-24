<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'User Dashboard') - G8 Events</title>
    @include('backend.assets.css.css')
</head>
<body>
    @include('backend.layout.header')
    @include('backend.layout.sidebar')
    
    <div class="content-body">
        @yield('content')
    </div>
    
    @include('backend.layout.footer')
    @include('backend.assets.js.js')
</body>
</html>
