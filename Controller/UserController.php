<?php
require_once('../Model/UserModel.php'); // Asegúrate de incluir el modelo

class UserController {

    // Método para el login
    public static function login($data) {
        try {
            $response = UserModel::login($data); // Llamar al modelo para realizar el login

            if (isset($response['user'])) {
                // Si el login es exitoso
                session_start();
                $_SESSION['user'] = $response['user'];
                header('Location: ../views/overview.php');
            } else {
                // Si el login falla
                echo '<div class="alert alert-danger">Error: ' . $response['error'] . '</div>';
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Método para el registro
    public static function register($data) {
        try {
            $response = UserModel::register($data); // Llamar al modelo para realizar el registro

            if (isset($response['user'])) {
                // Registro exitoso
                echo '<div class="alert alert-success">Cuenta creada con éxito. Puedes iniciar sesión ahora.</div>';
            } else {
                // Si hay un error
                echo '<div class="alert alert-danger">Error al registrar usuario: ' . $response['error'] . '</div>';
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>
