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

      // dd($request);
      $reqParam = $request->all();

      if(!empty($reqParam)){
        $idTheme = $request->input("idTheme");
        $idPlan = $request->input("idPlan");

        $value = Theme::find($idTheme)->plans()->where('id', '=', $idPlan)->value('value');

        return view('stripe', ["value" => $value]);  
      }
      else{
        return redirect('/')->with('error', 'Stripe: Something went wrong. Try again.');
      }
    }

    public function valid(Request $request){

      if($_ENV['MODE_PAY'] == "sandbox"){
        $paySecret = $_ENV['TEST_STRIPE_SECRET'];
      }
      elseif ($_ENV['MODE_PAY'] == "live") {
        $paySecret = $_ENV['STRIPE_SECRET'];
      }

      $cardNumber = $request->input("cardNumber");
      $value = floatval($request->input("value")) * 100;
      $stripeToken = $request->input("stripeToken");
      $toPhone = $request->input("toPhone");
      $fromUser = $request->input("fromUser");
      $idTheme = $request->input("idTheme");
      $idPlan = $request->input("idPlan");
      $textMsg = $request->input("textMsg");
      $emailUser = (null !== ($request->input("emailUser"))) ? $request->input("emailUser") : 'No Email';



      \Stripe\Stripe::setApiKey($paySecret);
      $charge = \Stripe\Charge::create(array(
          'amount' => $value,  // Amount in cents!
          'currency' => 'usd',
          'source' => $stripeToken,
          'description' => $emailUser
      ));

      if($charge->paid == true){

        $parameters = ['system' => "stripe",
                       'toPhone' => $toPhone, 
                       'fromUser' => $fromUser,
                       'textMsg' => $textMsg,
                       'emailUser' => $emailUser,
                       'value' => $value,
                       'idTheme' => $idTheme,
                       'idPlan' => $idPlan
                     ];

        return redirect()->action('SendMessageController@send', $parameters);
      } 
      else{
        return redirect('/')->with('error', 'Stripe: Something went wrong. Try again.');
      }
  }
}
