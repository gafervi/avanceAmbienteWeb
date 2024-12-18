<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyBalance - Menú Lateral</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style_menu.css">
</head>
<body class="bg-light">
  <!-- Barra lateral -->
  <div id="sidebar-container"></div>
  <script>
    fetch('sidebar.php')
      .then(response => response.text())
      .then(html => {
        document.getElementById('sidebar-container').innerHTML = html;
      })
      .catch(error => console.error('Error al cargar el sidebar:', error));
  </script>

  <!-- Navbar superior -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm" style="margin-left: 250px;">
    <div class="container-fluid">
      <a href="#" class="navbar-brand">Ayuda</a>
    </div>
  </nav>

  <!-- Contenido principal -->
  <div class="container" style="margin-left: 250px; margin-top: 80px;">
    <div class="card shadow-lg" style="background-color: #494949f0; border-radius: 12px;">
      <div class="card-header text-white" style="background-color: #343a40; border-top-left-radius: 12px; border-top-right-radius: 12px;">
        <h1 class="h4 mb-0">Bienvenido a MyBalance </h1>
      </div>
      <div class="card-body text-white">
        <h2 class="h5">Si tienes problemas o necesitas ayuda en algún apartado, puedes escribirnos o enviarnos un correo.</h2>
        <p class="mt-3">
          <strong>Teléfono:</strong> 9999-9999 <br>
          <strong>Correo:</strong> 
          <a href="mailto:MyBalanceHelp@gmail.com" class="text-white text-decoration-underline">MyBalanceHelp@gmail.com</a>, 
          <a href="mailto:MyBalanceWeb@gmail.com" class="text-white text-decoration-underline">MyBalanceWeb@gmail.com</a>
        </p>
        <div class="mt-4">
          <a href="#" class="btn btn-outline-info">Llamanos</a>
          <a href="mailto:MyBalanceHelp@gmail.com" class="btn btn-outline-light">Enviar Correo</a>
          <a href="https://wa.me/+50688721679" class="btn btn-outline-success">Escríbenos por WhatsApp</a>

        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
