<?php
require_once 'includes/auth.php';

if (isset($_SESSION['admin_token'])) {
    global $db;
    $db->admin_sessions->updateOne(
        ['token' => $_SESSION['admin_token']],
        ['$set' => ['isRevoked' => true]]
    );
    
    unset($_SESSION['admin_token']);
}

header('Location: login.php');
exit();
?>