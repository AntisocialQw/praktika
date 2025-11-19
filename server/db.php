<?php

class DB
{
    private $db;

    public function __construct()
    {
        $host = 'localhost';
        $db = 'lumiere_studio';
        $user = 'root';
        $pass = '';
        $charSet = 'utf8';
        
        $this->db = new PDO("mysql:host=$host;dbname=$db;charset=$charSet", $user, $pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $params = [])
    {

        $stmt = $this->db->prepare($sql);

        // Обход массива с параметрами и подставление значений
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }


        $stmt->execute();
        
        // Получение ответа
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}