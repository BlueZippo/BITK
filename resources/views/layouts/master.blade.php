<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon/favicon.ico') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-touch-icon.png') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicon/apple-touch-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicon/apple-touch-icon-72x72.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon/apple-touch-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicon/apple-touch-icon-114x114.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicon/apple-touch-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicon/apple-touch-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon-180x180.png') }}" />

    {{--<title>{{config('app.name')}}</title>--}}
    <title>Platstack</title>

    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

    <link href="{{ asset('css/jquery-confirm.min.css') }}" rel="stylesheet">

    <link href="{{ asset('fonts/vendor/helvetica/stylesheet.css') }}" rel="stylesheet">
    

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    
    @yield('style')

</head>

<body>

    @include('layouts.nav.nav')

    <!-- Begin page content -->
        @if (Request::is('stacks/explore') || 
             Request::is('stacks/popular') ||
             Request::is('stacks/new') ||
             Request::is('stacks/trending') ||
             Request::is('stacks/top-voted') ||
             Request::is('stacks/top-thread') ||
             Request::is('stacks/following') ||
             Request::is('stacks/my') ||
             Request::is('stacks/new-people') ||
             Request::is('stacks/trending-people') ||
             Request::is('stacks/top-people') ||
             Request::is('stacks/following-people') ||
             Request::is('stacks/my-profile')
             )
            <main role="main" class="container-fluid">
        @else
            <main role="main" class="container">
        @endif

        @include('inc.messages')

        @yield('sidebar')

        @yield('content')

        

    </main>



    <!---
    <link href="{{ asset('fonts/vendor/helvetica/stylesheet.css') }}" rel="stylesheet"><script src="{{asset('js/app.js')}}" ></script>
    -->

    @include('layouts.footer')    

    @yield('scripts')

</body>

</html>
