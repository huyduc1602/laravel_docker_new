<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('IDS-VN Timesheet') }}</title>
    <link rel="icon" href="https://s3.ap-northeast-1.amazonaws.com/vn.ids.jp/wp-content/uploads/2022/04/05044408/favicon.ico" sizes="32x32">
    <link rel="apple-touch-icon" href="https://s3.ap-northeast-1.amazonaws.com/vn.ids.jp/wp-content/uploads/2022/04/05044408/favicon.ico">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS Files -->
    <link href="{{ URL::asset('/css/bootstrap-5.0.2/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet" />
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="#" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.page_templates.auth')
        @endauth
        @guest()
            @include('layouts.page_templates.guest')
        @endguest
        <!--   Core JS Files   -->
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="{{ asset('js/core/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-5.0.2/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
        @stack('js')
    </body>
</html>