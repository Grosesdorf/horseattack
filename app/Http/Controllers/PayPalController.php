<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class PayPalController extends Controller
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

      // $validator = Validator::make($request->all(), [
      //   'UserEmail' => 'required|email',
      // ]);

      // if ($validator->fails()) {
      //     return redirect()
      //                 ->back()
      //                 ->withErrors($validator)
      //                 ->withInput();
      // }

      dd("PayPal");

        // return redirect('');
        // return redirect()->back()->with('success', 'Cheers! Your message has been sent!');
        // return redirect()->with('success', 'Cheers! Your message has been sent!');
    }
}
