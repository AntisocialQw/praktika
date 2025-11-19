<?php
session_start();

class Database {
    private $host;
    private $db;
    private $user;
    private $passwd;
    private $charset;
    private $dbSettings;
    
    public function __construct($inifileName) {
        $this->dbSettings = parse_ini_file($inifileName);
        $this->host = $this->dbSettings['HOST'];
        $this->db = $this->dbSettings['DB'];
        $this->user = $this->dbSettings['USER'];
        $this->passwd = $this->dbSettings['PASSWD'];
        $this->charset = $this->dbSettings['CHARSET'];
    }

    public function connect() {
        return new PDO(
            "mysql:host=$this->host;dbname=$this->db;charset=$this->charset;",
            $this->user,
            $this->passwd,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    public function test($tbl) {
        $conn = $this->connect();
        $query = $conn->prepare("SELECT * FROM $tbl;");
        $query->execute();
        $response = $query->fetchAll();
        return $response;
    }
}

function redir($path) {
    header('Location: '.$path);
    exit();
}

// Функция для хэширования пароля
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Функция для проверки пароля
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

// Функция для проверки авторизации
function isLoggedIn() {
    return isset($_SESSION['USER_ID']);
}

// Функция для проверки прав доступа
function hasAccess($requiredLevel) {
    return isset($_SESSION['ACCESS_LEVEL']) && $_SESSION['ACCESS_LEVEL'] === $requiredLevel;
}

// Функция для получения информации о текущем пользователе
function getCurrentUser() {
    if (isset($_SESSION['USER_ID'])) {
        return [
            'id' => $_SESSION['USER_ID'],
            'name' => $_SESSION['USER'],
            'phone' => $_SESSION['USER_PHONE'],
            'access_level' => $_SESSION['ACCESS_LEVEL']
        ];
    }
    return null;
}

// Функция для выхода пользователя
function logout() {
    session_unset();
    session_destroy();
}

// Функция для загрузки изображения в папку product_images
function upload_image($file, $folder = './product_images') {
    // Создаем папку product_images, если её нет
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }
    
    // Проверяем тип файла
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $file_type = mime_content_type($file['tmp_name']);
    
    if (!in_array($file_type, $allowed_types)) {
        throw new Exception('Недопустимый формат изображения. Разрешены: JPG, PNG, GIF, WEBP');
    }
    
    // Проверяем размер файла (5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new Exception('Размер изображения не должен превышать 5MB');
    }
    
    // Генерируем уникальное имя файла
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = uniqid() . '_' . time() . '.' . $file_extension;
    $destination = "$folder/$name";
    
    // Копируем файл в указанную папку
    if (!copy($file['tmp_name'], $destination)) {
        throw new Exception("Ошибка при загрузке изображения");
    }
    
    return $destination;
}

// Функция для получения всех работ портфолио
function getPortfolioWorks($category_id = null) {
    global $pdo;
    
    $sql = "SELECT p.*, s.Name as service_name, c.Name as category_name 
            FROM portfolio p 
            JOIN services s ON p.ID_Services = s.ID_Services 
            JOIN services_category sc ON s.ID_Services = sc.ID_Services 
            JOIN category c ON sc.ID_Category = c.ID_Category";
    
    if ($category_id) {
        $sql .= " WHERE c.ID_Category = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$category_id]);
    } else {
        $stmt = $pdo->query($sql);
    }
    
    return $stmt->fetchAll();
}

$db = new Database('Server.ini');
$pdo = $db->connect();

// Инициализация сессии пользователя
if (isset($_SESSION['USER'])) {
    $USER = $_SESSION['USER'];
    $USER_ID = $_SESSION['USER_ID'];
    $USER_PHONE = $_SESSION['USER_PHONE'];
    $ACCESS_LEVEL = $_SESSION['ACCESS_LEVEL'];
    $IS_LOGGED_IN = true;
} else {
    $USER = NULL;
    $USER_ID = NULL;
    $USER_PHONE = NULL;
    $ACCESS_LEVEL = NULL;
    $IS_LOGGED_IN = false;
}

// Автоматическое обновление времени сессии
if ($IS_LOGGED_IN) {
    $_SESSION['LAST_ACTIVITY'] = time();
}

// Проверка времени жизни сессии (30 минут)
if ($IS_LOGGED_IN && isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    logout();
    redir('login.php?session=expired');
}
?>