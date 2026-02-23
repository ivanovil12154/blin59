<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Идентификация пользователя</title>
    <link rel="stylesheet" href="/css/style_main.css">
</head>

<body>
<div class="container_av">
    <h3 class="heading_av">Авторизуйтесь, пожалуйста!</h3> 
  <form method="post" name="iden">
    <input type="text" name="login"  class="form-control" placeholder="Ваш логин"/><br />
    <input type="password" name="pass"  class="form-control"  id="pass" placeholder="Ваш пароль"><br>	
    <input type="submit" class="btn-av" value="Продолжить" onclick="WM_IdentonKeySend()" />	
  </form>
</div>
<script src="js/wm_ident.js"></script>
</body>
</html>
