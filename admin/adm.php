<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// Подключение к MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->auth_system;

// Проверка авторизации
function isAdminLoggedIn() {
    if (!isset($_SESSION['admin_token'])) {
        return false;
    }
    
    global $db;
    $session = $db->admin_sessions->findOne([
        'token' => $_SESSION['admin_token'],
        'isRevoked' => false,
        'expiresAt' => ['$gt' => new MongoDB\BSON\UTCDateTime()]
    ]);
    
    return $session !== null;
}

// Перенаправление если не авторизован
function requireAdminAuth() {
    if (!isAdminLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Получение текущего администратора
function getCurrentAdmin() {
    if (!isAdminLoggedIn()) return null;
    
    global $db;
    $session = $db->admin_sessions->findOne([
        'token' => $_SESSION['admin_token']
    ]);
    
    return $db->users->findOne([
        '_id' => $session['userId'],
        'roles' => 'admin'
    ]);
}
?>