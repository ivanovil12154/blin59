<?php
  if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
    echo ("ErrorP");
    exit;
  };

  $mysql = null;

  try {
    require "../phpmain.php";    
  
    $mysql = ConnBD();

    $VID = $_POST['VID'];


    $query = 'select 
	TUser.IDUser, 
	TUser.UserNameS, 
	TProfession.ProfName, 
	TOffice.OfName 
from 
	TUser 
	left outer join TProfession on TUser.UserProfID = TProfession.IDProf 
	left outer join TOffice on TUser.UserOfficeID = TOffice.IDOffice 
order by 
	TOffice.OfName, 
	TUser.UserNameS';

    $res = mysqli_query($mysql, $query);
    $rows = mysqli_num_rows($res); // количество полученных строк
    if ($rows < 1){
      $rows = ["OK", 0];


    } else {
      $rows = [["OK", $rows]];
      while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        array_push($rows, $row);
      };
    };
    echo json_encode($rows);

/*

    if (QueryCheckUser($mysql, $VLogin, $VPassword, $vID,  $vName,  $vStatus)){

      session_start();

      $_SESSION['idusert'] = $vID; 
      $_SESSION['username'] = $vName;
      $_SESSION['userstatus'] = $vStatus;
      
      $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
      $_SESSION['ra'] = $_SERVER['REMOTE_ADDR'];
      $_SESSION['ff'] = $_SERVER['HTTP_X_FORWARDED_FOR'];

      session_write_close(); 

      $arr = array(
          "res" => "OK",
          "idr" => $vID,
          "name" => $vName,
          "status" => $vStatus,);
    } else {
      $arr = array(
          "res" => "ErrorLogin",
          "idr" => '',
          "name" => '',
          "status" => '',);
    };
    echo json_encode($arr);
    */
  } catch (Exception $e) {
    echo 'Error, PHP перехватил исключение: ',  $e->getMessage(), "\n";
  }finally {
    mysqli_close($mysql);
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