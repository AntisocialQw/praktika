<?php
require_once 'server.php';

if (!isLoggedIn() || !hasAccess('Admin')) {
    redir('login.php');
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $service_id = $_POST['service_id'] ?? '';
    
    if (empty($title) || empty($service_id)) {
        $error = "Пожалуйста, заполните все обязательные поля";
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = "Пожалуйста, выберите изображение для загрузки";
    } else {
        try {

            $image_url = upload_image($_FILES['image'], './product_images');
            

            $stmt = $pdo->prepare("INSERT INTO portfolio (ID_Services, Image_url, Title, Description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$service_id, $image_url, $title, $description]);
            
            $success = "Работа успешно добавлена в портфолио! Изображение загружено в каталог product_images.";
        } catch (Exception $e) {
            $error = "Ошибка при добавлении работы: " . $e->getMessage();
        }
    }
}


$services = $pdo->query("SELECT ID_Services, Name FROM services")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить работу в портфолио - Фотостудия Lumiere</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    
    <section class="auth-section">
        <div class="container">
            <div class="auth-form-single">
                <h2>Добавить работу в портфолио</h2>
                
                <?php if ($error): ?>
                    <div class="error-message active"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="success-message active"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Название работы *</label>
                        <input type="text" id="title" name="title" class="form-control" 
                               value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="service_id">Услуга *</label>
                        <select id="service_id" name="service_id" class="form-control" required>
                            <option value="">Выберите услугу</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?php echo $service['ID_Services']; ?>" 
                                    <?php echo (($_POST['service_id'] ?? '') == $service['ID_Services']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($service['Name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Описание работы</label>
                        <textarea id="description" name="description" class="form-control" 
                                  rows="4" placeholder="Опишите работу..."><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Изображение работы *</label>
                        <input type="file" id="image" name="image" class="form-control" 
                               accept="image/*" required>
                        <small>Поддерживаемые форматы: JPG, PNG, GIF. Максимальный размер: 5MB</small>
                    </div>
                    
                    <button type="submit" class="btn btn-full">Создать карточку работы</button>
                </form>
                
                <div style="margin-top: 30px; text-align: center;">
                    <a href="portfolio_manager.php" class="btn btn-outline">Посмотреть все работы</a>
                </div>
            </div>
        </div>
    </section>
    
    <?php include 'partials/footer.php'; ?>
    
    <script src="js/main.js"></script>
</body>
</html>