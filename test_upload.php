<?php
// test_upload.php - тестирование загрузки
require_once 'server.php';

echo "<h1>Тест системы загрузки</h1>";

// Проверяем папку product_images
$folder = './product_images';
if (!file_exists($folder)) {
    echo "<p>Папка $folder не существует. Пытаемся создать...</p>";
    if (mkdir($folder, 0777, true)) {
        echo "<p style='color: green;'>Папка создана успешно</p>";
    } else {
        echo "<p style='color: red;'>Ошибка создания папки</p>";
    }
} else {
    echo "<p style='color: green;'>Папка $folder существует</p>";
}

// Проверяем права на запись
if (is_writable($folder)) {
    echo "<p style='color: green;'>Папка доступна для записи</p>";
} else {
    echo "<p style='color: red;'>Папка НЕ доступна для записи</p>";
}

// Проверяем подключение к базе
try {
    $test = $pdo->query("SELECT COUNT(*) as count FROM services")->fetch();
    echo "<p style='color: green;'>База данных подключена. Услуг: " . $test['count'] . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>Ошибка базы данных: " . $e->getMessage() . "</p>";
}

// Проверяем таблицу portfolio
try {
    $test = $pdo->query("SELECT COUNT(*) as count FROM portfolio")->fetch();
    echo "<p>Работ в портфолио: " . $test['count'] . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>Ошибка таблицы portfolio: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='control.php'>Перейти к форме добавления</a></p>";
echo "<p><a href='portfolio_manager.php'>Перейти к управлению работами</a></p>";
?>