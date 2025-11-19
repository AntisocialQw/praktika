<?php
require_once 'server.php';

if (!isset($_SESSION['USER'])) {
    header('Location: login.php');
    exit();
}

$userName = $_SESSION['USER'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль - Фотостудия Lumiere</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    
    <section class="auth-section">
        <div class="container">
            <div class="auth-container">
                <div class="auth-form">
                    <h2>Личный кабинет</h2>
                    <p>Добро пожаловать, <?php echo htmlspecialchars($userName); ?>!</p>
                    <div class="profile-info">
                        <h3>Ваши данные</h3>
                        <p>Имя: <?php echo htmlspecialchars($userName); ?></p>
                        <p>Статус: Активный клиент</p>
                    </div>
                    <a href="logout.php" class="btn btn-outline">Выйти</a>
                </div>
            </div>
        </div>
    </section>
    
    <?php include 'partials/footer.php'; ?>
</body>
</html>