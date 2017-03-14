<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\AttackPlan;
use App\Sign;
use Illuminate\Http\Request;
use Validator;
use Twilio\Rest\Client; 

class SendMessageController extends Controller{
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

      //Валидация формы

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
      // Вытягиваем ключи с .env
      $tssid = $_ENV['TWILIO_TEST_ACCOUNT_SID'];
      $tstoken = $_ENV['TWILIO_TEST_AUTHTOKEN'];
      $from = $_ENV['TWILIO_FROM'];
      
      $arrTwilio = [];
      $arrRand = [];
      $urlImage = [];
      $arrSigns = [];
      // Готовим данные для отправки ММС
      $toPhone = (substr($request->input("toPhone"), 0, 3) == '095') ?
                       '+38'.$request->input("toPhone") : 
                       '+1'.$request->input("toPhone");
      $fromUser = $request->input("fromUser");
      $emailUser = (null !== ($request->input("emailUser"))) ? $request->input("emailUser") : 'NoEmail';
      $value = (int)$request->input("value");
      $idTheme = $request->input("idTheme");
      $idPlan = $request->input("idPlan");
      $textMsg = $request->input("textMsg");
      
       if($textMsg == null){
        $textMsg = '';
       }
       elseif((substr($textMsg, -1) != '.') && substr($textMsg, -1) != '!' && substr($textMsg, -1) != '?'){
        $textMsg .= '.';
        $textMsg = ucfirst($textMsg);
       }
       else{
        $textMsg = ucfirst($textMsg);
       }
    
      $countMsg = AttackPlan::where('id', $idPlan)->value("count_msg");
      // Генерируем массив случайных чисел по количеству ММС
      // Если картинок будет больше 30, можно $countMsg == 24 выбросить
      while(true) { 
        if(count($arrRand) == (int)$countMsg){
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
      // Формируем ссылки на картинки с учетом массива случайных чисел
      foreach ($arrRand as $value) {
        $urlImage[] = "https://s3-us-west-2.amazonaws.com/bucket-attack/horses/sheet2square".$value.".jpeg";
      }
      // Готовим массив случайных чисел для подписей картинок по количеству ММС
      // !!! Подписи необходимо добавить в БД.. Сейчас 18. Необходимо как минимум 30
      $arrRand = [];
      $countSigns = (int)$countMsg;

      while(true) { 
        if(count($arrRand) == $countSigns){
          break;
        }
        else{
          //Жесткое условие, в идеале взять количество подписей из БД
          $i = rand(1, 18);
          if(!in_array($i, $arrRand)){
            $arrRand[] += $i;  
          }
        }
      }
      // Формируем массив с подписями
      foreach ($arrRand as $value) {
        $arrSigns[] = Sign::where('id', $value)->value("name");
      }
      // Производим отправку ММС
      $sms = new Client($tssid, $tstoken);

      $flag = false;
      // Одно ММС -> один эллемент массивов
      while(true){
        if($flag == false&&!empty($urlImage)){
          $arrTwilio = ['from' => $from,
                'body' => 'Horses of Math Attack from '.$fromUser. ". " .$textMsg. " ".array_shift($arrSigns),
                'mediaUrl' => array_shift($urlImage)
                ];
          $flag = true;
          $sms->messages->create(
            $toPhone,
            $arrTwilio
          );
        }
        elseif(!empty($urlImage)){
          sleep(1);
          $arrTwilio = ['from' => $from,
                'body' => array_shift($arrSigns),
                'mediaUrl' => array_shift($urlImage)
                ];
          $sms->messages->create(
            $toPhone,
            $arrTwilio
          );
          // echo '<pre>';
          // var_dump($arrTwilio);
          // echo '</pre>';
        }
        else{
          break;
        }
      }

      return redirect('/')->with('success', 'Cheers! Your message has been sent!');
    }
  }

