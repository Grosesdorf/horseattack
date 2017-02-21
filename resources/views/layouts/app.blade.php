<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap -->
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="/wp-content/themes/clear-theme/js/html5shiv.js"></script>
        <![endif]-->
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/main.css" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/adminattackplans') }}">Admin Panel</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif
        </div>

        @yield('content')
  
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://js.stripe.com/v2/"></script>
    <!-- <script src="https://js.braintreegateway.com/web/3.8.0/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.8.0/js/paypal.min.js"></script> -->
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <!-- <script src="//www.paypalobjects.com/api/checkout.js" async></script> -->
    <script src="/js/bootstrap.js"></script>
    <script src="/js/main.js"></script>
    </body>
</html>

