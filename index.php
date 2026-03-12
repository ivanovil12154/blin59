<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--
    <link rel="stylesheet" href="/css/style_work.css">
-->
    <link rel="stylesheet" href="/css/style_main.css">

    <title>Масленица в Березниках</title>
</head>

<body>

<div class="header">
    <div class="custom-button" role="button" tabindex="0" onclick="document.location.href = 'ident.php'">
        Войти
    </div>
</div>
<div class="wmain">
    <div class="wmain_left">
        <div class="custom-button" role="button" tabindex="0" onclick="KeyShowNews_click()">
            Новости
        </div>
        <div class="custom-button" role="button" tabindex="0" onclick="KeyShowMeny_click()">
            Меню
        </div>
        <div class="custom-button" role="button" tabindex="0" onclick="KeyShowKont_click()">
            Контакты
        </div>
        <div class="custom-button" role="button" tabindex="0" onclick="KeyShowVack_click()">
            Вакансии
        </div>
        <div class="custom-button" role="button" tabindex="0" onclick="KeyShowOffers_click()">
            Книга жалоб и предложений
        </div>
        <div class="custom-button" role="button" tabindex="0" onclick="KeyShowOffersGet_click()">
            Обратная связь
        </div>
    </div>
    <div class="wmain_right">
<!--*******************  WiNDOWS **********************     -->                
<!--*******************   News **********************     -->        
    <div id = "win_news" >
        <div>
            Новости
        </div>

        <div class="news_zag">
            11.03.2026 Не знаю что писать
        </div>
        <div class="news_body">
            Тут необходимо что то написать, пока не знаю что
        </div>

        <div class="news_zag">
            20.02.2026 Заработал сайт
        </div>
        <div class="news_body">
            Всех приветствую наконецто заработал этот сайт. 
        </div>
    </div>  
<!--*******************  WiNDOWS **********************     -->                
<!--*******************   meny **********************     -->        
    <div id = "win_menu" >
        <div>
            Меню
        </div>
        <div class="menu_body">
            Мороженное можно установить картинку. очень вкусно
        </div>
        <div class="menu_body">
            Блины еще вкуснее
        </div>
    </div>  

<!--*******************   Kontact **********************     -->        
    <div id = "win_kont" >
        <div>
            Контакты
        </div>
        <div class="kont_body">
            8(912)13123123  Директор <br>
            8(912)13123123  Зам директора <br>
            8(912)13123123  Зам зама директора <br>
        </div>
    </div>  

<!--*******************   Vaka **********************     -->        
    <div id = "win_vaka" >
        <div>
            Вакансии
        </div>
        <div class="vaka_body">
            Директор - зарплата огог какая<br>
            Зам директора - помогает тому кому нечего делать<br>
            Зам зама директора - проверка<br>
        </div>
    </div>  
<!--*******************  Offers  **********************     -->        
    <div id = "win_offers" >
        <div>
            Жалобы и предложения
        </div>

        <div class="offers_zag">
            11.03.2026 Игорь
        </div>
        <div class="offers_body">
            Кафе отличное, только нет сайта. Пригласите сделаю
        </div>

        <div class="offers_zag">
            20.02.2026 Сергей
        </div>
        <div class="offers_body">
            Класное кафе, очень все пондравилось
        </div>
    </div>  

   <!--*******************   get_offers **********************     -->        
    <div id=win_offers_get>
        <div class="wmain_zag">
            Обратная связь
        </div>
        <div class="form_offers">
            <div class="form_edit_c0">Имя</div>
            <div>
                <input type="text" name="fio" id="name" class="edit_control" placeholder="Имя">
            </div>
            <div class="form_edit_c0">Приватность</div>
            <div><select id="UserEditProf" name="prof" class= "edit_control_select" size="1">
                    <option value="0">Не публиковать (для администрации) </option>
                    <option value="1">Опубликовать </option>
                </select>
            </div>
            <div class="form_edit_c0">Электронная почта</div>
            <div>
                <input type="text" name="fio" id="name" class="edit_control" placeholder="email">
            </div>
            <div class="form_edit_c0">Телефон</div>
            <div>
                <input type="text" name="fio" id="name" class="edit_control" placeholder="телефон">
            </div>
        </div>
        <div> Текст </div>
        <textarea name="message" rows="5" cols="30">
            
        </textarea>
        <div>
            <div class="button_offers" role="button" tabindex="0" onclick="KeyADDUserSave_click()">
                Сохранить
            </div>
            <div class="button_offers" role="button" tabindex="0" onclick="work_get_userlist()">
                Отмена
            </div>
        </div>
    </div>
</div>    
</div>
<div class="footer"></div>

<script src="/js/index.js"></script>
<script src="/js/modul/xmls.js"></script>

</body>    
</html>