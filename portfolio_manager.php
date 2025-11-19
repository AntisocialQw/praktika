<?php
// portfolio_manager.php - управление работами портфолио
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'server.php';

// Проверяем авторизацию (временно отключим для теста)
// if (!isLoggedIn()) {
//     header('Location: login.php');
//     exit();
// }

$success = '';
$error = '';

// Обработка удаления работы
if (isset($_GET['delete'])) {
    $work_id = (int)$_GET['delete'];
    
    try {
        // Получаем информацию о работе
        $stmt = $pdo->prepare("SELECT Image_url FROM portfolio WHERE ID_Portfolio = ?");
        $stmt->execute([$work_id]);
        $work = $stmt->fetch();
        
        if ($work) {
            // Удаляем изображение
            if (file_exists($work['Image_url'])) {
                unlink($work['Image_url']);
            }
            
            // Удаляем запись из базы
            $stmt = $pdo->prepare("DELETE FROM portfolio WHERE ID_Portfolio = ?");
            $stmt->execute([$work_id]);
            
            $success = "✅ Работа успешно удалена";
        } else {
            $error = "❌ Работа не найдена";
        }
    } catch (Exception $e) {
        $error = "❌ Ошибка при удалении: " . $e->getMessage();
    }
}

// Получаем все работы
try {
    $works = $pdo->query("
        SELECT p.*, s.Name as service_name 
        FROM portfolio p 
        JOIN services s ON p.ID_Services = s.ID_Services 
        ORDER BY p.ID_Portfolio DESC
    ")->fetchAll();
} catch (Exception $e) {
    $error = "Ошибка загрузки работ: " . $e->getMessage();
    $works = [];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление портфолио - Фотостудия Lumiere</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    
    <section class="auth-section">
        <div class="container">
            <div class="auth-form-single">
                <h2>📊 Управление работами портфолио</h2>
                
                <?php if ($error): ?>
                    <div class="error-message active"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="success-message active"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <div style="margin-bottom: 20px; text-align: center;">
                    <a href="control.php" class="btn">➕ Добавить новую работу</a>
                    <a href="index.php" class="btn btn-outline" style="margin-left: 10px;">🏠 На главную</a>
                </div>
                
                <?php if (empty($works)): ?>
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <i class="fas fa-images" style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;"></i>
                        <h3>Работ пока нет</h3>
                        <p>Добавьте первую работу в портфолио</p>
                        <a href="control.php" class="btn">Добавить работу</a>
                    </div>
                <?php else: ?>
                    <div class="portfolio-grid">
                        <?php foreach ($works as $work): ?>
                            <div class="portfolio-item">
                                <img src="<?php echo htmlspecialchars($work['Image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($work['Title']); ?>"
                                     onerror="this.src='https://via.placeholder.com/300x200?text=Изображение+не+найдено'">
                                <div class="portfolio-overlay">
                                    <h3><?php echo htmlspecialchars($work['Title']); ?></h3>
                                    <p><?php echo htmlspecialchars($work['Description']); ?></p>
                                    <p><strong>🎯 Услуга:</strong> <?php echo htmlspecialchars($work['service_name']); ?></p>
                                    <div style="margin-top: 15px;">
                                        <a href="?delete=<?php echo $work['ID_Portfolio']; ?>" 
                                           class="btn btn-outline" 
                                           onclick="return confirm('❓ Вы уверены, что хотите удалить эту работу?')">
                                            🗑️ Удалить
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <?php include 'partials/footer.php'; ?>
</body>
</html>