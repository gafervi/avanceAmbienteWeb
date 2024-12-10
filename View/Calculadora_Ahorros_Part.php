<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyBalance - Calculadora de Ahorros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style_menu.css">
  <link rel="stylesheet" href="assets/style_CalculadoraAhorros.css">
</head>
<body>

  <!-- Sidebar -->
  <div id="sidebar-container"></div>
  <script>
    fetch('sidebar.php')
      .then(response => response.text())
      .then(html => {
        document.getElementById('sidebar-container').innerHTML = html;
        document.getElementById('metas-ahorro-link').classList.add('active');
      })
      .catch(error => console.error('Error al cargar el sidebar:', error));
  </script>

  <!-- Barra fija -->
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <a href="#" class="navbar-brand d-flex align-items-center">
      <strong>Calculadora de Ahorros</strong>
    </a>
  </div>

  <!-- Contenido Principal -->
  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Crea y Administra tus Metas de Ahorro</h1>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <h5 class="card-title">Nueva Meta de Ahorro</h5>
        <form id="savingsForm">
          <div class="mb-3">
            <label for="goalName" class="form-label">Meta:</label>
            <input type="text" class="form-control" id="goalName" placeholder="Ejemplo: Comprar una bicicleta">
          </div>
          <div class="mb-3">
            <label for="goalAmount" class="form-label">Monto necesario:</label>
            <input type="number" class="form-control" id="goalAmount" placeholder="₡">
          </div>
          <div class="mb-3">
            <label for="goalTime" class="form-label">En cuánto tiempo:</label>
            <div class="input-group">
              <input type="number" class="form-control" id="goalTime" placeholder="Ingrese el tiempo">
              <select class="form-select" id="timeUnit">
                <option value="años">Años</option>
                <option value="meses">Meses</option>
                <option value="semanas">Semanas</option>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100">Agregar Meta</button>
        </form>
      </div>
    </div>

    <!-- Lista de las Metas rah -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Metas de Ahorro</h5>
        <ul class="list-group" id="savingsList"></ul>
      </div>
    </div>
  </main>

  <script src="assets/Calculadora_Ahorros.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
