@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="side-left">
                    <div class="row">
                        <!--Logo Block-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="logo">
                                    <img src="/img/logo.png" alt="Horse of Math Attack Logo" class="img-responsive" /> 
                                </div>
                            </div>
                            </div>
                        </div>
                        <!--Info Block-->
                        <div class="row info-block">
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
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                            <p class="tagline"> 
                            Send 6, 12 or a ridiculous 24 horse text messages to friends and family from random numbers 
                            to really mess with their minds as an awesome prank!
                            </p>
                            
                            <form id="homeForm" action="sendmessage" method="post">  
                                <div class="row">
                                <div class="form-group">
                                    <!-- <label for ="ThemeId">Theme</label> -->
                                    <select id="selectTheme" class="form-control shadow-hors" name="ThemeId" data-path-img="{{ $pathImg }}">
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
                                    <input class="form-control input-hors" type="phone" name="UserPhone" placeholder="Phone number (5554447788)*"/>
                                </div>                    
                                <div class="form-group">
                                    <select id="selectPlan" class="form-control input-hors" name="PlanId">
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
                                    <input class="form-control input-hors" type="text" name="UserName" placeholder="Your Name *" />
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-1 vcenter">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="checkbox-hors">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 vcenter">
                                        <div class="checkbox-hors-text">
                                            Custom Message? (+$0.1)
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea id="textMessage" class="form-control size-fix input-hors" name="TextMessage" rows = "2"></textarea>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <button class="btn  btn-primary submit-btn" name="Submit" value="paypal" type="submit">Pay by PayPal</button>
                                    </div> 
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <button class="btn btn-primary submit-btn" name="Submit" value="stripe" type="submit" >Pay by Credit Card</button>       
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            </form>
                            <div class="info-footer">
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
                            <div class="main-footer">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
                                    <ul class="list-inline">
                                        <li><a href="#">About</a></li>
                                        <li><a href="#">Privacy</a></li>
                                        <li><a href="#">Contact</a></li>
                                    </ul>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                    <p>&copy;2017 FocFoc</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden-xs col-sm-6 col-md-6 col-lg-6">
                <div class="side-right">
                    <img src="/img/back_horse.png" class="img-responsive">
                </div>
            </div>
        </div>
    </div>

@endsection