<?php
    session_start();
    $login = $_SESSION['login'];
    $email = $_SESSION['email'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Ваш аккаунт</title>
</head>
<body>
<div class="container">
    <h3>Вы зашли на свой аккаунт</h3>
    <p>Ваш логин: <?=$login?></p>
    <p>Ваш email: <?=$email?></p>
    <a href='ssilki/out.php'><p>Выйти из аккаунта</p></a>
    <a href='ssilki/delete.php'><p>Удалить аккаунт</p></a>
</div>
</body>
</html>