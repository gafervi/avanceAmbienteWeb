<?php
$dsn = 'mysql:host=localhost;port=3306;dbname=sistema_contable';
$username = 'root'; // cambiar esto a el user configurado
$password = '1234'; // Cambia esto con la contraseña del user de la base de datos

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
