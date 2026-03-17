<?php
//    sleep(6);
  if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
    echo ("ErrorP");
    exit;
  };
  $VLogin = $_POST['VLogin'];
  $VPassword = $_POST['VPassword'];
  $PARAM = $_POST;
  $PARAM['VFunction'] = 'GetIdent';
  $PARAM['VMethod'] = 'GET';

  require_once  "../php_db.php";  
  $RES = ExeSQL($PARAM);
  if ($RES[0][0][0] == "OK" AND $RES[0][0][1] == 1) {
    $PARAM['VFunction'] = 'InsertSession';
    $PARAM['VMethod'] = 'INSERT';
    $PARAM['VGUID'] = generateGUID() . $RES[0][1]['IDUser'];
    $PARAM['VAGENT'] = $_SERVER['HTTP_USER_AGENT'];
    $PARAM['VIP'] = $_SERVER['REMOTE_ADDR'];
    $PARAM['VIDUser'] = $RES[0][1]['IDUser'];
    $RESSess = ExeSQL($PARAM);
    if ($RES[0][0][0] == "OK") {
      $arr = array(
          "res" => "OK",
          "iduser" => $RES[0][1]['IDUser'], 
          "username" => $RES[0][1]['UserNameS'],
          "userlogin" => $RES[0][1]['UserLogin'],
          "session" => $PARAM['VGUID'],
          "status" => $RES[0][1]['UserStatus']         
          );
      $_SESSION['res'] = "OK";
      $_SESSION['iduser'] = $RES[0][1]['IDUser'];
      $_SESSION['username'] = $RES[0][1]['UserNameS'];
      $_SESSION['userlogin'] = $RES[0][1]['UserLogin'];
      $_SESSION['session'] = $PARAM['VGUID'];
      $_SESSION['status'] = $RES[0][1]['UserStatus'];
    } else {
      $arr = array(
          "res" => "ERROR",
          "error" => "InsertSession");
    };
  } else {
    $arr = array(
          "res" => "ErrorLogin",
          "error" => "ErrorLogin");
  }; 
  echo json_encode($arr);

//  exit;

/*


  $mysql = null;

  try {
    require "../phpmain.php";    
  
    $mysql = ConnBD();
  */
    /*
  $IDUser = 0;
  if (DeCodeIDUser($_POST['VIDUser'], $IDUser)==false){
    echo ('ErrorC');
    exit;
  };
  $NewLogin = filter_var(trim($_POST['VNewLogin']),FILTER_SANITIZE_STRING); 
*/

/*
    $VLogin = $_POST['VLogin'];
    $VPassword = $_POST['VPassword'];

    if (QueryCheckUser($mysql, $VLogin, $VPassword, $vID,  $vName,  $vStatus,  $vuserlogin,  $vsession)){

      session_start();

      $_SESSION['idusert'] = $vID; 
      $_SESSION['username'] = $vName;
      $_SESSION['userstatus'] = $vStatus;

      $_SESSION['res'] = "OK";
      $_SESSION['iduser'] = $vID;
      $_SESSION['username'] = $vName;
      $_SESSION['userlogin'] = $vuserlogin;
      $_SESSION['session'] = $vsession;
      $_SESSION['status'] = $vStatus;


      
      $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
      $_SESSION['ra'] = $_SERVER['REMOTE_ADDR'];
      $_SESSION['ff'] = $_SERVER['HTTP_X_FORWARDED_FOR'];



      session_write_close(); 

      $arr = array(
          "res" => "OK",
          "iduser" => $vID,
          "username" => $vName,
          "userlogin" => $vuserlogin,
          "session" => $vsession,
          "status" => $vStatus,);
    } else {
      $arr = array(
          "res" => "ErrorLogin",
          "idr" => '',
          "name" => '',
          "status" => '',);
    };
    echo json_encode($arr);
  } catch (Exception $e) {
    echo 'Error, PHP перехватил исключение: ',  $e->getMessage(), "\n";
  }finally {
    mysqli_close($mysql);
  };   

*/

function generateGUID() {
    $data = random_bytes(16);
    // Установка версии 4 (случайный UUID)
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Установка варианта 10xx
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
};
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