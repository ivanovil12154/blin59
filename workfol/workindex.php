<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_main.css">
    <link rel="stylesheet" href="../css/style_work.css">
    <title>Работа</title>
</head>

<body>
<?php
  $UserName = 'Bdf';
  require "../fphp/phpmain.php";    
//  require "../fphp/AdminBDMainFun.php";    
  $mysql = ConnBD();

  session_start();
  $IDUser = $_SESSION['idusert']; 
  $UserName = $_SESSION['username']; 
  $_SESSION['stwork'] = 'adminbd';
  session_write_close(); 
  echo ("<script> let LIDUser=".$IDUser."; let LUserName='".$UserName."' </script>");
 ?>

<div class="header">
    <?php
          echo('<p>Администратор БД - '.$UserName.'</p>');
    ?>    
    <div class="custom-button" role="button" tabindex="0" onclick="document.location.href = 'ident.php'">
        Войти
    </div>
</div>
<div class="wmain">
    <div class="wmain_left">
        <div class="custom-button" role="button" tabindex="0" onclick="work_getmslist()">
            Список необходмых прививок
        </div>
        <div class="custom-button" role="button" tabindex="1" onclick="work_getmslist()">
            Добавить прививку
        </div>
        <div class="custom-button" role="button" tabindex="1" onclick="document.location.href = 'ident.php'">
            ------------
        </div>
        <div class="custom-button" role="button" tabindex="1" onclick="document.location.href = 'ident.php'">
            -------------
        </div>

    </div>
    <div class="wmain_right">
        right
    </div>
</div>
<div class="footer"></div>

<script src="../js/work_index.js"></script>
<script src="../js/modul/xmls.js"></script>

</body>    
</html>
