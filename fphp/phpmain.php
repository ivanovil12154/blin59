<?php
  // Определение констант
  // Константы таблицы TPositions
  define("IDPOS_BOSS",1);
  define("IDPOS_ADMIN",2);
  define("IDPOS_BARIST",3);

  /////////////////////////////////////////////////
  // подключение к БД
  /////////////////////////////////////////////////
  function ConnBD(){
    $link = mysqli_connect('localhost', 'u198290_user', 'user@blin59', 'u198290_blin');
    //'localhost',  /* Хост, к которому мы подключаемся */
    //'user',       /* Имя пользователя */
    //'password',   /* Используемый пароль */
    //'world');     /* База данных для запросов по умолчанию */

  if (!$link) {
    printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
    exit;
  };
  mysqli_set_charset($link, "utf8"); // не знаю зачем ну для чего то нужно
//  echo ($link->host_info . "\n");  // 
  return $link;
  }
  ///////////////////////////////////////////////////
  /////    Проверка логина и пароля
  ///////////////////////////////////////////////////
  function QueryCheckUser($mysql, $vlogin, $vpassword, &$vID, &$vName, &$vStatus){
    $P = md5($vpassword);
    $query = "SELECT IDUser, UserLogin, UserPassword, UserNameS, UserStatus";
    $query .= " FROM  bdschool.TUser ";
    $query .= " WHERE UserLogin='".$vlogin."'";
//    $query .= " and UserPassword='".$vpassword."'";
    $query .= " and UserPass='".$P."'";
    $query .= " and UserEnabled='Y'";
    $res = mysqli_query($mysql, $query);
    $rows = mysqli_num_rows($res); // количество полученных строк
    if ($rows<1){
      return false;
    } else {
      $row = mysqli_fetch_assoc($res);
      $vID = CodeIDUser($row['IDUser']);
      $vName = $row['UserNameS'];
      $vStatus = $row['UserStatus'];
      return true;
    };
  };

  function DeCodeIDUser($VIDUserK, &$VIDUser){
    session_start();    
    $arr = explode(".", $_SERVER['REMOTE_ADDR']);
    $k = intdiv(abs(crc32($_SERVER['HTTP_USER_AGENT'])), $arr[0]);
    $k += intdiv(abs(crc32($_SERVER['REMOTE_ADDR'])), $arr[1]);
    $k += intdiv(abs(crc32($_SESSION['reqtim'])), $arr[2]);
    $k += intdiv(abs(crc32($_SESSION['dattim'])), $arr[3]);
    session_write_close();     




    $CountKSH =  mb_substr($VIDUserK,0,1,'UTF-8');
    $CountKS = hexdec($CountKSH);
    $ResKSH = mb_substr($VIDUserK,1,$CountKS,'UTF-8');
    $ResKIDH = mb_substr($VIDUserK,1+$CountKS,300,'UTF-8');
    $ResKS = hexdec($ResKSH);
    $ResKID = hexdec($ResKIDH);
    $ID = $ResKID - $k;
    $KontKS = crc32($ResKID+$ID);
    if ($ResKS == $KontKS){
      $VIDUser = $ID;
      return true;
    } else {
      $VIDUser = 0;
      return false;
    };
  };


  function CodeIDUser($VIDUser){
    $resIDUser = '$lsrs.$resks.dechex($k)';

    session_start();    
    $_SESSION['reqtim'] = $_SERVER['REQUEST_TIME'];
    $_SESSION['dattim'] = date("Y-m-d H:i:s");

    $arr = explode(".", $_SERVER['REMOTE_ADDR']);

    $k = intdiv(abs(crc32($_SERVER['HTTP_USER_AGENT'])), $arr[0]);
    $k += intdiv(abs(crc32($_SERVER['REMOTE_ADDR'])), $arr[1]);
    $k += intdiv(abs(crc32($_SESSION['reqtim'])), $arr[2]);
    $k += intdiv(abs(crc32($_SESSION['dattim'])), $arr[3]);
    $k += $VIDUser;

    $resks = dechex(crc32($k+$VIDUser));

    $lsrs = dechex(mb_strlen($resks,'UTF-8'));

    $resIDUser = $lsrs.$resks.dechex($k);
    session_write_close();     
    return $resIDUser;
  }






  ///////////////////////////////////////////////////
  /////    Получение списка школ
  ///////////////////////////////////////////////////

  function QueryGetSpisSchool($mysql, $vIDSchool){
    $query = "SELECT IDSchool, SchName FROM bdschool.TSchool ORDER BY SchName";
    
    //$query .= "WHERE IDUser=".$vIDUser;
    //echo('<br>'.$query);
    $res = mysqli_query($mysql, $query);
//    $rows = mysqli_num_rows($res); // количество полученных строк
    return $res;
  };

  function SetRowToSelectSchool($res) {
    while($row = mysqli_fetch_assoc($res)){    
      echo ('    <option value="'.$row['IDSchool'].'">'.$row['SchName'].' </option>');
    }
  };

  




  ///////////////////////////////////////////////////
  /////    Получение списка учиников  по IDUser
  ///////////////////////////////////////////////////
/*
  function QueryGetSpisStud($mysql, $vIDUser){
    $query = "SELECT IDStudent, IDClass, ClsName, IDSchool, SchName ";
    $query .= "FROM bdschool.TStudent ";
    $query .= "LEFT OUTER JOIN bdschool.TUser on StdUserID=IDUser ";
    $query .= "LEFT OUTER JOIN bdschool.TClass on StdClassID=IDClass ";
    $query .= "LEFT OUTER JOIN bdschool.TSchool on ClsSchoolID=IDSchool ";
    $query .= "WHERE IDUser=".$vIDUser;
    //echo('<br>'.$query);
    $res = mysqli_query($mysql, $query);
//    $rows = mysqli_num_rows($res); // количество полученных строк
    return $res;
  }
  function QueryGetSpisStudStr($res){
    while($row = mysqli_fetch_assoc($res)){
      $str ="Учащийся ".$row['SchName']." класс ".$row['ClsName'];
      $strparam = $row['IDStudent'].', '.$row['IDClass'];
      $strparam .= ", '".$row["ClsName"]."', ";
      $strparam .=$row['IDSchool'].", '".$row['SchName']."', 0, ''";
    //    echo($strparam);
      echo('<br><input type="button" onclick="funsendstudent('.$strparam.')" value="'.$str.'">');
        //"SELECT IDStudent, IDClass, ClsName, IDSchool, SchName ";
    };
  }

  */
  ///////////////////////////////////////////////////
  /////    Получение списка администраторов школ
  ///////////////////////////////////////////////////


  /*
  function QueryGetSpisAdminSchool($mysql, $vIDUser){
    $query = "SELECT IDSchool, SchName ";
    $query .= " FROM bdschool.TAdminSchool ";
    $query .= " LEFT OUTER JOIN bdschool.TUser on ASUserID=IDUser ";
    $query .= " LEFT OUTER JOIN bdschool.TSchool on ASSchoolID=IDSchool ";
    $query .= " WHERE IDUser=".$vIDUser;
    $query .= " ORDER BY SchName";
    //echo('<br>'.$query);
    $res = mysqli_query($mysql, $query);
//    $rows = mysqli_num_rows($res); // количество полученных строк
    return $res;
  };
*/

/*
  function QueryGetSpisAdminSchoolButoom($res){
    while($row = mysqli_fetch_assoc($res)){
      $str ="Администратор учебного заведения - ".$row['SchName'];
      $strparam = $row['IDSchool'].', '.$row['SchName'];
      $strparam = $row['IDSchool'].", '".$row['SchName']."', 0, ''";

    //    echo($strparam);
      echo('<br><input type="button" onclick="FunSendAdminClass('.$strparam.')" value="'.$str.'">');
    };
  };

  */
  ///////////////////////////////////////////////////
  /////    Получение списка администраторов класса
  ///////////////////////////////////////////////////
/*
  function QueryGetSpisAdminClass($mysql, $vIDUser){
    $query = "SELECT IDSchool, SchName, IDClass, ClsName ";
    $query .= " FROM bdschool.TAdminClass ";
    $query .= " LEFT OUTER JOIN bdschool.TUser on ACUserID=IDUser ";
    $query .= " LEFT OUTER JOIN bdschool.TClass on AСClassID=IDClass ";
    $query .= " LEFT OUTER JOIN bdschool.TSchool on ClsSchoolID=IDSchool ";
    $query .= " WHERE IDUser=".$vIDUser;
    $query .= " ORDER BY SchName, ClsName";
    ///echo('<br>'.$query);
    $res = mysqli_query($mysql, $query);
//    $rows = mysqli_num_rows($res); // количество полученных строк
    return $res;
  }
  function QueryGetSpisAdminClassButoom($res){
    while($row = mysqli_fetch_assoc($res)){
      $str ="Администратор школы - ".$row['SchName']." класса - ".$row['ClsName'];
      $strparam = $row['IDSchool'].", '".$row['SchName']."', ".$row['IDClass'].", '".$row['ClsName']."'";
      echo($strparam);
      echo('<br><input type="button" onclick="FunSendAdminClass('.$strparam.')" value="'.$str.'">');
    };
  }
*/
  ///////////////////////////////////////////////////
  /////    Получение списка преподователей
  ///////////////////////////////////////////////////


/*
  function QueryGetSpisPrepd($mysql, $vIDUser){
    $query = "SELECT IDSchool, SchName, IDPredmetSpis, PdSpNameS ";
    $query .= " FROM bdschool.TPredmet ";
    $query .= " LEFT OUTER JOIN bdschool.TUser on PdUserID=IDUser ";
    $query .= " LEFT OUTER JOIN bdschool.TClass on PdClassID=IDClass ";
    $query .= " LEFT OUTER JOIN bdschool.TSchool on ClsSchoolID=IDSchool ";
    $query .= " LEFT OUTER JOIN bdschool.TPredmetSpis on PdPredmetSpID=IDPredmetSpis ";
    $query .= " WHERE IDUser=".$vIDUser;
    $query .= " GROUP BY IDSchool, SchName, IDPredmetSpis, PdSpNameS ";
    $query .= " ORDER BY SchName, PdSpNameS ";
    
    ///echo('<br>'.$query);
    $res = mysqli_query($mysql, $query);
//    $rows = mysqli_num_rows($res); // количество полученных строк
    return $res;
  }

  function QueryGetSpisPrepdStr($res){
    while($row = mysqli_fetch_assoc($res)){
      $str ="Преподователь школы - ".$row['SchName']." предмет - ".$row['PdSpNameS'];
      $strparam = $row['IDSchool'].", '".$row['SchName']."', ".$row['IDPredmetSpis'].", '".$row['PdSpNameS']."'";
      echo($str);
      echo($strparam);
      echo('<br><input type="button" onclick="FunSendPrepod('.$strparam.')" value="'.$str.'">');
    };
  }

*/











  // выполнение запроса для списка сотрудников
  function QueryAut($mysql){
    $query = "select IDStaff, StSurname, StName, StPatronymic ";        // 
    $query .= " FROM bdsweetjoy.TStaff";
    $query .= " where StPassword != ''";                             // условия если есть пароль 
    $query .= " and StExOrCurrent = 'E'";                             // условия если есть пароль 
    $query .= " order by StSurname, StName, StPatronymic";           // отсортировать     
    $res = mysqli_query($mysql, $query);
    $rows = mysqli_num_rows($res); // количество полученных строк
    if ($rows<1){
        print("Нет персонала");
        exit;
    };
    return $res;
  }

  // последовательная выборка и заполнения тега select
  function SetRowToSelect($res) {
    while($row = mysqli_fetch_assoc($res)){    
            // предлагаю не использовать профисиональную вставку в данном случае черезчур громозко    
      echo ('    <option value="'.$row['IDStaff'].'">'.$row['StSurname'].' '.$row['StName'].' '.$row['StPatronymic'].' </option>');
    }
  };


  // проверка пароля для пользователя
  function CheckPassword($mysql, $iduser, $pass){
    $query = "select IDStaff, StSurname, StName, StPatronymic, StPositionsID".   
                         " FROM bdsweetjoy.TStaff".
                         " where IDStaff=".$iduser." and StPassword = ".$pass;                         
    $res = mysqli_query($mysql, $query);
    $rows = mysqli_num_rows($res); // количество полученных строк
    if ($rows=0){
      return false;
    } else {
      $row = mysqli_fetch_assoc($res);
      return $row;
    };
    
  };


  function querypositionsspis($mysql){
    $query = "SELECT IDPositions, PosName FROM TPositions";
    return mysqli_query($mysql, $query);
  };



  function queryclient($mysql, $IDCL){
    $query = "SELECT IDClients, ClSurname, ClName, ClPatronymic, ClTelNumber FROM bdsweetjoy.TClients ";   
    if ($IDCL<>''){
      $query .= " where IDClients = ".$IDCL;   
    };
    $query .= " order by  ClSurname, ClName";   
    // echo ($query);
    $res = mysqli_query($mysql, $query);
    $rows = mysqli_num_rows($res); // количество полученных строк

    // echo ("Количество строк-".$rows);
    if ($rows==0){
      // echo ("Количество строк-bb".$rows);
      return false;
    } else {
      // echo ("Количество строк-bbbb".$rows);
      return $res;
    };

  }


  function GetKoffClient($mysql, $idclient){
    // echo ("запрос <br>");
    $query = "SELECT sum(`GdQuantity`) as `countk`";
    $query .= " FROM `TOrder` ";
    $query .= " left outer JOIN `TGoods` on `IDOrder`=`GdOrderID`";
    $query .= " left outer JOIN `TProduct` on `GdProductid`=`IDProduct`";
    $query .= " where `OrClientsId`=".$idclient;
    $query .= " and `PrStatus`='K'";
    // echo ("query - ".$query."запрос <br>");

    $res = mysqli_query($mysql, $query);
    if (mysqli_num_rows($res)==0){
      return 0;
    } else {
      $row = mysqli_fetch_assoc($res);
      return $row['countk'];
    }
  };

  function queryorderspis($mysql){
    $query = "SELECT IDClients, ClSurname, ClName, ClPatronymic, ClTelNumber, "; 
    $query .=" IDOrder, OrDate, ";
    $query .=" GdQuantity, GdPrice, ";
    $query .=" PrName";
    $query .=" FROM TOrder ";
    $query .=" LEFT OUTEr JOIN TGoods on IDOrder=GdOrderId ";
    $query .=" LEFT OUTEr JOIN TProduct on GdProductId=IDProduct ";
    $query .=" LEFT OUTEr JOIN TClients on IDClients=OrClientsId ";
    $query .=" order by OrDate ";
    $res = mysqli_query($mysql, $query);
    return $res;
  };

  function querystaffspis($mysql){
    $query = "SELECT IDStaff, StSurname, StName, StPatronymic, StSex, StTelNumber, StDOB, StExOrCurrent, StPositionsID, StPassword, PosName";
    $query .= " FROM TStaff";
    $query .= " LEFT OUTER JOIN TPositions on StPositionsID=IDPositions";
    $query .= " order by StSurname, StName, StPatronymic";
    // echo ("-----------".$query."-----------<br>");
    $res = mysqli_query($mysql, $query);
    return  $res;
  };


  function querystaffonly($mysql, $idstaff){
    $query = "SELECT IDStaff, StSurname, StName, StPatronymic, StSex, StTelNumber, StDOB, StExOrCurrent, StPositionsID, StPassword";
    $query .= " FROM TStaff";
    $query .= " where IDStaff=".$idstaff;
    // echo ("-----------".$query."-----------<br>");
    $res = mysqli_query($mysql, $query);
    return mysqli_fetch_assoc($res);
  };  

  function queryfirms($mysql){
    $query = "SELECT IDFirm, FmName, FmAddr, FmTel, FmEmail, FmBossFIO FROM TFirms";
    $res = mysqli_query($mysql, $query);
    return mysqli_fetch_assoc($res);
  };


  function queryproductspis($mysql){
    $query = "SELECT IDProduct, PrName, PrPrice, PrStatus FROM bdsweetjoy.TProduct order by PrName";   
    $res = mysqli_query($mysql, $query);
    $rows = mysqli_num_rows($res); // количество полученных строк
    // echo ("Количество строк-".$rows);
    if ($rows=0){
      return false;
    } else {
      return $res;
    };
  };
  //echo "<link rel='stylesheet' href='../css/style_order.css'>";
  function SetRowProductADDToSelect($res) {
    while($row = mysqli_fetch_assoc($res)){    
            // предлагаю не использовать профисиональную вставку в данном случае черезчур громозко    
      echo('<label class ="label" >'.$row['PrName'].' ('.$row['PrPrice'].') '.'</label>');
      echo('<input class ="namber" type="number" name="count_idpr'.$row['IDProduct'].'"><br>');
    };
  };



  // закрыть полкдючение к БД и освобождение памяти 
  function CloseBD($mysql, $res){
    mysqli_free_result($res);
    mysqli_close($mysql);
  };

  // запрос процедуры для вычесления IDOrder
  function GetIDOrder($mysql){
    $query=("SET @ido = ''; CALL proc1(@ido); SELECT @ido as _p_out");
    $res = mysqli_multi_query($mysql,$query);
    if (!$res){
      echo ("Ошибка запроса <br>");
      exit;
    };
    if (!mysqli_next_result($mysql)){
      echo("ошибка 3<br>");
      exit;
    };
    if (!mysqli_next_result($mysql)){
      echo("ошибка 4<br>");
      exit;
    };
    $result3 = mysqli_store_result($mysql);
    // echo ("количестов строк3-".mysqli_num_rows($result3)."<br>");
    $row = mysqli_fetch_assoc($result3);
    // echo ("resultat3-".$row['_p_out']."<br>");
    return $row['_p_out'];
  };



?>
