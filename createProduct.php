<?php
require_once 'server.php';

if (!isLoggedIn() || !hasAccess('Admin')) {
    echo "Ошибка: доступ запрещен";
    exit();
}

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Неверный метод запроса");
    }
    
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $service_id = $_POST['service_id'] ?? '';
    
    if (empty($title) || empty($service_id)) {
        throw new Exception("Не все обязательные поля заполнены");
    }
    
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Изображение не было загружено");
    }
    
    $image_url = upload_image($_FILES['image'], './product_images');
    
    $query = $pdo->prepare("INSERT INTO portfolio (ID_Services, Image_url, Title, Description) VALUES (?, ?, ?, ?)");
    $query->execute([$service_id, $image_url, $title, $description]);
    
    echo "1"; // Успех
    
} catch (Exception $e) {

    echo "Ошибка: " . $e->getMessage();
}
?>