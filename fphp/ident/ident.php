<?php
  if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
    echo ("ErrorP");
    exit;
  }else{
    echo ("Ok");
//    $resultaut = 'Ok - POST12';     
  };
  exit;
  
  /*
  require "../phpmain.php";    
  $IDUser = 0;
  if (DeCodeIDUser($_POST['VIDUser'], $IDUser)==false){
    echo ('ErrorC');
    exit;
  };
  $NewLogin = filter_var(trim($_POST['VNewLogin']),FILTER_SANITIZE_STRING); 
  $mysql = ConnBD();

  $SRes = fTestLogin($mysql, $NewLogin);

  if ($SRes != 'OK'){
    echo ($SRes);
    mysqli_close($mysql);
    exit;
  };
///////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////
  /////////////////  Старт транзации 
  $query = "Start transaction";
  if (mysqli_query ($mysql, $query)){
    $SRes = 'OK';
  }else{
    $SRes = "ERROR - Start";
    echo ($SRes);
    mysqli_close($mysql);
    exit;
  };    

  ///////////////////////////////////////////
  //  echo ($SRes);
  ///////////////////////////////////////////
  $SRes = fUpDateTUser($mysql, $IDUser, $NewLogin);

  if ($SRes =='OK'){
    $SRes = fInsertTHist($mysql, $IDUser, $NewLogin);
  }

  if ($SRes != 'OK'){
    $query = "ROLLBACK";
    $SRes .= "ROLLBACK/";
     } else {
    $query = "COMMIT";
    $SRes = "";
  };

  if (mysqli_query ($mysql, $query)){
    $SRes .= "OK";
  }else{
    $SRes .= "ERROR - QCOM";
  };    
  mysqli_close($mysql);
  echo ($SRes);
*/
  ////////////////////////////////////////////////////////////////////////////
/*
  function fTestLogin($mysql, $NewLogin){
    $query = ' SELECT IDUser FROM bdschool.TUser WHERE UserLogin = "'.$NewLogin.'"';

    //echo ($query);
  
    $res = mysqli_query($mysql, $query);
    $rows = mysqli_num_rows($res); // количество полученных строк
    if ($rows>0){
      $SRes = 'LClose';  
    } else {
      $SRes = 'OK';  
    };
    return $SRes;
  };  

  function fUpDateTUser($mysql, $IDUser, $NewLogin){
    $query = 'UpDate bdschool.TUser SET UserLogin = "'.$NewLogin.'" WHERE IDUser = '.$IDUser;
    if (mysqli_query ($mysql, $query)){
      $SRes = "OK";
    }else{
      $SRes = "ERROR - ";
      if ($IDUser == 1) {
        $SRes .= $query;
      }
    };    
    return $SRes;
  };

  function fInsertTHist($mysql, $IDUser, $NewLogin){
    $query = 'INSERT INTO bdschool.THist (HsDeystID, HsUserID, HsNode, HsDate) VALUES (';
    $query .= '100, '.$IDUser.', "EDIT LOGIN SET - '.$NewLogin.'", NOW())';

    if (mysqli_query ($mysql, $query)){
      $SRes = "OK";
    }else{
      $SRes = "ERROR - ";
      if ($IDUser == 1) {
        $SRes .= $query;
      }
    };    
    return $SRes;
  };
  */
?>