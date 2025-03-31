<?php
class Conexao {
    public static function conectar() {
        try {
            
            $conn = new PDO("mysql:host=localhost", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            
            $conn->exec("CREATE DATABASE IF NOT EXISTS db_carros");
            $conn->exec("USE db_carros");
            
            
            $sql = "CREATE TABLE IF NOT EXISTS carros (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                marca VARCHAR(100) NOT NULL,
                modelo VARCHAR(100) NOT NULL,
                ano INT(4) NOT NULL
            )";
            $conn->exec($sql);
            
            return $conn;
        } catch(PDOException $e) {
            echo "Falha na conexão: " . $e->getMessage();
            die();
        }
    }
}
?>