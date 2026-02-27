<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_main.css">
    <link rel="stylesheet" href="../css/style_work.css">
    <title>Список персонала</title>
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
        <div class="custom-button" role="button" tabindex="0" onclick="work_getuserlist()">
            Добавить персонал
        </div>

        <div class="custom-button" role="button" tabindex="0" onclick="work_useredit()">
            Изменить данные персонала
        </div>
        <div class="custom-button" role="button" tabindex="1" onclick="work_getmslist()">
            Удалить персонал
        </div>
    </div>
    <div class="wmain_right">
        <div id="user_list">
            <div class="wmain_zag">
                Список персонала
            </div>
            <div class="wmain_grid" id = "grid_user_list">
                <div class="grid_row_0">Фамили И.О.</div>
                <div class="grid_row_0">Должность</div>
                <div class="grid_row_0" >Мето работы</div>
            </div>
        </div>

        <div id=user_edit>
            <div class="wmain_zag">
                Изменение данных персонала
            </div>
            <div>

        <input type="text" class="form-control" name="name" id="name" placeholder="Ваше имя"><br>
        <input type="password" class="form-control" name="pass" id="pass" placeholder="Ваш пароль"><br>


        <select name="staff" size="1">
            <option >Тварь дрожащая или право имеешь?</option>
            <?
/*            $mysql = new mysqli('localhost', 'irina', '1998@01@31', 'bdsweetjoy');
			// проверка
			if ($mysql == false){
               print("Ошибка1: Невозможно подключиться к MySQL " . mysqli_connect_error());
               exit;
            };
            $res = mysql_query($mysql, "SELECT StSurname, StName From TStaff");
			if (!$res){
			  print("Ошибка в запросе");
              exit;			  
			}
            while($row = mysql_fetch_assoc($res)){
				echo ($row[0].$row[1]);		
                <option value="<?=$row[0]?>"><?=$row[0]?></option>
*/                
            
            ?>
        </select>



                <div>Фамилия И.О.

                </div>
                <div>Должность



                </div>
                <div>Место работы



                </div>
            </div>
        </div>


    </div>
<div class="footer"></div> 

<script src="../js/work_index.js"></script>
<script src="../js/modul/xmls.js"></script>
<script src="../js/work_user_sp.js"></script>

</body>    
</html>
