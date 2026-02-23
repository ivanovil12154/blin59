<?php
  if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
    echo ("ErrorP");
    exit;
  }else{ 
  //  echo ("OK" . $_POST['VLogin']);
//    $resultaut = 'Ok - POST12';     
  };

  try {
  
    require "../phpmain.php";    
  /*
  $IDUser = 0;
  if (DeCodeIDUser($_POST['VIDUser'], $IDUser)==false){
    echo ('ErrorC');
    exit;
  };
  $NewLogin = filter_var(trim($_POST['VNewLogin']),FILTER_SANITIZE_STRING); 
*/
    $mysql = ConnBD();

    $VLogin = $_POST['VLogin'];
    $VPassword = $_POST['VPassword'];

    $SRes = $SRes . ' Login - ' . $VLogin . PHP_EOL; 
    $SRes = $SRes . ' Password - ' . $VPassword . PHP_EOL; 

    $query = 'SELECT f_name FROM user  WHERE f_login = "' . $VLogin . '"';

    $SRes = $SRes . 'query - ' . $query;

//    $query = 'SELECT f_name FROM user';

    

    $res = mysqli_query($mysql, $query);

    $rows = mysqli_num_rows($res); // количество полученных строк

    if ($rows > 0){
      $SRes = $SRes . 'Row > 0 ' . (string)$rows;  
    } else {
      $SRes = $SRes . 'Row = 0';  
    };

    $row = mysqli_fetch_assoc($res);
    $SRes = $SRes . $row['f_name'];

    echo  $SRes;
  } catch (Exception $e) {
    echo 'PHP перехватил исключение: ',  $e->getMessage(), "\n";
  }finally {
    mysqli_close($mysql);
    echo 'OK DB ' . $SRes;    
  }   

  

/*  

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