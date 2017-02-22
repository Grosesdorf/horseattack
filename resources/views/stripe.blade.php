@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div id="paymentErrors"></div>
        </div>
    </div>
    <div class="row form-stripe">
        <div class="col-md-4 col-md-offset-4">
            <form id="stripeForm" class="form" action="" method="post">
                <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" id="cardNumber" class="form-control" name="cardNumber" size="20" placeholder="Enter Card Number" autocomplete="off"/>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="row ">
                    <div class="col-md-4">
                        <input type="text" id="cardMM" class="form-control" name="mmCard" size="2" placeholder="MM" />
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="cardYY" class="form-control" name="yyCard" size="2" placeholder="YY" />
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="cardCCV" class="form-control" name="ccvCard" size="3" placeholder="CCV" />
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <input type="email" class="form-control" name="emailUser" placeholder="Enter Your Email" />
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary" id="submitStripe" name="Submit" value="stripe" type="submit" >Pay ${{$value}}</button>       
                    </div>
                </div>
                </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <input type="hidden" name="value" value="{{$value}}"/>
            </form>
        </div>
    </div>
@endsection
