<?php
    session_start();
    $login = $_SESSION['login'];
    $mysqli = new mysqli("localhost", "root", "root", "users_site1");
    $mysqli->query("SET NAMES 'utf8'");
    $mysqli->query("DELETE FROM `users` WHERE `users`.`login` = '$login'");
    session_destroy();

    header('Location: /index.html');
?>