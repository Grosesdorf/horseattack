<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Theme;
use App\AttackPlan;

class StripeController extends Controller{

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

      $idTheme = $request->input("idTheme");
      $idPlan = $request->input("idPlan");

      $value = Theme::find($idTheme)->plans()->where('id', '=', $idPlan)->value('value');

      return view('stripe', ["value" => $value]);

    }

    public function valid(Request $request){

      $cardNumber = $request->input("cardNumber");
      $value = floatval($request->input("value")) * 100;
      $stripeToken = $request->input("stripeToken");
      $toPhone = $request->input("toPhone");
      $fromUser = $request->input("fromUser");
      $idTheme = $request->input("idTheme");
      $idPlan = $request->input("idPlan");
      $textMsg = (null !== ($request->input("textMsg"))) ? $request->input("textMsg") : '';
      $emailUser = (null !== ($request->input("emailUser"))) ? $request->input("emailUser") : 'No Email';

      \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET']);
      $charge = \Stripe\Charge::create(array(
          'amount' => $value, // Amount in cents!
          'currency' => 'usd',
          'source' => $stripeToken,
          'description' => $emailUser
      ));

      if($charge->paid == true){
        $countMsg = AttackPlan::where('id', $idPlan)->value("count_msg");
        $arrRand = [];
        $parameters = [];
        $urlImage = [];
        while(true) { 
          if(count($arrRand) == $countMsg){
            break;
          }
          else{
            $i = rand(1, 23);
            if(!in_array($i, $arrRand)){
              $arrRand[] += $i;  
            }
          }
        }

        foreach ($arrRand as $value) {
          $urlImage[] = "https://s3-us-west-2.amazonaws.com/bucket-attack/horses/sheet2square".$value.".jpeg";
        }
        
        $parameters = ['toPhone' => $toPhone, 
                     'fromUser' => $fromUser,
                     'textMsg' => $textMsg,
                     'urlImage' => $urlImage
                     ];

        return redirect()->action('SendMessageController@send', $parameters);
    }
  }
}
