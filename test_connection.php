<?php
include 'includes/db.php';

try {
    $stmt = $conn->query("SHOW TABLES");
    echo "Conexión exitosa. Tablas disponibles:<br>";
    while ($row = $stmt->fetch()) {
        echo $row[0] . "<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
