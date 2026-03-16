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
  
  $Param = [];
  $ResARRAY = [];
  $rows = [];  

  $ResQuery = GenSQL($Param, $ResARRAY);

  if ($ResQuery == ''){
    $rows = [["ERROR", "NotMethod", $VFunction, $VMethod]];
    echo json_encode($rows);
    exit;
  };

  if ($ResQuery == "ERROR"){
    $rows = [["ERROR", "Error", $VFunction, $VMethod]];
    echo json_encode($rows);
    exit;
  }

  try{
    $pdo = ConnectPDO();
    if ($ResQuery != "ARRAY") {    
      $stmt = $pdo->prepare($ResQuery);
      if ($Param != null) {
        $stmt->execute($Param);
      } else {
        $stmt->execute([]);
      };
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
    } else {
      $resrow = [];
      $countOK = 0;
      foreach ($ResARRAY as $ResSet) {
        $resrow = [];
        $stmt = $pdo->prepare($ResSet["query"]);
        if ($ResSet["param"] != null) {
          $stmt->execute($ResSet["param"]);
        } else {
          $stmt->execute([]);
        };
        $count = $stmt->rowCount();
        if ($VMethod == "INSERT"){
          $lastId = $pdo->lastInsertId();
          array_push($resrow, ["OK", $count, $lastId]);
        } else {
          array_push($resrow, ["OK", $count]);
        };      
        if ($VMethod == "GET") {
          while ($row = $stmt->fetch()) {  // Получить одну строку
             if (array_key_exists('DATA1', $row)){
               $row["DATA"] = base64_encode($row["DATA1"]);
               $row["DATA_SIZE"] = strlen($row["DATA"]);

               unset($row["DATA1"]); // Удаление элемента из массива
             };
             array_push($resrow, $row);

          };   
        };  
        array_push($rows, $resrow);
      };
    }  
    echo json_encode($rows);
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

function GenSQL(&$Param, &$ResARRAY){
  $VFunction = $_POST['VFunction'];
  $VMethod = $_POST['VMethod'];

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

  if ($VFunction == "UdMOO"  and $VMethod == "SET"){
    $Res = SetSQL_UdMOO($Param, $ResARRAY);
  };   
  if ($VFunction == "GetMOTypeList"  and $VMethod == "GET"){
    $Res = GetMOTypeList($Param, $ResARRAY);
  };   

  if ($VFunction == "ADDMO"  and $VMethod == "SET"){
    $Res = SetSQL_ADDMO($Param, $ResARRAY);
  };   
  if ($VFunction == "ShowMOList"  and $VMethod == "GET"){
    $Res = GetSQL_ShowMOList($Param, $ResARRAY);
  };   
/*  if ($VFunction == "ShowMOZad"  and $VMethod == "GET"){
    $Res = GetSQL_ShowMOZad($Param, $ResARRAY);
  };   */
  if ($VFunction == "MOOverdueList"  and $VMethod == "GET"){
    $Res = GetSQL_MOOverdueList($Param, $ResARRAY);
  };   

  if ($VFunction == "SaveFile"  and $VMethod == "SET"){
    $Res = GetSQL_SaveFile($Param, $ResARRAY);
  };   

  if ($VFunction == "SaveFile"  and $VMethod == "SET"){
    $Res = GetSQL_SaveFile($Param, $ResARRAY);
  };   

  if ($VFunction == "FileList"  and $VMethod == "GET"){
    $Res = GetSQL_FileList($Param, $ResARRAY);
  };   

  if ($VFunction == "LoadFileOnly"  and $VMethod == "GET"){
    $Res = GetSQL_LoadFileOnly($Param, $ResARRAY);
  };   
  if ($VFunction == "Test"  and $VMethod == "INSERT"){
    $Res = GetSQL_InsetTest($Param, $ResARRAY);
  };   
  if ($VFunction == "SaveFileMain"  and $VMethod == "INSERT"){
    $Res = GetSQL_InsetSaveFileMain($Param, $ResARRAY);
  };   
  if ($VFunction == "SaveFileData"  and $VMethod == "INSERT"){
    $Res = GetSQL_InsetSaveFileData($Param, $ResARRAY);
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
  $Param['IDUserr'] = $_POST['VSelID'];
  $sql = "SELECT TMOType.IDMOType, TMOType.MOTName, nvl(TMOObligatory.MOMoObligatory, 0) AS Obligatory, TUser.UserNameS\n"
    . "FROM u198290_blin.TMOType\n"
    . "LEFT OUTER JOIN u198290_blin.TMOObligatory ON (TMOType.IDMOType = TMOObligatory.MOMoMOTypeID  and TMOObligatory.MOObUserID = :IDUser)\n"
    . "LEFT OUTER JOIN u198290_blin.TUser ON (TMOObligatory.MOObUserID = TUser.IDUser or TUser.IDUser = :IDUserr)\n"
    . "order by TMOType.MOTOrder";
  Return $sql;
};


function SetSQL_UdMOO(&$Param, &$ResARRAY){
  $ResData = $_POST["VData"];
  $ResMas = json_decode($ResData, false);
  $i = 0;
  foreach ($ResMas as $ResRow) {
    if ($i == 0 ){
      unset($para);
      $sql = "DELETE FROM u198290_blin.TMOObligatory WHERE MOObUserID = :UserID";
      $para['UserID'] = $ResRow[2];
      $i = 1;
      array_push($ResARRAY, array("query" => $sql, "param" =>$para));
    };
    $sql = "INSERT INTO u198290_blin.TMOObligatory (MOObUserID, MOMoMOTypeID, MOMoObligatory) VALUES (:UserID, :TypeID, :Oblig)";
    unset($para);
    $para['UserID'] = $ResRow[2];
    $para['TypeID'] = $ResRow[0];
    $para['Oblig'] = $ResRow[1];
    array_push($ResARRAY, array("query" => $sql, "param" =>$para));
  };  
  return "ARRAY";
};  

function SetSQL_ADDMO(&$Param, &$ResARRAY){
  $sql = "INSERT INTO u198290_blin.TMOReestr(MOReUserID, MOReMOTypeID, MOReDateFrom, MOReDateTo, MOReAuthorUserID, MOReDopInf)  VALUES " .
    "(:UserID, :MOTypeID, :DateFrom, :DateTo, :AutorUserID, :DopInf)";
  $para['UserID'] = $_POST["VSelID"];
  $para['MOTypeID'] = $_POST["VMOType"];
  $para['DateFrom'] = $_POST["VDateFrom"];
  $para['DateTo'] = $_POST["VDateTo"];
  $para['AutorUserID'] = $_POST["VID"];
  $para['DopInf'] = $_POST["VDopInf"];
  array_push($ResARRAY, array("query" => $sql, "param" =>$para));
  return "ARRAY";
};


function GetMOTypeList(&$Param, &$ResARRAY){
  $Res = "SELECT TMOType.IDMOType AS f_id, TMOType.MOTName AS f_name, MOTPeriodMon, MOTOnlyLife, MOTOnlyBegin " .
    "FROM u198290_blin.TMOType ORDER BY TMOType.MOTOrder";
  return $Res;
};


function GetSQL_ShowMOList(&$Param, &$ResARRAY){
  $para['MOReUserID'] = $_POST["VSelID"];
  $sql = "SELECT re.IDMOReestr, re.MOReDateFrom, re.MOReDateTo, re.MOReDopInf, re.MOReDateInser, mot.MOTName, usa.UserNameS \n"
    . "FROM u198290_blin.TMOReestr re\n"
    . "LEFT JOIN u198290_blin.TMOType mot ON re.MOReMOTypeID = mot.IDMOType\n"
    . "LEFT JOIN u198290_blin.TUser usa ON re.MOReAuthorUserID = usa.IDUser\n"
    . "WHERE re.MOReUserID = :MOReUserID\n"
    . "ORDER BY re.MOReDateFrom DESC"
    ;
  array_push($ResARRAY, array("query" => $sql, "param" =>$para));
  return "ARRAY";
};
/*
function GetSQL_ShowMOZad(&$Param, &$ResARRAY){



   $sql = " SELECT T.IDUser, T.UserNameS, T.IDMOType, T.MOTName, T.MOAV, T.MODONE, TIMESTAMPDIFF(MONTH, T.MODONE, CURDATE()) as TTTT ".
         " FROM  ".
         " (SELECT TUser.IDUser, TUser.UserNameS, TMOType.IDMOType, TMOType.MOTName, TMOType.MOTPeriodMon AS MOAV,  ".
         " nvl((SELECT TMOReestr.MOReDateTo  ".
         " FROM TMOReestr  ".
         " WHERE TMOReestr.MOReUserID = TUser.IDUser  ".
         " AND TMOReestr.MOReMOTypeID = TMOType.IDMOType  ".
         " ORDER BY MOReDateTo DESC  ".
         " LIMIT 1  ".
         " ), STR_TO_DATE('1900-01-01', '%Y-%m-%d')) AS MODONE  ".
         " FROM TMOType ".
         " INNER JOIN TMOObligatory ON TMOType.IDMOType = TMOObligatory.MOMoMOTypeID ".
         " INNER JOIN TUser ON TMOObligatory.MOObUserID = TUser.IDUser ".
         " WHERE TMOType.MOTPeriodMon > 0) T ".
         " WHERE TIMESTAMPDIFF(MONTH, T.MODONE, CURDATE()) > -2 ".
         " ORDER BY TTTT DESC ";


$para['MOReUserID'] = $_POST["VSelID"];
  $sql = "SELECT re.IDMOReestr, re.MOReDateFrom, re.MOReDateTo, re.MOReDopInf, re.MOReDateInser, mot.MOTName, usa.UserNameS \n"
    . "FROM u198290_blin.TMOReestr re\n"
    . "LEFT JOIN u198290_blin.TMOType mot ON re.MOReMOTypeID = mot.IDMOType\n"
    . "LEFT JOIN u198290_blin.TUser usa ON re.MOReAuthorUserID = usa.IDUser\n"
    . "WHERE re.MOReUserID = :MOReUserID\n"
    . "ORDER BY re.MOReDateFrom DESC"
    ;
  array_push($ResARRAY, array("query" => $sql, "param" =>$para));
  return "ARRAY";
};
*/

function GetSQL_MOOverdueList(&$Param, &$ResARRAY){
  $VSerchFio = $_POST["VSerchFio"];
  $VSerchOffi = $_POST["VSerchOffi"];
  $VSerchMOT = $_POST["VSerchMOT"];
  $para = [];

  if ($VSerchFio != ''){
    $para['VSerchFio'] = "%". $VSerchFio . "%";
  };
  if ($VSerchOffi != ''){
    $para['VSerchOffi'] = "%". $VSerchOffi . "%";
  };
  if ($VSerchMOT != ''){
    $para['VSerchMOT'] = "%". $VSerchMOT . "%";
  };

  $sql = "SELECT TUser.IDUser, TUser.UserNameS, TOffice.OfName, TMOType.IDMOType, TMOType.MOTName, TMOType.MOTOnlyLife AS MOAV, \n"  
  ." (SELECT COUNT(*) FROM u198290_blin.TMOReestr WHERE TMOReestr.MOReUserID = TUser.IDUser AND TMOReestr.MOReMOTypeID = TMOType.IDMOType) AS MODONE \n"  
  ." FROM u198290_blin.TMOType \n"  
  ." INNER JOIN u198290_blin.TMOObligatory ON TMOType.IDMOType = TMOObligatory.MOMoMOTypeID \n"  
  ." INNER JOIN u198290_blin.TUser ON TMOObligatory.MOObUserID = TUser.IDUser \n"  
  ." INNER JOIN u198290_blin.TOffice ON TUser.UserOfficeID = TOffice.IDOffice \n"  
  ." WHERE MOTOnlyLife > 0 and TMOObligatory.MOMoObligatory = 1 \n";
  if ($VSerchFio != ''){
    $sql = $sql . " AND TUser.UserNameS like :VSerchFio \n";
  };
  if ($VSerchOffi != ''){
    $sql = $sql . " AND TOffice.OfName like :VSerchOffi \n";
  };
  if ($VSerchMOT != ''){
    $sql = $sql . " AND TMOType.MOTName like :VSerchMOT \n";
  };
  $sql = $sql . " HAVING MOAV > MODONE \n"  
  ." ORDER BY (MOAV - MODONE) \n";  
  array_push($ResARRAY, array("query" => $sql, "param" =>$para));

  $sql = "SELECT TUser.IDUser, TUser.UserNameS, TOffice.OfName, TMOType.IDMOType, TMOType.MOTName, TMOType.MOTOnlyBegin AS MOAV, \n"  
  ." (SELECT COUNT(*) FROM u198290_blin.TMOReestr WHERE TMOReestr.MOReUserID = TUser.IDUser AND TMOReestr.MOReMOTypeID = TMOType.IDMOType) AS MODONE \n"  
  ." FROM u198290_blin.TMOType \n"  
  ." INNER JOIN u198290_blin.TMOObligatory ON TMOType.IDMOType = TMOObligatory.MOMoMOTypeID \n"  
  ." INNER JOIN u198290_blin.TUser ON TMOObligatory.MOObUserID = TUser.IDUser \n"  
  ." INNER JOIN u198290_blin.TOffice ON TUser.UserOfficeID = TOffice.IDOffice \n"  
  ." WHERE TMOType.MOTOnlyBegin > 0 and TMOObligatory.MOMoObligatory = 1\n";  
  if ($VSerchFio != ''){
    $sql = $sql . " AND TUser.UserNameS like :VSerchFio \n";
  };
  if ($VSerchOffi != ''){
    $sql = $sql . " AND TOffice.OfName like :VSerchOffi \n";
  };
  if ($VSerchMOT != ''){
    $sql = $sql . " AND TMOType.MOTName like :VSerchMOT \n";
  };
  $sql = $sql . " HAVING MOAV > MODONE \n"  
  ." ORDER BY (MOAV - MODONE) DESC \n";  
  array_push($ResARRAY, array("query" => $sql, "param" =>$para));

  $sql = "SELECT T.IDUser, T.UserNameS, T.IDMOType, T.MOTName, \n"  
  ." T.OfName,  \n" 
  ." T.MOAV, T.MODONE, TIMESTAMPDIFF(MONTH, T.MODONE, CURDATE()) as TTTT \n"  
  ." FROM  \n"  
  ." (SELECT TUser.IDUser, TUser.UserNameS, TMOType.IDMOType, TMOType.MOTName, TMOType.MOTPeriodMon AS MOAV,   \n" 
  ." TOffice.OfName,  \n" 
  ." nvl((SELECT TMOReestr.MOReDateTo  \n"  
   ." FROM u198290_blin.TMOReestr  \n"  
   ." WHERE TMOReestr.MOReUserID = TUser.IDUser  \n"  
   ." AND TMOReestr.MOReMOTypeID = TMOType.IDMOType \n"  
   ." ORDER BY MOReDateTo DESC \n"  
   ." LIMIT 1 \n"  
  ." ), STR_TO_DATE('1900-01-01', '%Y-%m-%d')) AS MODONE, \n"  
  ." nvl(TUser.IDUser, 123123) \n"  
  ." FROM u198290_blin.TMOType \n"  
  ." INNER JOIN u198290_blin.TMOObligatory ON TMOType.IDMOType = TMOObligatory.MOMoMOTypeID \n"  
  ." INNER JOIN u198290_blin.TUser ON TMOObligatory.MOObUserID = TUser.IDUser \n"  
  ." INNER JOIN u198290_blin.TOffice ON TUser.UserOfficeID = TOffice.IDOffice \n"  
  ." WHERE TMOType.MOTPeriodMon > 0  and TMOObligatory.MOMoObligatory = 1) T \n"  
  ." WHERE TIMESTAMPDIFF(MONTH, T.MODONE, CURDATE()) > -2 \n";  
  if ($VSerchFio != ''){
    $sql = $sql . " AND T.UserNameS like :VSerchFio \n";
  };
  if ($VSerchOffi != ''){
    $sql = $sql . " AND T.OfName like :VSerchOffi \n";
  };
  if ($VSerchMOT != ''){
    $sql = $sql . " AND T.MOTName like :VSerchMOT \n";
  };
  $sql = $sql . " ORDER BY TTTT DESC \n";  
  $Par = [];  
  array_push($ResARRAY, array("query" => $sql, "param" =>$para));
  return "ARRAY";
};

function GetSQL_SaveFile(&$Param, &$ResARRAY){
  if ($_FILES['VFileData']['error'] === UPLOAD_ERR_OK) {
    // 1. Получаем бинарные данные файла
    $fileData = file_get_contents($_FILES['VFileData']['tmp_name']);
    $fileName = $_FILES['VFileData']['name'];
    $fileSize = $_FILES['VFileData']['size'];    

    $sql = "INSERT INTO u198290_blin.TFiles(FileAutorID, FileDesc, FileName, FileSize, FilePrivilege, FileData)\n"  
        ." VALUES (:FUserID, :FDesc, :FName, :FSize, :FPrivilege, :FData)";

    $para['FUserID'] = $_POST["VID"];
    $para['FDesc'] = $_POST["VDesc"];
    $para['FName'] = $fileName;
    $para['FSize'] = $fileSize;
    $para['FPrivilege'] = $_POST["VPrivilege"];
//    $para['FData'] = base64_encode($row["DATA1"]);$fileData;
    $para['FData'] = base64_encode($fileData);
    
    array_push($ResARRAY, array("query" => $sql, "param" =>$para));
/************************************************************************/
    $blobData = base64_encode($fileData);
    $chunkSize = 1024 * 50; // Размер части в байтах
    $chunks = str_split($blobData, $chunkSize);

    foreach ($chunks as $index => $chunk) {
      $p=[];
        // Обработка части $chunk
        file_put_contents("part_" . $index . ".bin", $chunk);
    };




    return "ARRAY";
  }else{
    return "ERROR";
  };
};

function GetSQL_FileList(&$Param, &$ResARRAY){
  $para = [];
  $sql = "SELECT TFiles.IDFile, TFiles.FileAutorID, TFiles.FileDesc, TFiles.FileName, TFiles.FileSize, TFiles.FilePrivilege, TFiles.FileDateCreate, TUser.UserNameS \n"
      . "FROM u198290_blin.TFiles \n"
      . "INNER JOIN u198290_blin.TUser ON TFiles.FileAutorID = TUser.IDUser\n"
      . "Order by TFiles.FileDateCreate, TFiles.IDFile\n";
    array_push($ResARRAY, array("query" => $sql, "param" =>$para));
    return "ARRAY";
};

function GetSQL_LoadFileOnly(&$Param, &$ResARRAY){
  $para['IDFile'] = $_POST["VIDFile"];
  $sql = "SELECT TFileData.FDData, TFiles.FileName \n"
        ."FROM u198290_blin.TFiles \n"
        ."INNER JOIN u198290_blin.TFileData ON TFiles.IDFile = TFileData.FDFileID  \n"
        ."WHERE TFiles.IDFile =:IDFile \n"
        ."ORDER BY TFileData.IDFileData \n";
  array_push($ResARRAY, array("query" => $sql, "param" =>$para));
  return "ARRAY";
};


function GetSQL_InsetTest(&$Param, &$ResARRAY){
  $sql = "INSERT INTO u198290_blin.TOffice(OfName, OfAddr) VALUES (:OfName, :OfAddr)";
  $para['OfName'] = "Проба";
  $para['OfAddr'] = "Проба";
  array_push($ResARRAY, array("query" => $sql, "param" =>$para));
  return "ARRAY";
}

function GetSQL_InsetSaveFileMain(&$Param, &$ResARRAY){
    $sql = "INSERT INTO u198290_blin.TFiles(FileAutorID, FileDesc, FileName, FileSize, FilePrivilege)\n"  
        ." VALUES (:FUserID, :FDesc, :FName, :FSize, :FPrivilege)";

    $para['FUserID'] = $_POST["VID"];
    $para['FDesc'] = $_POST["VDesc"];
    $para['FName'] = $_POST["VFileName"];
    $para['FSize'] = $_POST["VFileSize"];
    $para['FPrivilege'] = $_POST["VPrivilege"];
    
    array_push($ResARRAY, array("query" => $sql, "param" =>$para));
    return "ARRAY";
};

function GetSQL_InsetSaveFileData(&$Param, &$ResARRAY){
    $sql = "INSERT INTO u198290_blin.TFileData(FDFileID, FDData)\n"  
        ." VALUES (:FDFileID, :FDData)";
    $para['FDFileID'] = $_POST["VFileID"];
    $para['FDData'] = $_POST["VFileData"];
    
    array_push($ResARRAY, array("query" => $sql, "param" =>$para));
    return "ARRAY";
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