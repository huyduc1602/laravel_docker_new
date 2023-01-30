<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/notification.css')}}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Bootstrap Bundle with Popper -->
    <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
</head>
<body class="{{ $class ?? '' }}">
@include('layouts.header')
@auth()
    <form id="logout-form" action="#" method="POST" style="display: none;">
        @csrf
    </form>
    @yield('content')
    @include('layouts.footer')
@endauth
@guest()
    @yield('content')
    @include('layouts.footer')
@endguest
@stack('js')
</body>
</html>
