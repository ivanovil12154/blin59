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
        <div class="custom-button" role="button" tabindex="0" onclick="work_get_userlist()">
            Список персонала
        </div>
        <div class="custom-button" role="button" tabindex="0" onclick="work_user_add()">
            Добавить персонал
        </div>
        <div class="custom-button" role="button" tabindex="0" onclick="work_user_edit()">
            Изменить данные персонала
        </div>
        <div class="custom-button" role="button" tabindex="1" onclick="work_user_edit_MO()">
            Настройка мед.осмотров
        </div>

        <div class="custom-button" role="button" tabindex="1" onclick="work_user_del()">
            Удалить персонал
        </div>
    </div>
    <div class="wmain_right">
<!--*******************  WiNDOWS **********************     -->                
<!--*******************   User List **********************     -->        
    <div id = "user_list">
        <div class="wmain_zag">
            Список персонала
        </div>

        <div class="grid" id="user_list_gird">
	        <div class="grid-tr-0">
		    <div class="grid-td">
		  	    <div class="item">Фамили И.О.</div>
		    </div>
		    <div class="grid-td">
		        <div class="item">Должность</div>
		    </div>
		    <div class="grid-td">
			    <div class="item">Мето работы</div>
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
<!--*******************  WiNDOWS **********************     -->            
<!--*******************   User Edit **********************     -->        
    <div id=win_user_edit>
        <div class="wmain_zag">
            Изменение данных персонала
        </div>
        <div class="form_edit">
            <div class="form_edit_c0">Фамилия И.О.</div>
            <div>
                <input type="text" name="fio" id="name" class="edit_control" placeholder="Фамилия И.О.">
            </div>
            <div class="form_edit_c0">Должность</div>
            <div><select id="UserEditProf" name="prof" class= "edit_control_select" size="1">
                    <option value="0">Не указана</option>
                </select>
            </div>
            <div class="form_edit_c0">Место работы</div>
            <div>
                <select name="offi" id="UserEditOffi" class= "edit_control_select" size="1">
                    <option value="0" >Не указано</option>
                </select>
            </div>
            <div class="form_edit_c0">Логин</div>
            <div><input type="text" name="login" class="edit_control" placeholder="Логин"></div>
            <div class="form_edit_c0">Пароль</div>
            <div><input type="text" name="password" class="edit_control" placeholder="Пароль"></div>
            <div class="form_edit_c0">Status</div>
            <div><input type="text" name="status" class="edit_control" placeholder="Status"></div>
            <div class="form_edit_c0">ДР</div>
            <div><input type="date" name="date_birth" class="edit_control" placeholder="Дата рождения"></div>
            <div class="form_edit_c0">Дата приема на работу</div>
            <div><input type="date" name="date_begin" class="edit_control" placeholder="Дата приема на работу"></div>
        </div>
        <div>
            <div class="custom-button" role="button" tabindex="0" onclick="work_click_save_form()">
                Сохранить
            </div>
            <div class="custom-button" role="button" tabindex="0" onclick="work_get_userlist()">
                Отмена
            </div>
        </div>
    </div>

<!--*******************  WiNDOWS **********************     -->        
<!--*******************   User Edit MO Obligate **********************     -->        
    <div id=win_user_edit_MOO>
        <div class="wmain_zag">
            Настройка мед.осмотров - 
        </div>
        <div class="form_edit_MO">
<!--            
            <div class="form_edit_c0">Фамилия И.О.</div>
            <div>
                <input type="checkbox" class="edit_control">
            </div>
            <div class="form_edit_c0">Фамилия И.О.</div>
            <div>
                <input type="checkbox" name="fio" class="edit_control" placeholder="Фамилия И.О.">
            </div>
-->
        </div>
        <div>
            <div class="custom-button" role="button" tabindex="0" onclick="click_edit_moo_save()">
                Сохранить
            </div>
            <div class="custom-button" role="button" tabindex="0" onclick="work_get_userlist()">
                Отмена
            </div>
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
