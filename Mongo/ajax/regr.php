<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->users_site1->users;

// Проверка существования пользователя
$existingUser = $collection->findOne([
    '$or' => [
        ['login' => $_POST['login']],
        ['email' => $_POST['email']]
    ]
]);

if ($existingUser) {
    echo "Пользователь уже существует";
    exit();
}

// Вставка нового пользователя
$insertResult = $collection->insertOne([
    'login' => $_POST['login'],
    'email' => $_POST['email'],
    'password' => password_hash($_POST['pass'], PASSWORD_DEFAULT),
    'created_at' => new MongoDB\BSON\UTCDateTime()
]);

echo "Пользователь успешно зарегистрирован, ID: " . $insertResult->getInsertedId();
?>