<?php
    session_start();
    if(isset($_SESSION['reg'])) {
        header('Location: /akkaunt.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body class="text-center">
<form class="form-signin" method="post" id="mailForm">
    <h1 class="h3 mb-3 font-weight-normal">Вход</h1>
    <label for="login" class="sr-only">Логин</label>
    <input type="text" id="login" name="login" class="form-control" placeholder="Логин" required="" autofocus="">
    <label for="pass" class="sr-only">Пароль</label>
    <input type="password" id="pass" name="pass" class="form-control" placeholder="Пароль" required="">
    <div id="errorMess" style="color: red; font-size: 25px"></div>
    <button class="btn btn-lg btn-primary btn-block" type="button" id="sendAuth">Войти</button>
    <a href="registr.html"><p>Регистрация</p></a>
    <p class="mt-5 mb-3 text-muted">© 2017-2020</p>
</form>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/Sendauth.js"></script>
</body>
</html>