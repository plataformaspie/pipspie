<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Hind:300' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
        <link rel="stylesheet" href="{{ asset('css/style-login.css') }}">
    </head>
    <body>
        @yield('content')


        <script src='http://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js'></script>
        {{-- <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> --}}
        <script type="text/javascript" src=" {{ asset('sty-mode-2/vendor/jquery/jquery-1.11.1.min.js') }}"></script>
        <script  src="{{ asset('js/login.js') }}"></script>
        <script type="text/javascript">
          $(document).ready(function(){
             $(document).ready(function () {
                   $('#login-button').fadeIn(2000);
             });
          });
        </script>
    </body>
</html>
