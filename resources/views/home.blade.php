@extends('layouts.app')

@section('content')

    <div class="container body-text">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="row">
                    <!--Logo Block-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="logo">
                                <img src="/img/logo.png" alt="Horse of Math Attack Logo" class="img-responsive" /> 
                            </div>
                        </div>
                    </div>
                    <!--Info Block-->
                    <div class="row">
                        <div class="col-md-12">
                            @include('common.errors')       
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    <ul>
                                        <li>{!! \Session::get('success') !!}</li>
                                    </ul>
                                </div>
                            @endif
                            @if (\Session::has('error'))
                                <div class="alert alert-info">
                                    <ul>
                                        <li>{!! \Session::get('error') !!}</li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--Form Block-->
                    <div class="row">
                        <p class="tagline"> 
                        Send 6, 12 or a ridiculous 24 horse text messages to friends and family from random numbers 
                        to really mess with their minds as an awesome prank!
                        </p>
                        <div class="payment">
                            <form id="homeForm" action="sendmessage" method="post">  
                                <div class="form-group">
                                    <!-- <label for ="ThemeId">Theme</label> -->
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
                                    <input class="form-control" type="phone" name="UserPhone"placeholder="Phone number (5554447788)*"/>
                                </div>                    
                                <div class="form-group">
                                    <select id="selectPlan" class="form-control" name="PlanId">
                                        @forelse($attackPlans as $attackPlan)
                                            <option 
                                                value="{{ $attackPlan->id }}"
                                                @if ($attackPlan->selected == 1)
                                                  selected=""
                                                @endif >
                                                    {{ $attackPlan->name }}  ${{$attackPlan->value}}
                                            </option>
                                        @empty
                                            <option>No plans</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="UserName" placeholder="Your Name *" />
                                </div>
                                <div class = "form-group">
                                    <label for ="TextMessage">Message</label>
                                    <textarea class="form-control size-fix" name="TextMessage" rows = "2"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
                                        <button class="btn btn-primary" name="Submit" value="stripe" type="submit" >Pay by Stripe</button>       
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
                                        <button class="btn  btn-primary" name="Submit" value="paypal" type="submit">Pay by PayPal</button>
                                    </div> 
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            </form>
                        </div>
                        <div class="footer-info">
                            <p> 
                            We store no data and never see you credit card. All transactions
                            processed through Stripe.com and PayPal.com
                            </p>
                            <p>
                            * We need your name to comply with spam regulations and inform yout friend who is sending the attack.
                            </p>
                            <p> 
                            US numbers only please. Standart text rates apply and fockie.com is not responsible for any such fees, so please use responsibly.
                            </p>
                        </div>
                    </div> 
                    <div class="row">
                        <hr>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left main-footer">
                                <ul class="list-inline">
                                    <li><a href="#">About</a></li>
                                    <li><a href="#">Privacy</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right main-footer">
                                <p>&copy;2017 FocFoc</p>
                            </div>
                    </div>
                </div>
            </div>
            <div class="hidden-xs col-sm-6 col-md-6 col-lg-6">
                <div class="side-right"></div>
            </div>
        </div>
    </div>

@endsection