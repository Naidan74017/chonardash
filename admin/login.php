<?php
require_once 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $user = $db->users->findOne([
        'username' => $username,
        'roles' => 'admin'
    ]);
    
    if ($user && password_verify($password, $user['password'])) {
        // Создаем сессию
        $token = bin2hex(random_bytes(32));
        $expiresAt = new MongoDB\BSON\UTCDateTime((time() + 3600) * 1000); // 1 час
        
        $db->admin_sessions->insertOne([
            'userId' => $user['_id'],
            'token' => $token,
            'ipAddress' => $_SERVER['REMOTE_ADDR'],
            'userAgent' => $_SERVER['HTTP_USER_AGENT'],
            'createdAt' => new MongoDB\BSON\UTCDateTime(),
            'expiresAt' => $expiresAt,
            'isRevoked' => false
        ]);
        
        $_SESSION['admin_token'] = $token;
        header('Location: index.php');
        exit();
    } else {
        $error = "Неверные учетные данные";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в панель администратора</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Панель администратора</h2>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Логин</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Войти</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>