<?php
  if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
    echo ("ErrorP");
    exit;
  };

  $VNameSpis = $_POST['VNameSpis'];

  $mysql = null;
  $query = null;

  $query = GetQuery($VNameSpis);

  if ($query == ''){
//  if (true){
    $rows = [["Error", "Not query", $VNameSpis, $query]];
    echo json_encode($rows);
    exit;
  };

  try {
    require "../phpmain.php";    
  
    $mysql = ConnBD();

    $res = mysqli_query($mysql, $query);
    $rows = mysqli_num_rows($res); // количество полученных строк
    if ($rows < 1){
      $rows = ["OK", 0];
    } else {
      $rows = [["OK", $rows, $VNameSpis, $query]];
//      $rows = [["Error", "Not query", $VNameSpis, $query]];
      while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        array_push($rows, $row);
      };
    };
    echo json_encode($rows);

  } catch (Exception $e) {
    $rows = [["Error", "PHP Error", $e->getMessage()]];
    echo json_encode($rows);
  }finally {
    mysqli_close($mysql);
  };   


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