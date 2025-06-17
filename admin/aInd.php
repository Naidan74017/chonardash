<?php
require_once 'includes/auth.php';
requireAdminAuth();

$admin = getCurrentAdmin();
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Главная панель</h1>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Пользователи</h5>
                            <?php
                            $usersCount = $db->users->countDocuments();
                            ?>
                            <p class="card-text display-4"><?= $usersCount ?></p>
                            <a href="users.php" class="text-white">Управление пользователями</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Активные сессии</h5>
                            <?php
                            $activeSessions = $db->sessions->countDocuments([
                                'expiresAt' => ['$gt' => new MongoDB\BSON\UTCDateTime()],
                                'isRevoked' => false
                            ]);
                            ?>
                            <p class="card-text display-4"><?= $activeSessions ?></p>
                            <a href="sessions.php" class="text-white">Просмотр сессий</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Администраторы</h5>
                            <?php
                            $adminsCount = $db->users->countDocuments(['roles' => 'admin']);
                            ?>
                            <p class="card-text display-4"><?= $adminsCount ?></p>
                            <a href="users.php?role=admin" class="text-white">Управление администраторами</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>