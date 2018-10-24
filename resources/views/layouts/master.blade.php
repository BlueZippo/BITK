<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="">

    <title>{{config('app.name')}}</title>

    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>

    <!-- Bootstrap core CSS -->
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    {{--<link href="/css/sticky-footer-navbar.css" rel="stylesheet">--}}

    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
</head>

<body>

    @include('layouts.nav.nav')

    <!-- Begin page content -->
    <main role="main" class="container">



        @include('inc.messages')

        @yield('content')
    </main>

    @yield('scripts')

    @include('layouts.footer')




</body>

</html>
