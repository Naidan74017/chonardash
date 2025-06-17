<?php
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

$login = $_POST['login'];
$email = $_POST['email'];

// Проверка по логину
$filter = ['login' => $login];
$query = new MongoDB\Driver\Query($filter);
$cursor = $manager->executeQuery('users_site1.users', $query);

// Проверка по email
$filter = ['email' => $email];
$query = new MongoDB\Driver\Query($filter);
$cursor = $manager->executeQuery('users_site1.users', $query);

if (iterator_count($cursor) > 0) {
    echo "Пользователь с таким логином или email уже существует";
    exit();
}

// Продолжаем регистрацию...
?>