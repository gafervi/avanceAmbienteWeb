<?php
require_once('../Controller/UserController.php');

// Variable para los mensajes
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar inicio de sesión
    if (isset($_POST['login'])) {
        $correo = $_POST['correo'];
        $password = $_POST['password'];
        $result = UserController::login($correo, $password);

        if ($result) {
            // Redirigir si el inicio de sesión es exitoso
            header('location: overview.php');
            exit;
        } else {
            // Mostrar mensaje de error si el inicio de sesión falla
            $message = 'Usuario o contraseña incorrectos. Por favor, intente de nuevo.';
            $messageType = 'danger';
        }
    }

    // Manejar registro
    if (isset($_POST['register'])) {
        $data = [
            'nombre' => $_POST['nombre'],
            'correo' => $_POST['correo'],
            'telefono' => $_POST['telefono'],
            'password' => $_POST['password'],
            'confirmPassword' => $_POST['confirmPassword']
        ];
        $result = UserController::register($data);

        if ($result === true) {
            // Mostrar mensaje de éxito si el registro fue exitoso
            $message = '¡Cuenta creada exitosamente! Ahora puede iniciar sesión.';
            $messageType = 'success';
        } else {
            // Mostrar mensaje de error si el registro falla
            $message = $result; // El controlador retorna el mensaje de error
            $messageType = 'danger';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyBalance - Inicio de Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style_menu.css">
</head>
<body>
  <!-- Llamado de la sidebar -->
  <div id="sidebar-container"></div>
  <script>
    fetch('sidebar.php')
      .then(response => response.text())
      .then(html => {
        document.getElementById('sidebar-container').innerHTML = html;
        document.getElementById('home-link').classList.add('active');
      })
      .catch(error => console.error('Error al cargar el sidebar:', error));
  </script>

  <!-- parte de arriba -->
  <div class="navbar navbar-dark bg-dark shadow-sm" style="margin-left: 250px;">
    <a href="#" class="navbar-brand d-flex align-items-center">
      <strong>MyBalance</strong>
    </a>
  </div>

  <!-- Mensaje de error o éxito -->
  <?php if (!empty($message)): ?>
  <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
    <strong><?= $messageType === 'success' ? '¡Éxito!' : 'Error' ?></strong> <?= $message ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>

  <!-- lo del menu -->
  <div class="content" style="margin-left: 250px;">
    <div class="form-container">
      <h2 id="form-title" class="text-center mb-4">Iniciar Sesión</h2>
      
      <form method="POST" id="login-form">
        <div class="mb-3">
          <label for="loginEmail" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" name="correo" id="loginEmail" placeholder="ejemplo@correo.com" required>
        </div>
        <div class="mb-3">
          <label for="loginPassword" class="form-label">Contraseña</label>
          <input type="password" class="form-control" name="password" id="loginPassword" placeholder="Contraseña" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Iniciar Sesión</button>
      </form>

      <form method="POST" id="register-form" style="display: none;">
        <div class="mb-3">
          <label for="registerName" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" id="registerName" placeholder="Nombre" required>
        </div>
        <div class="mb-3">
          <label for="registerEmail" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" name="correo" id="registerEmail" placeholder="ejemplo@correo.com" required>
        </div>
        <div class="mb-3">
          <label for="registerPhone" class="form-label">Número Telefónico</label>
          <input type="text" class="form-control" name="telefono" id="registerPhone" placeholder="8888 8888" required>
        </div>
        <div class="mb-3">
          <label for="registerPassword" class="form-label">Contraseña</label>
          <input type="password" class="form-control" name="password" id="registerPassword" placeholder="Contraseña" required>
        </div>
        <div class="mb-3">
          <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
          <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirmar Contraseña" required>
        </div>
        <button type="submit" name="register" class="btn btn-success w-100">Registrar</button>
      </form>

      <div class="text-center mt-3">
        <button id="toggle-button" class="btn btn-link text-light">¿No tienes cuenta? Regístrate aquí</button>
      </div>
    </div>
  </div>

  <script>
    const toggleButton = document.getElementById('toggle-button');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const formTitle = document.getElementById('form-title');

    toggleButton.addEventListener('click', () => {
      if (loginForm.style.display === 'none') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        formTitle.textContent = 'Iniciar Sesión';
        toggleButton.textContent = '¿No tienes cuenta? Regístrate aquí';
      } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        formTitle.textContent = 'Registrar Cuenta';
        toggleButton.textContent = '¿Ya tienes cuenta? Inicia sesión aquí';
      }
    });
  </script>
</body>
</html>
