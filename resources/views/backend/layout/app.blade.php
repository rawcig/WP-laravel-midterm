


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>G8 - @yield('Title')</title>
    <!-- Favicon icon -->
    @include('backend.assets.css.css')

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    @include('backend.layout.pre-loader')
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        @include('backend.layout.nav-header')
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        @include('backend.layout.header')
        <!--**********************************
            Header end
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
       @include('backend.layout.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body @yield('app-profile')">
            <!-- row -->
            @yield('content')
            
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        @include('backend.layout.footer')
        <!--**********************************
            Footer end
        ***********************************-->

        <!--removeIf(production)-->
            {{-- Right sidebar start --}}
        @include('backend.layout.right-sidebar')
            {{-- Right sidebar end --}}
        <!--endRemoveIf(production)-->
    </div>
        {{-- Main wrapper end --}}
    <!-- Required vendors Scripts -->
    @include('backend.assets.js.js')


</body>
</html>