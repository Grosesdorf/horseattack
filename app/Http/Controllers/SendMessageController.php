<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\AttackPlan;
use App\Sign;
use Illuminate\Http\Request;
use Validator;
use Twilio\Rest\Client; 

class SendMessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

      $phonePattern = '/\b\d{3}[-.]?\d{3}[-.]?\d{4}\b/';

      $validator = Validator::make($request->all(), [
        'UserPhone' => 'required|regex:' . $phonePattern,
        'UserName' => 'required|alpha',
      ]);

      if ($validator->fails()) {
          return redirect()
                      ->back()
                      ->withErrors($validator)
                      ->withInput();
      }

      $toPhone = $request->input("UserPhone");
      $fromUser = $request->input("UserName");
      $idTheme = $request->input("ThemeId");
      $idPlan = $request->input("PlanId");
      $textMsg = $request->input("TextMessage");
      $submit = $request->input("Submit");

      $parameters = ['toPhone' => $toPhone, 
                     'fromUser' => $fromUser,
                     'idTheme' => $idTheme,
                     'idPlan' => $idPlan,
                     'textMsg' => $textMsg
                     ];

      if($submit == "stripe"){
        return redirect()->action('StripeController@valid', $parameters);
      }
      elseif ($submit === "paypal"){
        return redirect()->action('PayPalController@index', $parameters);
      }
      else{
        return redirect('/')->with('error', 'Try again.');
      }
    }

    public function send(Request $request){

      $tssid = $_ENV['TWILIO_TEST_ACCOUNT_SID'];
      $tstoken = $_ENV['TWILIO_TEST_AUTHTOKEN'];
      $from = $_ENV['TWILIO_FROM'];
      // dd($request->all());
      $arrTwilio = [];
      $arrRand = [];
      $urlImage = [];

      $toPhone = (substr($request->input("toPhone"), 0, 2) === '095') ?
                       '+38'.$request->input("toPhone") : 
                       '+1'.$request->input("toPhone");
      $fromUser = $request->input("fromUser");
      $emailUser = (null !== ($request->input("emailUser"))) ? $request->input("emailUser") : 'NoEmail';
      $textMsg = (null !== ($request->input("textMsg"))) ? $request->input("textMsg") : '';
      $value = (int)$request->input("value");
      $idTheme = $request->input("idTheme");
      $idPlan = $request->input("idPlan");

      $countMsg = AttackPlan::where('id', $idPlan)->value("count_msg");
      
      while(true) { 
        if(count($arrRand) == $countMsg){
          break;
        }
        elseif ($countMsg == 24) {
            $arrRand = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24];
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

      $arrRand = [];

      while(true) { 
        if(count($arrRand) == ($countMsg / 3)){
          break;
        }
        else{
          $i = rand(1, 23);
          if(!in_array($i, $arrRand)){
            $arrRand[] += $i;  
          }
        }
      }

      $sign = Sign::where('id', $i)->value("name");

      dd($countMsg, $arrRand);

      $arrTwilio = ['from' => $from,
                    'body' => 'Horses of Math Attack from '.$fromUser. ". " .$textMsg,
                    'mediaUrl' => $urlImage
                    ];

      // $sms = new Client($tssid, $tstoken);

      // $flag = false;
      
      // while(true){
      //   $tmpUrlImage = [];
      //   // dd($urlImage);
      //   if(!empty($urlImage) && ($flag === false)){
      //     for($i = 0; $i < 3; $i++){
      //       $tmpUrlImage[] = array_shift($urlImage);
      //     }
      //     // dd("1 ", $urlImage, $tmpUrlImage);
      //     $flag = true;
      //     $arrTwilio = ['from' => $from,
      //               'body' => 'Horses of Math Attack from '.$fromUser. ". " .$textMsg,
      //               'mediaUrl' => $tmpUrlImage
      //               ];
      //     $sms->messages->create(
      //     // the number you'd like to send the message to
      //     $toPhone,
      //     $arrTwilio
      //     );  
      //     continue;
      //   }
      //   elseif(!empty($urlImage) && $flag == true){
      //     for($i = 0; $i < 3; $i++){
      //       $tmpUrlImage[] = array_shift($urlImage);
      //     }
      //     // dd("2 ", $urlImage, $tmpUrlImage);
      //     $arrTwilio = ['from' => $from,
      //               'body' => 'Horses of Math Attack from '.$fromUser.".",
      //               'mediaUrl' => $tmpUrlImage
      //               ];
      //     $sms->messages->create(
      //     // the number you'd like to send the message to
      //     $toPhone,
      //     $arrTwilio
      //     );
      //     continue;
      //   }
      //   else{
      //     break;
      //   }              
      
      // return redirect('/')->with('success', 'Cheers! Your message has been sent!');

      // dd($toPhone, $arrTwilio);

      // $sms = new Client($tssid, $tstoken);
      // // Use the client to do fun stuff like send text messages!
      // $sms->messages->create(
      //     // the number you'd like to send the message to
      //     $toPhone,
      //     $arrTwilio
      // );

      // return redirect('/')->with('success', 'Cheers! Your message has been sent!');

    // }
  }
}
