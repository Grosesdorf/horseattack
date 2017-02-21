@extends('layouts.app')

@section('content')
    <div class="container-fluid body-text">
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
                @if (\Session::has('error'))
                    <div class="alert alert-info">
                        <ul>
                            <li>{!! \Session::get('error') !!}</li>
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
                            <input class="form-control" type="phone" name="UserPhone"placeholder="5554447788 *"/>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="UserName" placeholder="Your Name *" />
                        </div>
                        <div class = "form-group">
                            <label for ="TextMessage">Message</label>
                            <textarea class="form-control size-fix" name="TextMessage" rows = "3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-3">
                                <button class="btn btn-primary" name="Submit" value="stripe" type="submit" >Pay by Stripe</button>       
                            </div>
                            <div class="col-md-3">
                                <button class="btn  btn-primary" name="Submit" value="paypal" type="submit">Pay by PayPal</button>
                            </div> 
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection