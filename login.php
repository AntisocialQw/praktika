<?php
require_once 'server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($phone) || empty($password)) {
        $error = "Пожалуйста, заполните все поля";
    } else {
        // Ищем пользователя по номеру телефона
        try {
            $stmt = $pdo->prepare("SELECT u.*, ar.Name as Access_level 
                                   FROM users u 
                                   JOIN access_rights ar ON u.ID_Access_rights = ar.ID_Access_rights 
                                   WHERE u.Phone = ?");
            $stmt->execute([$phone]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['Password'])) {
                // Сохраняем информацию о пользователе в сессию
                $_SESSION['USER'] = $user['Full_name'];
                $_SESSION['USER_ID'] = $user['ID_Users'];
                $_SESSION['USER_PHONE'] = $user['Phone'];
                $_SESSION['ACCESS_LEVEL'] = $user['Access_level'];
                
                // Перенаправляем на главную страницу
                header('Location: index.php');
                exit();
            } else {
                $error = "Неверный номер телефона или пароль";
            }
        } catch (PDOException $e) {
            $error = "Ошибка при входе: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход - Фотостудия Lumiere</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    
    <section class="auth-section">
        <div class="container">
            <div class="auth-form-single">
                <h2>Вход в личный кабинет</h2>
                
                <?php if (isset($error)): ?>
                    <div class="error-message active"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="phone">Номер телефона</label>
                        <div class="phone-input">
                            <span class="phone-prefix">+7</span>
                            <input type="tel" id="phone" name="phone" class="form-control" 
                                   placeholder="(999) 999-99-99" 
                                   value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <div class="password-input">
                            <input type="password" id="password" name="password" class="form-control" 
                                   placeholder="Введите пароль" required>
                            <button type="button" class="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" id="remember" name="remember">
                            <span class="checkmark"></span>
                            Запомнить меня
                        </label>
                        <a href="#forgot-password" class="forgot-password">Забыли пароль?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-full">Войти</button>
                    
                    <div class="auth-divider">
                        <span>или</span>
                    </div>
                    
                    <a href="registration.php" class="btn btn-outline btn-full">Создать аккаунт</a>
                </form>
            </div>
        </div>
    </section>
    
    <?php include 'partials/footer.php'; ?>
    
    <script src="js/auth.js"></script>
</body>
</html>