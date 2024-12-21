<?php
class UserModel {

    // Método para iniciar sesión
    public static function login($data) {
        // Verificar si los datos de inicio de sesión son correctos
        // Consulta SQL y lógica para verificar el usuario
    }

    // Método para registrar un usuario
    public static function register($data) {
        // Asegurarse de que los datos necesarios estén presentes
        if (!isset($data['email']) || !isset($data['password'])) {
            return ['error' => 'Datos incompletos'];
        }

        $email = $data['email'];
        $password = $data['password'];
        $name = $data['name']; // Suponiendo que se pasa el nombre

        // Conectar a la base de datos
        require_once('../DataBase/conexion.php');

        // Consulta SQL para insertar el nuevo usuario
        $sql = "INSERT INTO usuarios (nombre, correo, password) VALUES ('$name', '$email', '$password')";

        // Ejecutar la consulta
        $result = conexionDB::getData($sql);

        // Verificar si la inserción fue exitosa
        if ($result) {
            return ['user' => $data]; // Si la inserción es exitosa, devolver los datos del usuario
        } else {
            return ['error' => 'Error al registrar usuario'];
        }
    }
}
?>
