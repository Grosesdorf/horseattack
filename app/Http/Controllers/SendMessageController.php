<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
      elseif ($submit === "paypal") {
        return redirect()->action('PayPalController@valid', $parameters);
      }
      else{
        return redirect('/');
      }
    }

    public function send(Request $request){

      // dd($request->all());
      $arrTwilio = [];

      $toPhone = '+1'.$request->input("toPhone");
      $fromUser = $request->input("fromUser");
      $textMsg = $request->input("textMsg");
      $urlImage = $request->input("urlImage");

      $tssid = $_ENV['TWILIO_TEST_ACCOUNT_SID'];
      $tstoken = $_ENV['TWILIO_TEST_AUTHTOKEN'];
      $from = $_ENV['TWILIO_FROM'];
      $fromMagic = $_ENV['TWILIO_FROM_MAGIC'];

      $arrTwilio = ['from' => $from,
                    'body' => 'From: '.$fromUser. " " .$textMsg,
                    'mediaUrl' => $urlImage
                    ];

      $sms = new Client($tssid, $tstoken);
      // Use the client to do fun stuff like send text messages!
      $sms->messages->create(
          // the number you'd like to send the message to
          $toPhone,
          $arrTwilio
      );

      return redirect('/')->with('success', 'Cheers! Your message has been sent!');

    }
}
