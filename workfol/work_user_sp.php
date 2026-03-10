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
  */

    echo ("<script>");
    if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
/*        echo ("let GIDUser=".$IDUser.";");
        echo ("let GUserFIO='".$UserName."';");
        echo ("let GUserLogin='';");
        echo ("let GSession='';");*/
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
        <div class="custom-button" role="button" tabindex="0" onclick="work_get_userlist()">
            Список персонала
        </div>
        <div class="custom-button" role="button" tabindex="0" onclick="KeyADDUser_click()">
            Добавить персонал
        </div>
        <div class="custom-button" role="button" tabindex="0" onclick="KeyEditUser_click()"">
            Изменить данные персонала
        </div>
        <div class="custom-button" role="button" tabindex="1" onclick="KeyEditMOO_click()">
            Настройка мед.осмотров
        </div>
        <div class="custom-button" role="button" tabindex="1" onclick="KeyADDMO_click()">
            Добавить мед.осмотр
        </div>
        <div class="custom-button" role="button" tabindex="1" onclick="KeyShowMO_click()">
            Просмотр мед.осмотров
        </div>

        <div class="custom-button" role="button" tabindex="1" onclick="KeyDelUser_click()">
            Удалить персонал
        </div>
        <div class="custom-button" role="button" tabindex="1" onclick="KeyGoMainMenu_click()">
            Основное меню
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
            <div class="custom-button" role="button" tabindex="0" onclick="KeyADDUserSave_click()">
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
            <div class="custom-button" role="button" tabindex="0" onclick="KeyEditMOOSave_click()">
                Сохранить
            </div>
            <div class="custom-button" role="button" tabindex="0" onclick="work_get_userlist()">
                Отмена
            </div>
        </div>
    </div>
<!--*******************  WiNDOWS **********************     -->            
<!--*******************   MOADD **********************     -->        
    <div id=win_user_MOADD>
        <div class="wmain_zag">
            Добавить мед.осмотр для 
        </div>
        <div class="form_edit">
            <div class="form_edit_c0">Тим MO</div>
            <div><select id="ListMOType" class= "edit_control_select" size="1" onchange="ListMO_change()">
                    <option value="0" dopinf = "adf">Не указана</option>
                </select>
            </div>
            <div class="form_edit_c0">Описание МО</div>
            <div id ="MO_desc">fasfasdf</div>

            <div class="form_edit_c0">Дата прохождения</div>
            <div><input type="date" name="date_from" class="edit_control"></div>
            <div class="form_edit_c0">Действует до</div>
            <div><input type="date" name="date_to" class="edit_control"></div>
            <div class="form_edit_c0">Примечание</div>
            <div>
                <input type="text" name="DopInf" class="edit_control" placeholder="Дополнительная информация">
            </div>
        </div>
        <div>
            <div class="custom-button" role="button" tabindex="0" onclick="KeyADDMOSave_click()">
                Добавить
            </div>
            <div class="custom-button" role="button" tabindex="0" onclick="work_get_userlist()">
                Отмена
            </div>
        </div>
    </div>
<!--*******************  WiNDOWS **********************     -->                
<!--*******************   User List **********************     -->        
    <div id = "win_showmo_list">
        <div class="wmain_zag">
            Список МО персонала 
        </div>

        <div class="grid" id="grid_list_showmo">           

	        <div class="grid-tr-0">
		    <div class="grid-td_mo">
		  	    <div class="item">МО</div>
		    </div>
		    <div class="grid-td_mo">
		        <div class="item">Дата с</div>
		    </div>
		    <div class="grid-td_mo">
			    <div class="item">Дата до</div>
		    </div>
		    <div class="grid-td_mo">
			    <div class="item">Кто внес(когда)</div>
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
<script src="../js/work_user_sp.js"></script>

</body>    
</html>
