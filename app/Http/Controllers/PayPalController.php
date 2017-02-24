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

      if($_ENV['MODE_PAY'] == "sandbox"){
        $modePay = 'sandbox';
        $payId = $_ENV['TEST_PAY_ID'];
        $paySecret = $_ENV['TEST_PAY_SECRET'];
      }
      elseif ($_ENV['MODE_PAY'] == "live") {
        $modePay = 'live';
        $payId = $_ENV['PAY_ID'];
        $paySecret = $_ENV['PAY_SECRET'];
      }

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
                                        $payId,          // ClientID
                                        $paySecret       // ClientSecret
                                    )
        );

        $apiContext->setConfig(
          array(
            'mode' => $modePay,
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
        $redirectUrls->setReturnUrl('http://someattack.local/paypal/valid?ph='.urlencode($ph).
                                                                          '&pl='.urlencode($pl).   
                                                                          '&th='.urlencode($th).   
                                                                          '&us='.urlencode($us).  
                                                                          '&ms='.urlencode($ms)) 
                     ->setCancelUrl('http://someattack.local/paypal/cancel');

        // $redirectUrls->setReturnUrl('http://www.fockie.com/paypal/valid?ph='.urlencode($ph).
        //                                                                   '&pl='.urlencode($pl).   
        //                                                                   '&th='.urlencode($th).   
        //                                                                   '&us='.urlencode($us).  
        //                                                                   '&ms='.urlencode($ms)) 
        //              ->setCancelUrl('http://www.fockie.com/paypal/cancel');



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

      if($_ENV['MODE_PAY'] == "sandbox"){
        $modePay = 'sandbox';
        $payId = $_ENV['TEST_PAY_ID'];
        $paySecret = $_ENV['TEST_PAY_SECRET'];
      }
      elseif ($_ENV['MODE_PAY'] == "live") {
        $modePay = 'live';
        $payId = $_ENV['PAY_ID'];
        $paySecret = $_ENV['PAY_SECRET'];
      }

      $apiContext = new ApiContext(
                                    new OAuthTokenCredential(
                                        $payId,     // ClientID
                                        $paySecret      // ClientSecret
                                    )
      );

      $apiContext->setConfig(
        array(
          'mode' => $modePay,
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
          $transaction = $result->toArray();
          // dd($transaction);
          $parameters = ['system' => "paypal",
                         'toPhone' => $request->input('ph'), 
                         'fromUser' => $request->input('us'), 
                         'textMsg' => $request->input("ms"),
                         'emailUser' => $transaction['transactions'][0]['payee']['email'],
                         'value' => floatval($transaction['transactions'][0]['amount']['total'])*100,
                         'idTheme' => $request->input('th'),
                         'idPlan' => $request->input('pl')
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
      // "You cancelled."
      return redirect('/')->with('error', 'You cancelled.');
    }

    public function errorPayment(Request $request){
      // "Something went wrong."
      return redirect('/')->with('error', 'PayPal: Something went wrong.');
    }
}
