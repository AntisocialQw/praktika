<?php
$isLoggedIn = isset($_SESSION['USER']);
$userName = $isLoggedIn ? $_SESSION['USER'] : null;
$base_url = '/lumiere';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фотостудия Lumiere - Профессиональная фотосъемка</title>
    
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="icon" type="image/x-icon" href="<?php echo $base_url; ?>/images/favicon.ico">
</head>
<body>
    <header>
        <div class="container header-container">
            <a href="<?php echo $base_url; ?>/index.php" class="logo">Lumi<span>ere</span></a>
            <nav>
                <ul>
                    <li><a href="<?php echo $base_url; ?>/index.php#home">Главная</a></li>
                    <li><a href="<?php echo $base_url; ?>/index.php#about">О нас</a></li>
                    <li><a href="<?php echo $base_url; ?>/index.php#services">Услуги</a></li>
                    <li><a href="<?php echo $base_url; ?>/index.php#portfolio">Портфолио</a></li>
                    <li><a href="<?php echo $base_url; ?>/index.php#team">Команда</a></li>
                    <li><a href="<?php echo $base_url; ?>/index.php#contact">Контакты</a></li>
                    <li id="authSection">
                        <?php if ($isLoggedIn): ?>
                            <div class="user-menu">
                                <span class="user-greeting">Привет, <?php echo htmlspecialchars($userName); ?></span>
                                <div class="user-dropdown">
                                    <a href="<?php echo $base_url; ?>/profile.php">Профиль</a>
                                    <a href="<?php echo $base_url; ?>/logout.php">Выйти</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo $base_url; ?>/login.php" class="auth-link">
                                <i class="fas fa-user"></i>
                                <span>Войти</span>
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>