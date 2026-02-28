<?php
  if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
    $rows = [["Error", "NotPOST"]]; 
    echo json_encode($rows);
    exit;
  };

  $VNameSpis = $_POST['VNameSpis'];

  $mysql = null;
  $query = null;

  try {
    require "../phpmain.php";    
  
    $mysql = ConnBD();

    $query = 'INSERT INTO TUser(UserNameS, UserProfID, UserOfficeID, UserLogin, UserPassword, UserStatus, 
                                userEnabled, UserDateBirth, UserDateBegin) VALUES 
                                ("'. $_POST['fio'] . '", '. 
	                                 $_POST['prof'] . ', '. 
	                                 $_POST['offi'] . ', '. 
	                            '"' . $_POST['login'] . '", '. 
	                            '"' . $_POST['password'] . '", '. 
	                            '"' . $_POST['status'] . '", '. 
	                            '"Y", '. 
	                            '"' . $_POST['date_birth'] . '", '. 
	                            '"' . $_POST['date_begin'] . '")';

    $res = mysqli_query($mysql, $query);
    if ($res) {
       $rows = [["OK", 0]]; 
    } else {
       $rows = [["Error", $query]]; 
    };
    echo json_encode($rows);

  } catch (Exception $e) {
    $rows = [["Error", "PHP Error", $e->getMessage(), $query]];
    echo json_encode($rows);
  }finally {
    mysqli_close($mysql);
  };   
/////////////////////////////////////////////////////////////////////////////

  function GetQuery($VNameSpis){
    $Res = '';
    switch ($VNameSpis) {
    case "ProfList":
        $Res = 'select TProfession.IDProf, TProfession.ProfName from TProfession order by TProfession.ProfName';
        break; 
    case "OffiLis":
        $Res = 'select TOffice.IDOffice, TOffice.OfName from TOffice order by TOffice.OfName';
        break;
    };
    return $Res;
  };
?>