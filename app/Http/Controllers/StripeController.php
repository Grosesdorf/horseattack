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
      $emailUser = (null !== ($request->input("emailUser"))) ? $request->input("emailUser") : 'No Email';

      // \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET']);
      // $charge = \Stripe\Charge::create(array(
      //     'amount' => $value, // Amount in cents!
      //     'currency' => 'usd',
      //     'source' => $stripeToken,
      //     'description' => $emailUser
      // ));

      // if($charge->paid == true){
      if(true){
        $countMsg = AttackPlan::where('id', $idPlan)->value("count_msg");
        $arr = [];
        while(true) { 
          if(count($arr) == $countMsg){
            break;
          }
          else{
            $i = rand(1, 23);
            if(!in_array($i, $arr)){
              $arr[] += $i;  
            }
          }
        }
        
        foreach ($arr as $value) {
          echo "https://s3-us-west-2.amazonaws.com/bucket-attack/horses/sheet2square".$value.".jpeg <br/>";
        }

        $parameters = ['toPhone' => $toPhone, 
                     'fromUser' => $fromUser,
                     'idTheme' => $idTheme,
                     'idPlan' => $idPlan
                     ];


        return redirect()->action('StripeController@valid', $parameters);
        // echo "<pre>";
        // var_dump($arr);
        // echo "</pre>";
        echo $countMsg . "<br />";
        // echo $q["count_msg"] . "<br />";
        echo $idPlan . "<br />";
        echo $cardNumber . "<br />";
        echo $value . "<br />";
        echo $emailUser . "<br />";
        echo $toPhone . "<br />";
      }

      // 

      // return redirect('');
      // return redirect()->back()->with('success', 'Cheers! Your message has been sent!');
      // return redirect()->with('success', 'Cheers! Your message has been sent!');
    }
}
