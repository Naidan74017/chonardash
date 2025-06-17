<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->auth_system;

// Регистрация пользователя
function registerUser($username, $email, $password) {
    global $db;
    
    // Проверка существования пользователя
    $existingUser = $db->users->findOne([
        '$or' => [
            ['username' => $username],
            ['email' => $email]
        ]
    ]);
    
    if ($existingUser) {
        return ['success' => false, 'message' => 'Username or email already exists'];
    }
    
    // Создание нового пользователя
    $result = $db->users->insertOne([
        'username' => $username,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'createdAt' => new MongoDB\BSON\UTCDateTime(),
        'updatedAt' => new MongoDB\BSON\UTCDateTime(),
        'roles' => ['user'],
        'isActive' => true,
        'auth' => [
            'lastLogin' => null,
            'failedAttempts' => 0,
            'lockUntil' => null
        ]
    ]);
    
    return ['success' => true, 'userId' => $result->getInsertedId()];
}

// Аутентификация пользователя
function loginUser($username, $password) {
    global $db;
    
    $user = $db->users->findOne(['username' => $username]);
    
    if (!$user || !password_verify($password, $user['password'])) {
        return ['success' => false, 'message' => 'Invalid credentials'];
    }
    
    if (!$user['isActive']) {
        return ['success' => false, 'message' => 'Account is disabled'];
    }
    
    // Создание сессии
    $token = bin2hex(random_bytes(32));
    $expiresAt = new MongoDB\BSON\UTCDateTime((time() + 86400) * 1000); // 24 часа
    
    $db->sessions->insertOne([
        'userId' => $user['_id'],
        'token' => $token,
        'ipAddress' => $_SERVER['REMOTE_ADDR'],
        'userAgent' => $_SERVER['HTTP_USER_AGENT'],
        'createdAt' => new MongoDB\BSON\UTCDateTime(),
        'expiresAt' => $expiresAt,
        'isRevoked' => false
    ]);
    
    // Обновление информации о последнем входе
    $db->users->updateOne(
        ['_id' => $user['_id']],
        [
            '$set' => [
                'auth.lastLogin' => new MongoDB\BSON\UTCDateTime(),
                'auth.failedAttempts' => 0
            ]
        ]
    );
    
    return ['success' => true, 'token' => $token, 'user' => $user];
}

// Пример использования
$registration = registerUser('test_user', 'test@example.com', 'secure_password');
$login = loginUser('test_user', 'secure_password');
?>