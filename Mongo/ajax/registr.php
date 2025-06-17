<?php
try {
    // Создаем менеджер подключений
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    
    // Проверяем подключение
    $command = new MongoDB\Driver\Command(['ping' => 1]);
    $manager->executeCommand('admin', $command);
    
    echo "Успешное подключение к MongoDB";
    
    // Пример использования (вставка документа)
    $bulk = new MongoDB\Driver\BulkWrite;
    $document = [
    $login = $_POST['login'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $repass = $_POST['repass'];
    ];
    
    $bulk->insert($document);
    $manager->executeBulkWrite('users_site1.users', $bulk);
    
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Ошибка подключения: ", $e->getMessage();
}
?>