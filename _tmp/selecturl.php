$textMsg = (null !== ($request->input("textMsg"))) ? $request->input("textMsg") : '';
      $emailUser = (null !== ($request->input("emailUser"))) ? $request->input("emailUser") : 'No Email';


$countMsg = AttackPlan::where('id', $idPlan)->value("count_msg");
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
            $i = rand(1, 23);
            if(!in_array($i, $arrRand)){
              $arrRand[] += $i;  
            }
          }
        }

        foreach ($arrRand as $value) {
          $urlImage[] = "https://s3-us-west-2.amazonaws.com/bucket-attack/horses/sheet2square".$value.".jpeg";
        }
        
        $parameters = ['toPhone' => $toPhone, 
                     'fromUser' => $fromUser,
                     'textMsg' => $textMsg,
                     'urlImage' => $urlImage
                     ];


/////////////////////PAY

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