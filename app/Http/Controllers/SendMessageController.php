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

      // dd($request->input("UserPhone"));

      $toPhone = $request->input("UserPhone");
      $fromUser = $request->input("UserName");
      $idTheme = $request->input("ThemeId");
      $idPlan = $request->input("PlanId");
      $submit = $request->input("Submit");

      $parameters = ['toPhone' => $toPhone, 
                     'fromUser' => $fromUser,
                     'idTheme' => $idTheme,
                     'idPlan' => $idPlan
                     ];

      if($submit == "stripe"){
        return redirect()->action('StripeController@valid', $parameters);
      }
      elseif ($submit === "paypal") {
        return redirect('/paypal')->with($parameters);
      }
      else{
        return redirect('/');
      }
      
      // echo $toPhone;
      // echo $fromUser;
      // echo $submit;

            // $sid = 'AC94354d1239740b5784d063c89eece3e5';
            // $token = '6b5232b6b42ecf3def3a82da6ee0e049';
            // $client = new Client($sid, $token);

            // // Use the client to do fun stuff like send text messages!
            // $client->messages->create(
            //     // the number you'd like to send the message to
            //     '+15862329830',
            //     array(
            //         'from' => '+16267738639',
            //         'body' => 'Hey Vladimir! Good luck!',
            //         // 'mediaUrl' => $_SERVER["DOCUMENT_ROOT"].'/public/img/horses/sheet_2_square.023.jpeg'
            //         'mediaUrl' => 'http://cs413818.vk.me/v413818702/e55/ZwnuBlZZJbU.jpg'
            //     )
            // );
        
        // return redirect('');
        // return redirect()->back()->with('success', 'Cheers! Your message has been sent!');
        // return redirect()->with('success', 'Cheers! Your message has been sent!');
    }
}
