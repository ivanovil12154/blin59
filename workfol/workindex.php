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
//  $UserName = 'Bdf';
  require "../fphp/phpmain.php";    
//  require "../fphp/AdminBDMainFun.php";    
/*
  $mysql = ConnBD();

  session_start();
  $IDUser = $_SESSION['idusert']; 
  $UserName = $_SESSION['username']; 
  $_SESSION['stwork'] = 'adminbd';
  session_write_close(); 
  echo ("<script> let LIDUser=".$IDUser."; let LUserName='".$UserName."' </script>");
/****************************** */
    echo ("<script>");
    if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
/*        echo ("let GIDUser=".$IDUser.";");
        echo ("let GUserFIO='".$UserName."';");
        echo ("let GUserLogin='';");
        echo ("let GSession='';");
        */
    } else {
        echo ("let GIDUser=".$_POST['VGIDUser'].";");
        echo ("let GUserFIO='".$_POST['VGUserFIO']."';");
        echo ("let GUserLogin='".$_POST['VGLogin']."';");
        echo ("let GSession='".$_POST['VGSession']."';");
        $UserName = $_POST['VGUserFIO'];
    };
    echo ("</script>");

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
        <div class="custom-button" role="button" tabindex="0"  onclick="KeyGoUserList()">
            Список персонала
        </div>

        <div class="custom-button" role="button" tabindex="0" onclick="KeyMOOverdue_Click()">
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
<!--*******************  WiNDOWS **********************     -->                
<!--*******************   MOOverdueList **********************     -->        
    <div id = "win_MOOverduelist">
        <div class="wmain_zag">
            Список МО персонала 
        </div>

        <div class="grid" id="grid_MOOverdueList">           

	        <div class="grid-tr-0">
		    <div class="grid-td_mo">
		  	    <div class="item">Персонал</div>
		    </div>
		    <div class="grid-td_mo">
		        <div class="item">МО</div>
		    </div>
		    <div class="grid-td_mo">
			    <div class="item">Кол-во в Жизни</div>
		    </div>
		    <div class="grid-td_mo">
			    <div class="item">Уже сдалано</div>
		    </div>
	    </div>
        <!--
    <div class="grid-tr" onclick="work_user_sel()">
		<div class="grid-td">
			<div class="item">Блок №4</div>
		</div>
		<div class="grid-td">
			<div class="item">Блок №5</div>
		</div>
		<div class="grid-td">
			<div class="item">Блок №6</div>
		</div>
	</div>
        -->

      </div>
    </div>  
    </div>
</div>
<div class="footer"></div>

<script src="../js/work_index.js"></script>
<script src="../js/modul/xmls.js"></script>

</body>    
</html>
