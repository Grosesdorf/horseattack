<?php

namespace App\Http\Controllers;

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

        // dd($_POST);

        $validator = Validator::make($request->all(), [
          'UserPhone' => 'required|numeric',
          'UserName' => 'required|alpha',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

            $sid = 'AC94354d1239740b5784d063c89eece3e5';
            $token = '6b5232b6b42ecf3def3a82da6ee0e049';
            $client = new Client($sid, $token);

            // Use the client to do fun stuff like send text messages!
            $client->messages->create(
                // the number you'd like to send the message to
                '+15862329830',
                array(
                    'from' => '+16267738639',
                    'body' => 'Hey Vladimir! Good luck!',
                    // 'mediaUrl' => $_SERVER["DOCUMENT_ROOT"].'/public/img/horses/sheet_2_square.023.jpeg'
                    'mediaUrl' => 'http://cs413818.vk.me/v413818702/e55/ZwnuBlZZJbU.jpg'
                )
            );
        
        // return redirect('');
        return redirect()->back()->with('success', 'Cheers! Your message has been sent!');
        // return redirect()->with('success', 'Cheers! Your message has been sent!');
    }
}
