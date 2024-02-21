<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>{{ $app->nama }}</title>
    <meta name="description" content="{{ $app->nama }}">
    <meta name="keywords"
        content="bootstrap, wallet, banking, fintech mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="{{ URL::asset('assets_mobile/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('assets_mobile/img/icon/192x192.png') }}">
    <link href="{{ URL::asset('/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets_mobile/css/style.css')}}">
    <link rel="manifest" href="__manifest.json">
    <script src="{{ URL::asset('/js/jquery.min.js') }}"></script>
    <style>
        .wallet-card-section::before {
            background: #FF396F !important;
        }
    </style>
</head>

<body>

    <!-- loader -->
    <div id="loader">
        <img src="{{ URL::asset('assets_mobile/img/loading-icon.png') }}" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-danger text-light">
        <div class="left">
            <span class="headerButton">{{ auth()->user()->name }}</span>
        </div>
        <div class="pageTitle">
            {{ $app->nama }}
            <!-- <img src="{{ URL::asset('assets_mobile/img/logo.png') }}" alt="logo" class="logo"> -->
        </div>
        <div class="right">
            <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="headerButton">
                <ion-icon name="log-out"></ion-icon>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">

    @yield('content')

        <!-- app footer -->
        <div class="appFooter">
            <div class="footer-title">
                Copyright © Finapp 2021. All Rights Reserved.
            </div>
            Bootstrap 5 based mobile template.
        </div>
        <!-- * app footer -->

    </div>
    <!-- * App Capsule -->


    <!-- ========= JS Files =========  -->
    <!-- Bootstrap -->
    <script src="{{ URL::asset('assets_mobile/js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="{{ URL::asset('assets_mobile/js/plugins/splide/splide.min.js') }}"></script>
    <!-- Base Js File -->
    <script src="{{ URL::asset('assets_mobile/js/base.js') }}"></script>
    <script src="{{ URL::asset('/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
        // Add to Home with 2 seconds delay.
        AddtoHome("2000", "once");
    </script>

</body>

</html>