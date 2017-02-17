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

                <div class="container-fluid body-text">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="logo">
                                    <img src="/img/logo.png" alt="Goat Attack Logo" class="img-responsive" />
                                    <p class="tagline">Ram these goats down your friends throats!!</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            @include('common.errors')       
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    <ul>
                                        <li>{!! \Session::get('success') !!}</li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="payment">
                                <form id="homeForm" action="sendmessage" method="post">  
                                    <div class="form-group">
                                        <label for ="ThemeId">Theme</label>
                                        <select id="selectTheme" class="form-control" name="ThemeId" data-path-img="{{ $pathImg }}">
                                            @forelse($attackThemes as $attackTheme)
                                                <option 
                                                    value="{{ $attackTheme->id }}"
                                                    @if (isset($idSelected) && $idSelected == $attackTheme->id)
                                                      selected=""
                                                    @endif >
                                                        {{ $attackTheme->name }}
                                                </option>
                                            @empty
                                                <option>No themes</option>
                                            @endforelse
                                        </select>
                                    </div>                      
                                    <div class="form-group">
                                        <input class="form-control" type="phone" name="UserPhone"placeholder="Phone Number (5554447788)" required />
                                    </div>
                                    <div class="form-group">
                                        <select id="selectPlan" class="form-control" name="PlanId">
                                            @forelse($attackPlans as $attackPlan)
                                                <option 
                                                    value="{{ $attackPlan->id }}"
                                                    @if ($attackPlan->selected == 1)
                                                      selected=""
                                                    @endif >
                                                        {{ $attackPlan->name }}
                                                </option>
                                            @empty
                                                <option>No plans</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="UserName" placeholder="Your Name*" required />
                                    </div>
                                    <div class = "form-group">
                                        <label for ="TextMessage">Message</label>
                                        <textarea class="form-control size-fix" name="TextMessage" rows = "3"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-md-offset-3">
                                            <button id="stripeButton" class="btn btn-primary" type="submit" name="Submit" value="Stripe"
                                                data-key="" 
                                                data-currency="usd"
                                                data-name="Inc."
                                                data-description="MMS"
                                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png">
                                                Pay by Stripe
                                            </button>       
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn  btn-primary" name="Submit" value="PayPal" type="submit">Pay by PayPal</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="container-fluid">
                    <footer class="text-center main-footer">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-3">
                                <ul class="list-inline">
                                    <li><a href="/">Home</a></li>
                                    <li><a href="#">About &amp; Privacy</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <p>&copy; 2017 Horse of Math</p>
                            </div>
                            <div class="col-md-2">
                                <ul class="list-inline">
                                    <li><a href="https://twitter.com/goatattackme" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
                                    <li><a href="https://instagram.com/goatattackme" target="_blank"><i class="fa fa-instagram fa-2x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </footer>
                </div>

            
                    
               
        
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/main.js"></script>
    </body>
</html>
