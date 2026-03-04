<?php
  if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
    $rows = [["ERROR", "NotPost"]];
    echo json_encode($rows);
    exit;
  };
  $mysql = null;
  $query = null;

  $VFunction = $_POST['VFunction'];
  $VMethod = $_POST['VMethod'];
  $VID = $_POST['VID'];
  
  $Param = null;
  $query = GenSQL($Param);

  if ($query == ''){
    $rows = [["ERROR", "NotMethod", $VFunction, $VMethod]];
    echo json_encode($rows);
    exit;
  };

  try{
    $pdo = ConnectPDO();
    
    if ($VMethod = "GET") {
      $stmt = $pdo->prepare($query);
      if ($Param != null) {
        $stmt->execute($Param);
      } else {
        $stmt->execute([]);
      };
      $rows = [];  
      if ($VMethod == "GET") {
        $count = $stmt->rowCount();
        $rows = [["OK", $count]];
        while ($row = $stmt->fetch()) {  // Получить одну строку
           array_push($rows, $row);
        };   
      };  
      if ($VMethod == "SET") {
        $count = $stmt->rowCount();
        $rows = [["OK", $count, $query]];
      };  

      echo json_encode($rows);
    }  
  } catch (Exception $e) {
    $rows = [["ERROR", "PHP", $e->getMessage(), $query]];
    echo json_encode($rows);
  }finally {

    $stmt = null; // Закрыть запрос
    $pdo = null;  // Закрыть соединение
  };   

/*************************************************** */
/*************************************************** */
/*************************************************** */

function ConnectPDO(){
  //Подключение к БД 

$host = 'localhost';
$db   = 'u198290_blin';
$user = 'u198290_user';
$pass = 'user@blin59';
$charset = 'utf8mb4';


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Включение режима ошибок
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Режим выборки по умолчанию
    PDO::ATTR_EMULATE_PREPARES   => false// Реальные подготовленные запросы
];

$pdo = null;


  $pdo = new PDO("mysql:host = $host;dbname = $db", $user, $pass, $options);
return $pdo;   

};

/*************************************************** */
/*************************************************** */
/*************************************************** */

function GenSQL(&$Param){
  $VFunction = $_POST['VFunction'];
  $VMethod = $_POST['VMethod'];

  $Param = [];                  
  $Res = '';
  if ($VFunction == "GetSpisUserShot"  and $VMethod == "GET"){
    $Res = GenSQL_GetSpisUserShot($Param);
  };
  if ($VFunction == "GetUserFull"  and $VMethod == "GET"){
    $Res = GenSQL_GetUserFull($Param);
  }; 
  if ($VFunction == "UdUser"  and $VMethod == "SET"){
    $Res = SetSQL_UdUser($Param);
  }; 
  if ($VFunction == "GetUserMOO"  and $VMethod == "GET"){
    $Res = GetSQL_GetUserMOO($Param);
  };   
  
  Return $Res;
};

/*************************************************** */
/*************************************************** */

function GenSQL_GetSpisUserShot(&$Param){
  $VSelID = $_POST['VSelID'];
  $Param = [];                  
  $Res = "select " .
	              " TUser.IDUser, " .
	              " TUser.UserNameS, " .
	              " TProfession.ProfName, " .
	              " TOffice.OfName " .
	           " from " .
		              " u198290_blin.TUser " .
		              " left outer join u198290_blin.TProfession on TUser.UserProfID = TProfession.IDProf " .
		              " left outer join u198290_blin.TOffice on TUser.UserOfficeID = TOffice.IDOffice ";
  if ($VSelID > 0) {
    $Param['id'] = $VSelID;
    $Res = $Res . " where IDUser = :id";
  };  
  $Res = $Res . " order by TUser.UserNameS";
  Return $Res;
};

function GenSQL_GetUserFull(&$Param){
  $VSelID = $_POST['VSelID'];
  $Param = [];                  
  $Param['id'] = $VSelID;  
  $sql = "select TUser.UserLogin, TUser.UserNameS, TUser.UserStatus, TUser.UserDateBirth, TUser.UserDateBegin, TUser.UserProfID, TUser.UserOfficeID, TProfession.ProfName, TOffice.OfName \n"
    . "from u198290_blin.TUser \n"
    . " left outer join u198290_blin.TProfession on TUser.UserProfID = TProfession.IDProf \n"
    . " left outer join u198290_blin.TOffice on TUser.UserOfficeID = TOffice.IDOffice \n"
    . "where IDUser = :id "; 
Return $sql;
};

function SetSQL_UdUser(&$Param){
  $Param = [];                  
  $Param['UserName'] = $_POST['VUserName'];
  $Param['UserStatus'] = $_POST['VUserStatus'];
  $Param['UserOfficeID'] = $_POST['VUserOfficeID'];
  $Param['UserProfID'] = $_POST['VUserProfID'];
  $Param['UserDateBirth'] = $_POST['VUserDateBirth'];
  $Param['UserDateBegin'] = $_POST['VUserDateBegin'];
  $Param['IDUser'] = $_POST['VSelID'];

  $sql = " UPDATE u198290_blin.TUser SET \n"
	          ." TUser.UserNameS = :UserName, \n" 
	          ." TUser.UserStatus = :UserStatus, \n"
	          ." TUser.UserOfficeID = :UserOfficeID, \n" 
	          ." TUser.UserProfID = :UserProfID, \n"
	          ." TUser.UserDateBirth = :UserDateBirth, \n"
	          ." TUser.UserDateBegin = :UserDateBegin \n"
	          ." WHERE TUser.IDUser = :IDUser \n";
  Return $sql;
};


function GetSQL_GetUserMOO(&$Param){
  $Param = [];                  
  $Param['IDUser'] = $_POST['VSelID'];

  $sql = "SELECT TMOType.IDMOType, TMOType.MOTName, nvl(TMOObligatory.MOMoObligatory, 0) AS Obligatory, TUser.UserNameS\n"
    . "FROM u198290_blin.TMOType\n"
    . "LEFT OUTER JOIN u198290_blin.TMOObligatory ON TMOType.IDMOType = TMOObligatory.MOMoMOTypeID\n"
    . "LEFT OUTER JOIN u198290_blin.TUser ON (TMOObligatory.MOObUserID = TUser.IDUser and TUser.IDUser = :IDUser)\n"
    . "order by TMOType.MOTOrder";
  Return $sql;
};







/*



try {
  $id = 5;
  $id1 = 4;
  // С использованием именованных псевдопеременных
  $stmt = $pdo->prepare("SELECT IDUser, UserLogin FROM u198290_blin.TUser WHERE IDUser = :id OR IDUser = :id1");
  $stmt->execute(['id' => $id, 'id1' => $id1]);

  while ($user = $stmt->fetch()) {  // Получить одну строку
//    echo json_encode($user);
    echo json_encode($user['IDUser']);
    echo json_encode($user);
	}
  echo "OOOOO";
} catch (Exception $e) {
    echo "ERROR" . $e->getMessage();
} 
    
*/
//Чтение//Чтение//Чтение
//Чтение//Чтение//Чтение
//Чтение//Чтение//Чтение
//Чтение//Чтение//Чтение
///////////////////4. Выборка всех строк
/*
try {
  $id = 5;
  $id1 = 4;

$stmt = $pdo->query("SELECT UserLogin FROM u198290_blin.TUser WHERE IDUser = 5");
//$stmt = $pdo->prepare("SELECT IDUser, UserLogin FROM u198290_blin.TUser WHERE IDUser = :id");

$stmt->execute(['id' => $id]);
//$stmt->execute(['id' => $id, 'id1' => $id1]);

$users = $stmt->fetchAll(); // {Link: Извлечение всех строк, IBM https://www.ibm.com.en2ru.search.translate.goog/docs/SSSNY3_10.1.0/com.ibm.swg.im.dbclient.php.doc/doc/t0023505.html} [9]

foreach ($users as $row) {
    echo $row['UserLogin'] . "\n";
}

} catch (Exception $e) {
    echo "ERROR" . $e->getMessage();
} 
*/


// Или используя PDO::FETCH_OBJ
// $user = $stmt->fetch(PDO::FETCH_OBJ);
// echo $user->name;

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
/********************************************* */


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