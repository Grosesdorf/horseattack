<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Theme;
use App\AttackPlan;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

class PayPalController extends Controller{

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

      $reqParam = $request->all();

      // dd($request->all());

      if(!empty($reqParam)){
        $th = $request->input("idTheme");
        $pl = $request->input("idPlan");
        $ph = $request->input("toPhone");
        $us = $request->input("fromUser");
        $ms = $request->input("textMsg");

        $valuePlan = Theme::find($th)->plans()->where('id', '=', $pl)->value('value');
        $namePlan = Theme::find($th)->plans()->where('id', '=', $pl)->value('name');  

        $apiContext = new ApiContext(
                                    new OAuthTokenCredential(
                                        $_ENV['PAY_ID'],          // ClientID
                                        $_ENV['PAY_SECRET']       // ClientSecret
                                    )
        );

        $apiContext->setConfig(
          array(
            // 'mode' => 'sandbox',
            'mode' => 'live',
            'http.connectionTimeOut' => 30,
            'log.LogEnabled' => false,
            'log.FileName' => '',
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log'
          )
        );

        // Create new payer and method
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Set redirect urls
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl('http://www.fockie.com/paypal/valid?ph='.urlencode($ph).
                                                                          '&pl='.urlencode($pl).     //  http://www.fockie.com/paypal/valid
                                                                          '&th='.urlencode($th).     //  http://www.fockie.com/paypal/valid
                                                                          '&us='.urlencode($us).     //  http://www.fockie.com/paypal/valid
                                                                          '&ms='.urlencode($ms))     //  http://www.fockie.com/paypal/valid
                     ->setCancelUrl('http://www.fockie.com/paypal/cancel');   //  http://www.fockie.com/paypal/cancel

        // Set payment amount
        $amount = new Amount();
        $amount->setCurrency("USD")
               ->setTotal($valuePlan);

        // Set transaction object
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setDescription($namePlan);

        // Create the full payment object
        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

        try{

          $payment->create($apiContext);

          // Store to DB

          $approvalUrl = $payment->getApprovalLink();
          // dd($approvalUrl);
          return redirect($approvalUrl);

        } 
        catch(PPConectionException $ex){
          
          // dd("index ", $ex->getCode(), $ex->getData());
          $msg = 'Code: '.$ex->getCode();
          $msg += ' Data: '.$ex->getData();
          return redirect('/')->with('error', $msg);
        } 
        catch (Exception $ex) {
          return redirect('/')->with('error', 'PayPal: Something went wrong. Try again.');
        }

      }
      else{
        // return redirect('/');
        return redirect('/')->with('error', 'Try again.');
      }
  }

    public function validPayment(Request $request){

      // var_dump($request);

      $apiContext = new ApiContext(
                                    new OAuthTokenCredential(
                                        $_ENV['PAY_ID'],     // ClientID
                                        $_ENV['PAY_SECRET']      // ClientSecret
                                    )
      );

      $apiContext->setConfig(
        array(
          // 'mode' => 'sandbox',
          'mode' => 'live',
          'http.connectionTimeOut' => 30,
          'log.LogEnabled' => false,
          'log.FileName' => '',
          'log.LogLevel' => 'FINE',
          'validation.level' => 'log'
        )
      );

        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $apiContext);
        $payerId = $_GET['PayerID'];

        // Execute payment with payer id
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
          // Execute payment
          $result = $payment->execute($execution, $apiContext);

          // dd($_GET['ph']);
          $countMsg = AttackPlan::where('id', $_GET['pl'])->value("count_msg");
          $arrRand = [];
          $parameters = [];
          $urlImage = [];
          while(true) { 
            if(count($arrRand) == $countMsg){
              break;
            }
            elseif ($countMsg == 24) {
              $arrRand = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24];
              break;
            }
            else{
              $i = rand(1, 24);
              if(!in_array($i, $arrRand)){
                $arrRand[] += $i;  
              }
            }
          }

          foreach ($arrRand as $value) {
            $urlImage[] = "https://s3-us-west-2.amazonaws.com/bucket-attack/horses/sheet2square".$value.".jpeg";
          }

          $parameters = ['toPhone' => $_GET['ph'], 
                     'fromUser' => $_GET['us'],
                     'textMsg' => $_GET['ms'],
                     'urlImage' => $urlImage
                     ];

        return redirect()->action('SendMessageController@send', $parameters);

        } 
        catch (PayPalConnectionException $ex) {
          // dd('valid ', $ex->getCode(), $ex->getData());
          $msg = 'Code: '.$ex->getCode();
          $msg += ' Data: '.$ex->getData();
          return redirect('/')->with('error', $msg);
        } 
        catch (Exception $ex) {
          return redirect('/')->with('error', 'PayPal: Something went wrong. Try again.');
        }
    }

    public function cancelPayment(Request $request){

      // dd("PayPal cancel!!! You cancelled.");
      // "You cancelled."
      return redirect('/')->with('error', 'You cancelled.');
    }

    public function errorPayment(Request $request){

      // dd("PayPal error!!! Something went wrong.");
      // "Something went wrong."
      return redirect('/')->with('error', 'PayPal: Something went wrong.');
    }
}
