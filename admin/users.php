<?php
require_once 'includes/auth.php';
requireAdminAuth();

$roleFilter = $_GET['role'] ?? null;
$query = [];

if ($roleFilter) {
    $query['roles'] = $roleFilter;
}

$users = $db->users->find($query, [
    'sort' => ['createdAt' => -1],
    'limit' => 50
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle_active'])) {
        $userId = new MongoDB\BSON\ObjectId($_POST['user_id']);
        $user = $db->users->findOne(['_id' => $userId]);
        
        $db->users->updateOne(
            ['_id' => $userId],
            ['$set' => ['isActive' => !$user['isActive']]]
        );
        
        header('Location: users.php');
        exit();
    }
    
    if (isset($_POST['make_admin'])) {
        $userId = new MongoDB\BSON\ObjectId($_POST['user_id']);
        
        $db->users->updateOne(
            ['_id' => $userId],
            ['$addToSet' => ['roles' => 'admin']]
        );
        
        header('Location: users.php');
        exit();
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Управление пользователями</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="users.php" class="btn btn-sm btn-outline-secondary">Все пользователи</a>
                        <a href="users.php?role=admin" class="btn btn-sm btn-outline-primary">Администраторы</a>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Логин</th>
                            <th>Email</th>
                            <th>Роли</th>
                            <th>Статус</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['_id'] ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= implode(', ', $user['roles']) ?></td>
                            <td>
                                <?php if ($user['isActive']): ?>
                                    <span class="badge bg-success">Активен</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Заблокирован</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d.m.Y H:i', $user['createdAt']->toDateTime()->getTimestamp()) ?></td>
                            <td>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="user_id" value="<?= $user['_id'] ?>">
                                    <button type="submit" name="toggle_active" class="btn btn-sm btn-outline-<?= $user['isActive'] ? 'danger' : 'success' ?>">
                                        <?= $user['isActive'] ? 'Заблокировать' : 'Активировать' ?>
                                    </button>
                                </form>
                                
                                <?php if (!in_array('admin', $user['roles'])): ?>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="user_id" value="<?= $user['_id'] ?>">
                                    <button type="submit" name="make_admin" class="btn btn-sm btn-outline-primary">
                                        Сделать админом
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>