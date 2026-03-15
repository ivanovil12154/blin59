<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_general.css">
    <link rel="stylesheet" href="../css/style_gridform.css">
    <link rel="stylesheet" href="../css/style_main.css">
    <link rel="stylesheet" href="../css/style_work.css">
    <link rel="stylesheet" href="../css/style_work_index.css">
    <title>Работа</title>
</head>

<body>
<?php
    require "../fphp/phpmain.php";    
    echo ("<script>");
    if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
//    if (true) {
        session_start();
        echo ("let GIDUser=".$_SESSION['iduser'].";");
        echo ("let GUserFIO='(".$_SESSION['username'].")';");
        echo ("let GUserLogin='".$_SESSION['userlogin']."';");
        echo ("let GSession='".$_SESSION['session']."';");
        $UserName = "(".$_SESSION['username'].")";
        session_write_close(); 
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
          echo($UserName);
    ?>    
    <div class="custom-button" role="button" tabindex="0" onclick="document.location.href = '../index.php'">
        Выйти
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
        <div class="custom-button" role="button" tabindex="0" onclick="KeyFileList_Click()">
            Просмотр файлов
        </div>
        <div class="custom-button" role="button" tabindex="0" onclick="KeyFileSaveForm_Click()">
            Загрузить файл
        </div>
    </div>
    <div class="wmain_right">
<!--*******************  WiNDOWS **********************     -->                
<!--*******************   MOOverdueList **********************     -->        
        <div id = "win_MOOverduelist">
            <div class="wmain_zag">
                Необходимые Мед.Осмотры 
            </div>
            <div class="wmain_serch">
                <input type="text" id="serch_fio">
                <input type="text" id="serch_offise">
                <input type="text" id="serch_mot">
                <div class="custom-button" role="button"onclick="KeyMOOverdue_Click()">
                      обновить
                </div>
            </div>    
            <div class="grid" id="grid_MOOverdueList">           
        <!--

	        <div class="grid-tr-0">
		    <div class="grid-td_mo">
		  	    <div class="item">Персонал</div>
		    </div>
		    <div class="grid-td_mo">
		        <div class="item">МО</div>
		    </div>
		    <div class="grid-td_mo">
			    <div class="item">Кол-во необходимо</div>
		    </div>
		    <div class="grid-td_mo">
			    <div class="item">Кол-во сдалано</div>
		    </div>
	            </div>
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
<!--*******************   FielSave **********************     -->        
        <div id="win_file_save" class = "win_form">
            <div class="wmain_zag">
                Загрузить файл
            </div>
            <div class="form_edit">
                <div class="form_edit_c0">Описание</div>
                <div>
                    <input type="text" id="IDFSDesc" class="edit_control" placeholder="Описание">
                </div>

                <div class="form_edit_c0">Видимость</div>
                <div>
                    <select id="IDSelectPrivilege" class= "edit_control_select" size="1">
                        <option value="All">Для всех</option>
                        <option value="ForAdmin">Для администраторов</option>
                    </select>
                </div>
                <div class="form_edit_c0">Файл</div>
                <input type="file" id="IDSaveFile" accept="*/*" />
            </div>
            <div>
                <div class="custom-button" role="button" tabindex="0" onclick="KeyFileSave_click()">
                    Сохранить
                </div>
                <div class="custom-button" role="button" tabindex="0" onclick="KeyCansel_click()">
                    Отмена
                </div>
            </div>    
        </div>
<!--*******************  WiNDOWS **********************     -->                
<!--*******************   FileList **********************     -->        
        <div id = "winFileList" class="win_list">
            <div class="wmain_zag">
                Просмотр файлов
            </div>
            <div class="wmain_serch">
                <input type="text" id="serch_fio">
                <input type="text" id="serch_offise">
                <input type="text" id="serch_mot">
                <div class="custom-button" role="button"onclick="KeyMOOverdue_Click()">
                      обновить
                </div>
            </div>    
            <div class="grid" id="grid_MOOverdueList">           
    	        <div class="grid-tr-0">
	        	    <div class="grid-td_mo">
		  	            <div class="item">Дата</div>
		            </div>
		            <div class="grid-td_mo">
		                <div class="item">Автор</div>
		            </div>
		            <div class="grid-td_mo">
			            <div class="item">Имя файла</div>
		            </div>
		            <div class="grid-td_mo">
			            <div class="item">Описание</div>
		            </div>
		            <div class="grid-td_mo">
			            <div class="item">Сохранить</div>
		            </div>
	            </div>
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
		            <div class="grid-td">
			            <div class="item">Блок №6</div>
		            </div>
		            <div class="grid-td">
			            <input type = "button">Сохранить</input>
		            </div>
	            </div>
            </div>
        </div>  
<!--*******************  WiNDOWS **********************     -->                


    </div>
</div>
<div class="footer"></div>

<script src="../js/work_index.js"></script>
<script src="../js/modul/xmls.js"></script>
<script src="../js/modul/general_fun.js"></script>


</body>    
</html>
