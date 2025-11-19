<?php
require_once 'server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    
    // Проверяем, что все обязательные поля заполнены
    if (empty($phone) || empty($password) || empty($full_name)) {
        $error = "Пожалуйста, заполните все обязательные поля";
    } else {
        // Проверяем существование пользователя с таким телефоном
        try {
            $stmt = $pdo->prepare("SELECT ID_Users FROM users WHERE Phone = ?");
            $stmt->execute([$phone]);
            $existing_user = $stmt->fetch();
            
            if ($existing_user) {
                $error = "Пользователь с таким номером телефона уже существует";
            } else {
                // Хэшируем пароль
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Создаем новую запись пользователя (по умолчанию права User - ID 2)
                $stmt = $pdo->prepare("INSERT INTO users (ID_Access_rights, Phone, Password, Email, Full_name) VALUES (2, ?, ?, ?, ?)");
                $stmt->execute([$phone, $hashed_password, $email, $full_name]);
                
                $success = "Регистрация прошла успешно! Теперь вы можете войти в систему.";
            }
        } catch (PDOException $e) {
            $error = "Ошибка при регистрации: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация - Фотостудия Lumiere</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    
    <section class="auth-section">
        <div class="container">
            <div class="auth-form-single">
                <h2>Регистрация</h2>
                
                <?php if (isset($error)): ?>
                    <div class="error-message active"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="success-message active"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="full_name">Имя и фамилия *</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" 
                               value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Номер телефона *</label>
                        <div class="phone-input">
                            <span class="phone-prefix">+7</span>
                            <input type="tel" id="phone" name="phone" class="form-control" 
                                   placeholder="(999) 999-99-99" 
                                   value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Пароль *</label>
                        <div class="password-input">
                            <input type="password" id="password" name="password" class="form-control" 
                                   placeholder="Минимум 6 символов" required minlength="6">
                            <button type="button" class="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-full">Зарегистрироваться</button>
                    
                    <div class="auth-divider">
                        <span>или</span>
                    </div>
                    
                    <a href="login.php" class="btn btn-outline btn-full">Войти в аккаунт</a>
                </form>
            </div>
        </div>
    </section>
    
    <?php include 'partials/footer.php'; ?>
    
    <script src="js/auth.js"></script>
</body>
</html>